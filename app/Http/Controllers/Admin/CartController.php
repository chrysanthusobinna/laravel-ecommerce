<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Size;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CartTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;

class CartController extends Controller
{
    use AdminViewSharedDataTrait;
    use CartTrait;


    public function __construct()
    {
        $this->shareAdminViewData();
        
    }
    
    public function index($category_id = null)
    {
        // $products = Product::with(['primaryImage', 'images', 'sizes', 'category', 'label'])->get();
        // $sizes = Size::all();
        // $categories = Category::all();
        // return view('admin.pos-index', compact('products', 'sizes', 'categories'));

        if ($category_id) {
            $category = Category::findOrFail($category_id);
            $query = Product::with(['primaryImage', 'images', 'sizes', 'category', 'label'])->where('category_id', $category_id);
        } else {
            $category = null;
            $query = Product::with(['primaryImage', 'images', 'sizes', 'category', 'label']);
        }
        
 
        
        $products = $query->paginate(10);
        $categories = Category::all(); // For dropdown in modals

        return view('admin.pos-index', compact('products', 'categories', 'category'));
    } 

}
