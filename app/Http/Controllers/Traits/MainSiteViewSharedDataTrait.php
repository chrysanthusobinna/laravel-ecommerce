<?php

namespace App\Http\Controllers\Traits;

use App\Models\SiteSetting;
use App\Models\LiveChatScript;
use App\Models\CompanyAddress;
use App\Models\SocialMediaHandle;
use App\Models\CompanyPhoneNumber;
use App\Models\Category;


trait MainSiteViewSharedDataTrait
{
    protected $cartkey;

    public function shareMainSiteViewData()
    {
        $this->cartkey = 'customer';
        
        $liveChatScript = LiveChatScript::latest()->first();
        $firstCompanyAddress = CompanyAddress::first();
        $firstCompanyPhoneNumber = CompanyPhoneNumber::first();
        $socialMediaHandles = SocialMediaHandle::orderBy('id', 'desc')->get();
        $whatsAppNumber = CompanyPhoneNumber::where('use_whatsapp', 1)->first();
        $customer_total_cart_items = $this->getTotalItems('customer');

        $site_settings = SiteSetting::firstOrCreate([], [
            'country' => config('site.country'),
            'currency_symbol' => config('site.currency_symbol'),
            'currency_code' => config('site.currency_code'),
        ]);

        $categories = Category::all();

        

        view()->share([
            'categories' => $categories,
            'liveChatScript' => $liveChatScript,
            'whatsAppNumber' => $whatsAppNumber,
            'socialMediaHandles' => $socialMediaHandles,
            'firstCompanyAddress' => $firstCompanyAddress,
            'firstCompanyPhoneNumber' => $firstCompanyPhoneNumber,
            'customer_total_cart_items' => $customer_total_cart_items,
            'site_settings' => $site_settings,
        ]);
    }
}

