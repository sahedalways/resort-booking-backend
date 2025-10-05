<?php

namespace App\Http\Controllers\API;

use App\Models\ContactInfoSettings;
use App\Models\Coupon;
use App\Models\Resort;
use App\Models\SiteSetting;
use App\Models\SocialInfoSettings;
use Illuminate\Http\Request;



class HomeController extends BaseController
{

    public function getHomeData(Request $request)
    {
        try {
            $siteInfo = SiteSetting::first();
            $resortsInfo = Resort::select('id', 'name', 'location')
                ->with('images')
                ->latest()
                ->get();
            $socialInfo = SocialInfoSettings::first();
            $contactInfo = ContactInfoSettings::first();
            $coupons = Coupon::latest()->get();


            return response()->json([
                'success' => true,
                'message' => 'Home data fetched successfully',
                'data' => [
                    'site_info' => $siteInfo,
                    'resort_info' => $resortsInfo,
                    'contact_info' => $contactInfo,
                    'coupons' => $coupons,
                    'social_links' => $socialInfo,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch home data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
