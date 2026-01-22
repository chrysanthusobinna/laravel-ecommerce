<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Traits\ImageHandlerTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;

class CategoryController extends Controller
{
    use AdminViewSharedDataTrait;
    use ImageHandlerTrait;

    public function __construct()
    {
        $this->shareAdminViewData();
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload($validated['image'], 'categories');
        }

        Category::create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($category->image)) {
                $imagePath = storage_path('app/public/' . ltrim($category->image, '/'));
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $validated['image'] = $this->handleImageUpload($validated['image'], 'categories');
        }

        $category->update($validated);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (!empty($category->image)) {
            $imagePath = storage_path('app/public/' . ltrim($category->image, '/'));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
