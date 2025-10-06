<?php

namespace App\Http\Controllers\API;

use App\Models\SiteSetting;
use Illuminate\Http\Request;



class HeaderController extends BaseController
{

    public function getHeaderData(Request $request)
    {
        try {
            $siteInfo = SiteSetting::first();
            if ($siteInfo) {

                // Remove timestamps
                unset($siteInfo->created_at, $siteInfo->updated_at, $siteInfo->id, $siteInfo->hero_image_url, $siteInfo->copyright_text, $siteInfo->site_email, $siteInfo->site_phone_number, $siteInfo->hero_image);
            }

            return response()->json([
                'success' => true,
                'message' => 'Header data fetched successfully',
                'data' => [
                    'header_info' => $siteInfo,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch header data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
