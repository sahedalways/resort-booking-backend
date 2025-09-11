<?php

namespace App\Http\Controllers\API;

use App\Models\ClientTestimonial;
use App\Models\FAQ;
use App\Models\PropertyInfo;
use App\Models\SiteSetting;
use App\Models\SocialInfoSetting;
use Illuminate\Http\Request;



class HomeController extends BaseController
{

    public function getHomeData(Request $request)
    {
        try {
            $siteInfo = SiteSetting::first();
            $faqsInfo = FAQ::latest()->get();
            $testimonialInfo = ClientTestimonial::latest()->get();
            $socialInfo = SocialInfoSetting::get();


            return response()->json([
                'success' => true,
                'message' => 'Home data fetched successfully',
                'data' => [
                    'site_info' => $siteInfo,
                    'faqs' => $faqsInfo,
                    'testimonials' => $testimonialInfo,
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


    public function getPmInfo($user_id)
    {
        try {

            $propertyInfo = PropertyInfo::whereRaw("FIND_IN_SET(?, tenant_ids)", [$user_id])->first();


            if (!$propertyInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'No property information found for the given user ID.',
                ], 404);
            }


            return response()->json([
                'success' => true,
                'message' => 'CM info fetched successfully',
                'pm_name' => $propertyInfo->contact_name,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching CM info: ' . $e->getMessage());


            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch CM info data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}



// For inquiries regarding mobile or web application development, feel free to reach out!

// 📧 Email: ssahed65@gmail.com
// 📱 WhatsApp: +8801616516753
// My name is Sk Sahed Ahmed, and I look forward to collaborating with you!