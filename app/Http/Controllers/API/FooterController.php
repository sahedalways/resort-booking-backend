<?php

namespace App\Http\Controllers\API;

use App\Models\ContactInfoSettings;
use App\Models\SiteSetting;
use App\Models\SocialInfoSettings;
use Illuminate\Http\Request;



class FooterController extends BaseController
{

    public function getFooterData(Request $request)
    {
        try {
            $siteInfo = SiteSetting::first();
            if ($siteInfo) {

                // Remove timestamps
                unset($siteInfo->created_at, $siteInfo->updated_at, $siteInfo->id, $siteInfo->hero_image_url, $siteInfo->site_title, $siteInfo->site_title, $siteInfo->logo, $siteInfo->favicon, $siteInfo->site_email, $siteInfo->site_phone_number, $siteInfo->hero_image);
            }


            // Contact info
            $contactInfo = ContactInfoSettings::first();
            unset($contactInfo->created_at, $contactInfo->updated_at, $contactInfo->id);

            // Social links
            $socialInfo = SocialInfoSettings::first();
            unset($socialInfo->created_at, $socialInfo->updated_at, $socialInfo->id);



            return response()->json([
                'success' => true,
                'message' => 'Footer data fetched successfully',
                'data' => [
                    'site_info' => $siteInfo,
                    'contact_info' => $contactInfo,
                    'social_info' => $socialInfo,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch footer data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
