<?php

namespace App\Http\Controllers\API;

use App\Models\ContactInfoSettings;
use App\Models\Coupon;
use App\Models\FeatureImage;
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
            if ($siteInfo) {

                // Remove timestamps
                unset($siteInfo->created_at, $siteInfo->updated_at, $siteInfo->id, $siteInfo->logo, $siteInfo->favicon,  $siteInfo->site_title, $siteInfo->favicon_url, $siteInfo->logo_url);
            }

            // Resorts info
            $resortsInfo = Resort::select('id', 'name', 'location')
                ->with(['images'])
                ->latest()
                ->get();

            $resortsInfo->transform(function ($resort) {
                $resort->images->transform(function ($img) {
                    $img->image = getFileUrlForFrontend($img->image);
                    unset($img->created_at, $img->updated_at);
                    return $img;
                });
                unset($resort->created_at, $resort->updated_at);
                return $resort;
            });



            // Feature images
            $featureImage = FeatureImage::first();
            if ($featureImage) {
                $featureImage->resortImageUrl = $featureImage->resort_image ? getFileUrlForFrontend($featureImage->resort_image) : null;
                $featureImage->eventImageUrl = $featureImage->event_image ? getFileUrlForFrontend($featureImage->event_image) : null;
                unset($featureImage->created_at, $featureImage->updated_at, $featureImage->id);
            }

            // Coupons
            $coupons = Coupon::latest()->get();
            $coupons->transform(function ($coupon) {
                unset($coupon->created_at, $coupon->updated_at);
                return $coupon;
            });


            return response()->json([
                'success' => true,
                'message' => 'Home data fetched successfully',
                'data' => [
                    'site_info' => $siteInfo,
                    'resort_info' => $resortsInfo,
                    'coupons' => $coupons,
                    'feature_images' => $featureImage,
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
