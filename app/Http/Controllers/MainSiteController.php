<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use App\Models\OrderSettings;
use App\Models\PrivacyPolicy;
use App\Models\LiveChatScript;
use App\Helpers\DistanceHelper;
use App\Models\CompanyAddress;
use App\Models\SocialMediaHandle;
use App\Models\TermsAndCondition;
use App\Models\BusinessPhoneNumber;
use App\Models\BusinessWorkingHour;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Traits\CartTrait;
use App\Http\Requests\CustomerDetailsRequest;
use App\Http\Controllers\Traits\OrderNumberGeneratorTrait;
use App\Http\Controllers\Traits\MainSiteViewSharedDataTrait;


class MainSiteController extends Controller
{
    use CartTrait;
    use MainSiteViewSharedDataTrait;
    use OrderNumberGeneratorTrait;


    public function __construct()
    {
        $this->shareMainSiteViewData();
    }

    public function home()
    {
        $recent_arrival_categories = Category::with(['products' => function($query) {
            $query->inRandomOrder()->take(3);
        }])->take(4)->get();

        return view('main-site.index', compact('recent_arrival_categories'));
    }

    public function about()
    {
        return view('main-site.about');
    }
    public function contact()
    {
        $addresses = CompanyAddress::all();
        $phoneNumbers = BusinessPhoneNumber::all();
        $workingHours = BusinessWorkingHour::all();
    
        return view('main-site.contact', [ 'addresses' => $addresses, 'phoneNumbers' => $phoneNumbers, 'workingHours' => $workingHours, ]);
    }
    

    public function productList(Request $request)
    {
        $category = null;
        $categoryId = $request->route('category_id'); // Get category from route parameter
        
        if ($categoryId) {
            $category = Category::findOrFail($categoryId);
        }
    
        $query = Product::with(['primaryImage', 'images', 'category', 'label']);
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        // Handle search functionality
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        $products = $query->paginate(12);
    
        $categories = Category::withCount('products')->get();
    
        return view('main-site.product-list', compact('products', 'category', 'categories'));
    }
    


    public function singleProduct($id)
    {
        $product = Product::with(['category', 'images', 'primaryImage', 'sizes'])->findOrFail($id);
        $cart = session()->get($this->cartkey, []);

        function getItemQuantity($cart, $itemId) {
            foreach ($cart as $item) {
                if ($item['id'] == $itemId) {
                    return $item['quantity'];
                }
            }
            return 0; // Return 0 if item is not found
        }
        
        // Usage example
        $quantity = getItemQuantity($cart, $id);
        
    
    
        // Fetch 5 random related Products  
        $relatedProducts = Product::with('primaryImage')->where('id', '!=', $id)->inRandomOrder()->limit(5)->get();
    
        return view('main-site.product', compact('product','quantity', 'relatedProducts'));
    }
    

    public function cart()
    {
        return view('main-site.cart');
    }





    public function login()
    {
        return view('main-site.login');
    }


    public function privacyPolicy()
    {
        $privacyPolicy  = PrivacyPolicy::latest()->first();
        return view('main-site.privacy-policy',compact('privacyPolicy'));
    }
    public function termsConditions()
    {
        $termsAndCondition = TermsAndCondition::latest()->first();
        return view('main-site.terms-conditions', compact('termsAndCondition'));
     }

     public function clearCart(Request $request)
     {
        session()->forget('cart');
        session()->forget('customer');
        return redirect()->route('product.list')->with('success', 'Cart cleared successfully!');
     }
 

    
}
