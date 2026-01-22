<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\OrderSettings;
use App\Models\CompanyAddress;
use App\Models\LiveChatScript;
use App\Models\SocialMediaHandle;
use App\Models\BusinessWorkingHour;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\BusinessPhoneNumber;
use App\Http\Requests\PhoneNumberRequest;
use App\Http\Requests\WorkingHourRequest;
use App\Http\Requests\LiveChatScriptRequest;
use App\Http\Requests\SocialMediaHandleRequest;
use App\Http\Controllers\Traits\SanitizesInputTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;

class GeneralSettingsController extends Controller
{
    use AdminViewSharedDataTrait;
    use SanitizesInputTrait;


    public function __construct()
    {
        $this->shareAdminViewData();
        
    }
    
    public function index()
    {
        $addresses = CompanyAddress::all();
        $phoneNumbers = BusinessPhoneNumber::all();
        $workingHours = BusinessWorkingHour::all();
        $socialMediaHandles = SocialMediaHandle::all();
        $script = LiveChatScript::latest()->first();

        $site_settings = SiteSetting::firstOrCreate([], [
            'country' => config('site.country'),
            'currency_symbol' => config('site.currency_symbol'),
            'currency_code' => config('site.currency_code'),
        ]);



        return view('admin.general-settings', compact('addresses', 'phoneNumbers', 'workingHours','socialMediaHandles','script'));
    }

    // Phone Number CRUD
    public function storePhoneNumber(PhoneNumberRequest $request)
    {

        // If 'use_whatsapp' is checked, set all others to 0 first
        if ($request->has('use_whatsapp') && $request->use_whatsapp == 1) {
            BusinessPhoneNumber::where('use_whatsapp', 1)->update(['use_whatsapp' => 0]);
        }
    
        BusinessPhoneNumber::create([
            'phone_number' => $request->phone_number,
            'use_whatsapp' => $request->has('use_whatsapp') ? 1 : 0,
        ]);
    
        return back()->with('success', 'Phone number added successfully.');
    }
    
    
    

    public function updatePhoneNumber(PhoneNumberRequest $request, $id)
    {
    
        $phoneNumber = BusinessPhoneNumber::findOrFail($id);
    
        // If 'use_whatsapp' is checked, set all others to 0 first
        if ($request->has('use_whatsapp') && $request->use_whatsapp == 1) {
            BusinessPhoneNumber::where('use_whatsapp', 1)->update(['use_whatsapp' => 0]);
        }
    
        $phoneNumber->update([
            'phone_number' => $request->phone_number,
            'use_whatsapp' => $request->has('use_whatsapp') ? 1 : 0,
        ]);
    
        return back()->with('success', 'Phone number updated successfully.');
    }
    
    

    public function deletePhoneNumber($id)
    {
        BusinessPhoneNumber::findOrFail($id)->delete();
        return back()->with('success', 'Phone number deleted successfully.');
    }
    

    // Company Address CRUD
    public function storeAddress(AddressRequest $request)
    {
        CompanyAddress::create([
            'street'      => $request->line1,
            'city'        => $request->city,
            'state'       => $request->state,
            'postal_code' => $request->postal_code,
            'country'     => $request->country,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ]);

        return back()->with('success', 'Address added successfully.');
    }

    public function updateAddress(AddressRequest $request, $id)
    {
        $address = CompanyAddress::findOrFail($id);

        $address->update([
            'street'      => $request->line1,
            'city'        => $request->city,
            'state'       => $request->state,
            'postal_code' => $request->postal_code,
            'country'     => $request->country,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ]);

        return back()->with('success', 'Address updated successfully.');
    }

    public function deleteAddress($id)
    {
        CompanyAddress::findOrFail($id)->delete();

        return back()->with('success', 'Address deleted successfully.');
    }



    // social media handles CRUD
    public function storeSocialMediaHandle(SocialMediaHandleRequest $request)
    {
        SocialMediaHandle::create($request->all());
        return back()->with('success', 'Social media handle added successfully.');
    }
    
    public function updateSocialMediaHandle(SocialMediaHandleRequest $request, $id)
    {
        $socialMediaHandle = SocialMediaHandle::findOrFail($id);
        $socialMediaHandle->update($request->all());
    
        return back()->with('success', 'Social media handle updated successfully.');
    }
    

    public function deleteSocialMediaHandle($id)
    {
        $socialMediaHandle = SocialMediaHandle::findOrFail($id);
        $socialMediaHandle->delete();
    
        return back()->with('success', 'Social media handle deleted successfully.');
    }
    
 



    // Working Hour CRUD
    public function storeWorkingHour(WorkingHourRequest $request)
    {
        // If you're using a FormRequest, this already validated:
        $data = $request->validated();

        // Convert checkbox → boolean
        $data['is_closed'] = $request->boolean('is_closed');

        // If closed all day, null out times
        if ($data['is_closed']) {
            $data['opens_at']  = null;
            $data['closes_at'] = null;
        }

        BusinessWorkingHour::create([
            'day_of_week' => $data['day_of_week'],
            'opens_at'    => $data['opens_at'] ?? null,
            'closes_at'   => $data['closes_at'] ?? null,
            'is_closed'   => $data['is_closed'],
        ]);

        return back()->with('success', 'Working hour added successfully.');
    }



public function updateWorkingHour(WorkingHourRequest $request, $id)
{
    $workingHour = BusinessWorkingHour::findOrFail($id);

    $data = $request->validated();
    $data['is_closed'] = $request->boolean('is_closed');

    if ($data['is_closed']) {
        $data['opens_at']  = null;
        $data['closes_at'] = null;
    }

    $workingHour->update([
        'day_of_week' => $data['day_of_week'],
        'opens_at'    => $data['opens_at'] ?? null,
        'closes_at'   => $data['closes_at'] ?? null,
        'is_closed'   => $data['is_closed'],
    ]);

    return back()->with('success', 'Working hour updated successfully.');
}


public function deleteWorkingHour($id)
{
    BusinessWorkingHour::findOrFail($id)->delete();

    return back()->with('success', 'Working hour deleted successfully.');
}



    // live chat script CRUD
    public function createLiveChatScript(LiveChatScriptRequest $request)
    {
        $validated = $request->validated();
    
        $validated['script_code'] = $this->sanitizeHtmlContent($validated['script_code']);
    
        LiveChatScript::create($validated);
    
        return redirect()->back()->with('success', 'Live chat script created successfully!');
    }
    


    public function updateLiveChatScript(LiveChatScriptRequest $request, $id)
    {
        $script = LiveChatScript::findOrFail($id);
        $script->update($request->validated());

        return redirect()->back()->with('success', 'Live chat script updated successfully!');
    }


    public function destroyLiveChatScript($id)
    {
        $script = LiveChatScript::findOrFail($id);
        $script->delete();

        return redirect()->back()->with('success', 'Live chat script deleted successfully!');

    }

    public function orderSettings()
    {
        $order_settings = OrderSettings::first();
        $site_settings = SiteSetting::first();
        return view('admin.settings-order', compact('order_settings', 'site_settings'));
    }

    public function updateOrderSettings(Request $request)
    {
        $request->validate([
            'price_per_mile' => 'required|numeric|min:0',
            'distance_limit_in_miles' => 'required|integer|min:1',
            'vat_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $settings = OrderSettings::firstOrNew();
        $settings->price_per_mile = $request->input('price_per_mile');
        $settings->distance_limit_in_miles = $request->input('distance_limit_in_miles');
        $settings->vat_percentage = $request->input('vat_percentage');
        $settings->save();

        return redirect()->back()->with('success', 'Order Settings updated successfully!');

    }

    public function businessSettings()
    {
        $countries = Country::orderBy('name')->get();
        $site_settings = SiteSetting::first();
        return view('admin.settings-business', compact('countries', 'site_settings'));
    }
 
    public function updateBusinessSettings(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
        ]);

        $country = Country::findOrFail($validated['country_id']);

        $siteSetting = SiteSetting::firstOrNew();
        $siteSetting->country         = $country->name;
        $siteSetting->currency_symbol = $this->sanitizeHtmlContent($country->currency_symbol);
        $siteSetting->currency_code   = $country->currency_code;
        $siteSetting->save();

        return redirect()->back()->with('success', 'Site settings saved successfully!');
    }
    
}
