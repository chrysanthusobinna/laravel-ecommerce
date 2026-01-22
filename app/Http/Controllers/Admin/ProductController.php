<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\ProductLabel;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\Traits\ImageHandlerTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;

class ProductController extends Controller
{
    use AdminViewSharedDataTrait;
    use ImageHandlerTrait;


    public function __construct()
    {
        $this->shareAdminViewData();
        
    }
    
    public function list(Request $request, $category_id = null)
    {
        if ($category_id) {
            $category = Category::findOrFail($category_id);
            $query = Product::with(['primaryImage', 'images'])->where('category_id', $category_id);
        } else {
            $category = null;
            $query = Product::with(['primaryImage', 'images']);
        }
        
        // Handle search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        $products = $query->paginate(10);
        $categories = Category::all(); // For dropdown in modals
        return view('admin.products-list', compact('products', 'category', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products-show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'sizes', 'label'])->findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();
        $labels = ProductLabel::all();

        return view('admin.products-edit', compact('product', 'categories', 'sizes', 'labels'));
    }

    public function create($category_id)
    {
        $category = Category::findOrFail($category_id);
        $categories = Category::all();
        $sizes = Size::all();
        $labels = ProductLabel::all();
        return view('admin.products-create', compact('categories', 'category', 'sizes', 'labels'));
    }


    public function store(ProductRequest $request, $category_id)
    {
        $validated = $request->validated();
        
        // Ensure category_id from route is used
        $validated['category_id'] = $category_id;

        $product = Product::create($validated);

        if ($request->has('sizes')) {
            $product->sizes()->attach($request->sizes);
        }

        if ($request->has('product_label_id')) {
            $product->label_id = $request->product_label_id;
            $product->save();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $this->handleImageUpload($image, 'products');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);

                // First image is automatically set as primary
            }
        }

        return redirect()->route('admin.products.list', $category_id)->with('success', 'Product created successfully!');
    }

    

    public function update(ProductRequest $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $validated = $request->validated();

        $product->update($validated);

        // Sync sizes
        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        } else {
            // If no sizes are provided, detach all existing sizes
            $product->sizes()->detach();
        }
 
        // Sync labels
        if ($request->has('product_label_id')) {
            $product->product_label_id = $request->product_label_id;
            $product->save(); 
        } else {
            // If no label is provided, remove existing label
            $product->product_label_id = null;
            $product->save(); // Save the product after disassociating the label
        }

        // Handle image deletion
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    // Delete file
                    $imagePath = storage_path('app/public/' . ltrim($image->path, '/'));
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }
            }
        }

        // Handle primary image update
        if ($request->has('primary_image_id')) {
            // Remove primary from all images
            $product->images()->update(['is_primary' => false]);
            
            // Set new primary
            $primaryImage = ProductImage::find($request->primary_image_id);
            if ($primaryImage && $primaryImage->product_id == $product->id) {
                $primaryImage->update(['is_primary' => true]);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentMaxOrder = (int) $product->images()->max('sort_order');
            $startOrder = $currentMaxOrder >= 0 ? $currentMaxOrder + 1 : 0;

            foreach ($request->file('images') as $index => $image) {
                $path = $this->handleImageUpload($image, 'products');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'sort_order' => $startOrder + $index,
                    'is_primary' => false,
                ]);
            }
        }

        // Ensure at least one primary image exists
        $primaryImage = $product->images()->where('is_primary', true)->first();
        if (!$primaryImage && $product->images()->count() > 0) {
            $firstImage = $product->images()->orderBy('sort_order')->first();
            $firstImage->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Product updated successfully!');
    }


 

public function destroy($id)
{
    $product = Product::with('images')->findOrFail($id);
    $category_id = $product->category_id;

    foreach ($product->images as $img) {
        $imagePath = storage_path('app/public/' . ltrim($img->path, '/'));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // All images are handled through product_images table

    $product->delete();

    return redirect()->route('admin.products.list', $category_id)->with('success', 'Product deleted successfully!');
}



}
