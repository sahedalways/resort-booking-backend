<?php

namespace App\Repositories\ResortManage;

use App\Models\Resort;
use App\Models\ResortAdditionalFact;
use App\Models\ResortFacilityOptionService;
use App\Models\ResortImage;
use App\Models\ResortPackageType;
use App\Models\ResortRoomFacility;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;


class ResortManageRepository
{


  public function getAllResortData()
  {
    return Resort::query()
      ->latest()
      ->get();
  }


  public function getResortSingleData(int $id): ?Resort
  {

    return Resort::where('id', $id)->first();
  }

  public function updateResortSingleData(Resort $item, array $data): ?Resort
  {
    $item->update([
      'name'     => $data['name'],
      'distance'     => $data['distance'],
      'location'     => $data['location'],
      'desc'     => $data['desc'],
      'd_check_in'     => $data['d_check_in'],
      'd_check_out'     => $data['d_check_out'],
      'n_check_in'     => $data['n_check_in'],
      'n_check_out'     => $data['n_check_out'],
      'package_id'     => $data['packageTypeId'],

    ]);

    return $item->fresh();
  }



  public function saveResortData(array $data): ?Resort
  {
    $item = new Resort();


    $item->name = $data['name'] ?? null;
    $item->distance = $data['distance'] ?? null;
    $item->location = $data['location'] ?? null;
    $item->desc = $data['desc'] ?? null;
    $item->d_check_in = $data['d_check_in'] ?? null;
    $item->d_check_out = $data['d_check_out'] ?? null;
    $item->n_check_in = $data['n_check_in'] ?? null;
    $item->n_check_out = $data['n_check_out'] ?? null;
    $item->package_id = $data['packageTypeId'] ?? null;


    $item->save();

    return $item;
  }


  public function deleteResortData(int $id)
  {
    $data = $this->getResortSingleData($id);
    $data->delete();
  }



  public function saveResortImagesGallery(int $itemId, array $images, array $removedImages): void
  {
    foreach ($removedImages as $img) {
      $old = ResortImage::where('image', $img)->first();
      if ($old) {
        if (file_exists(storage_path('app/public/' . $old->image))) {
          unlink(storage_path('app/public/' . $old->image));
        }
        $old->delete();
      }
    }


    foreach ($images as $image) {
      if (!$image instanceof UploadedFile) continue;

      $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

      $img = Image::read($image->getRealPath());

      $path = storage_path('app/public/image/resort/' . $filename);
      $img->save($path);

      ResortImage::create([
        'resort_id' => $itemId,
        'image'            => 'image/resort/' . $filename,
      ]);
    }
  }



  public function getResortImagesGallery(int $itemId)
  {
    return ResortImage::where('resort_id', $itemId)
      ->get()
      ->map(function ($image) {
        $image->url = getFileUrl($image->image);
        return $image;
      });
  }



  public function getPackageTypes()
  {
    return ResortPackageType::all();
  }



  public function saveFactOptions(int $itemId, array $options): void
  {

    ResortAdditionalFact::where('resort_id', $itemId)->delete();


    foreach ($options as $item) {
      ResortAdditionalFact::create([
        'resort_id' => $itemId,
        'name'            => $item,
      ]);
    }
  }



  public function getFactOptions(int $itemId)
  {
    return ResortAdditionalFact::where('resort_id', $itemId)->latest()->get();
  }



  public function getResortFacilitiesData()
  {
    return ResortRoomFacility::with('options.service')->get();
  }

  public function saveResortsFacility($services, $selectedFacilityId, $resortId)
  {
    try {
      foreach ($services as $service) {
        ResortFacilityOptionService::create([
          'resort_id'   => $resortId,
          'facility_id' => $selectedFacilityId,
          'type_name'   => $service['type_name'],
          'icon'        => $service['icon'] ?? null,
        ]);
      }

      return true;
    } catch (\Exception $e) {
      \Log::error('Error saving resort services: ' . $e->getMessage());
      return false;
    }
  }



  public function saveServiceName($resortId, $selectedFacilityId, $serviceName, $icon)
  {
    try {
      ResortFacilityOptionService::create([
        'resort_id' => $resortId,
        'facility_id' => $selectedFacilityId,
        'type_name' => $serviceName,
        'icon' => $icon,
      ]);

      return true;
    } catch (\Exception $e) {
      \Log::error('Error saving service name: ' . $e->getMessage());
      return false;
    }
  }


  public function deleteServiceItem($resortId, $facilityId, $serviceName)
  {
    try {
      ResortFacilityOptionService::where('resort_id', $resortId)
        ->where('facility_id', $facilityId)
        ->where('type_name', $serviceName)
        ->delete();

      return true;
    } catch (\Exception $e) {

      \Log::error('Error deleting service: ' . $e->getMessage());
      return false;
    }
  }
}
