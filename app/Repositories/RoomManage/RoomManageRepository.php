<?php

namespace App\Repositories\RoomManage;

use App\Models\Resort;
use App\Models\ResortServiceType;
use App\Models\Room;
use App\Models\RoomBedType;
use App\Models\RoomImage;
use App\Models\RoomRateDetail;
use App\Models\RoomServiceInfo;
use App\Models\RoomViewType;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;




class RoomManageRepository
{


  public function getAllRoomsData()
  {
    return Room::with(['resort', 'images', 'bedType', 'viewType'])
      ->latest()
      ->get();
  }


  public function getRoomSingleData(int $id): ?Room
  {

    return Room::where('id', $id)->first();
  }


  public function updateRoomSingleData(Room $item, array $data): ?Room
  {
    $item->update([
      'resort_id'   => $data['resort_id'] ?? $item->resort_id,
      'name'        => $data['name'] ?? $item->name,
      'bed_type_id' => $data['bed_type_id'] ?? $item->bed_type_id,
      'view_type_id' => $data['view_type_id'] ?? $item->view_type_id,
      'area'        => $data['area'] ?? $item->area,
      'price'       => $data['price'] ?? $item->price,
      'adult_cap'   => $data['adult_cap'] ?? $item->adult_cap,
      'child_cap'   => $data['child_cap'] ?? $item->child_cap,
      'price_per'   => $data['price_per'] ?? $item->price_per,
      'package_name' => $data['package_name'] ?? $item->package_name,
      'desc' => $data['desc'] ?? $item->desc,
      'is_active' => $data['is_active'] ?? $item->is_active,
    ]);


    return $item->fresh();
  }



  public function saveRoomsData(array $data): ?Room
  {
    $item = new Room();

    $item->resort_id    = $data['resort_id'] ?? null;
    $item->name         = $data['name'] ?? null;
    $item->desc         = $data['desc'] ?? null;
    $item->bed_type_id  = $data['bed_type_id'] ?? null;
    $item->view_type_id = $data['view_type_id'] ?? null;
    $item->area         = $data['area'] ?? null;
    $item->price        = $data['price'] ?? null;
    $item->adult_cap    = $data['adult_cap'] ?? 1;
    $item->child_cap    = $data['child_cap'] ?? 0;
    $item->price_per    = $data['price_per'] ?? null;
    $item->package_name = $data['package_name'] ?? null;
    $item->is_active = $data['is_active'] ?? null;


    $item->save();

    return $item;
  }


  public function deleteRoom(int $id)
  {
    $room = $this->getRoomSingleData($id);

    $room->images()->delete();
    $room->services()->delete();
    $room->rateDetails()->delete();

    $room->delete();
  }



  public function getResorts()
  {
    return Resort::select('id', 'name')->get();
  }


  public function getBedTypes()
  {
    return RoomBedType::select('id', 'type_name')->get();
  }

  public function getViewTypes()
  {
    return RoomViewType::select('id', 'type_name')->get();
  }


  public function getServicesTypes()
  {
    return ResortServiceType::select('id', 'type_name', 'icon')->get();
  }


  public function saveRoomImagesGallery(int $itemId, array $images, array $removedImages): void
  {
    foreach ($removedImages as $img) {
      $old = RoomImage::where('image', $img)->first();
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

      $path = storage_path('app/public/image/room/' . $filename);
      $img->save($path);

      RoomImage::create([
        'room_id' => $itemId,
        'image'            => 'image/room/' . $filename,
      ]);
    }
  }



  public function getRoomImagesGallery(int $itemId)
  {
    return RoomImage::where('room_id', $itemId)
      ->get()
      ->map(function ($image) {
        $image->url = getFileUrl($image->image);
        return $image;
      });
  }



  public function saveRoomServices(int $itemId, array $options): void
  {

    RoomServiceInfo::where('room_id', $itemId)->delete();


    foreach ($options as $item) {
      RoomServiceInfo::create([
        'room_id' => $itemId,
        'service_id'            => $item,
      ]);
    }
  }



  public function saveRoomRateDetails(int $itemId, array $options): void
  {

    RoomRateDetail::where('room_id', $itemId)->delete();


    foreach ($options as $item) {
      RoomRateDetail::create([
        'room_id' => $itemId,
        'title'            => $item['title'],
        'is_active'            => $item['is_active'],
      ]);
    }
  }



  public function getRoomServices(int $itemId)
  {
    return RoomServiceInfo::with('service')
      ->where('room_id', $itemId)
      ->latest()
      ->get();
  }



  public function getRoomRateDetails(int $itemId)
  {
    return RoomRateDetail::where('room_id', $itemId)
      ->latest()
      ->get();
  }
}
