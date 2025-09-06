<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Http\UploadedFile;

class SiteSettingService
{
  protected $repository;

  public function __construct(SettingRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Update site settings
   *
   * @param array $data
   * @return void
   */
  public function update(array $data): void
  {
    $settings = $this->repository->getSiteSettings();

    $settings->site_title        = $data['site_title'] ?? $settings->site_title;
    $settings->site_phone_number = $data['site_phone_number'] ?? $settings->site_phone_number;
    $settings->site_email        = $data['site_email'] ?? $settings->site_email;
    $settings->copyright_text    = $data['copyright_text'] ?? $settings->copyright_text;

    // Handle Logo
    if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
      $ext = $data['logo']->getClientOriginalExtension();
      $data['logo']->storeAs('image/settings', 'logo.' . $ext, 'public');
      $settings->logo = $ext;
    }

    // Handle Favicon
    if (isset($data['favicon']) && $data['favicon'] instanceof UploadedFile) {
      $ext = $data['favicon']->getClientOriginalExtension();
      $data['favicon']->storeAs('image/settings', 'favicon.' . $ext, 'public');
      $settings->favicon = $ext;
    }

    // Handle Hero Image
    if (isset($data['hero_image']) && $data['hero_image'] instanceof UploadedFile) {
      $ext = $data['hero_image']->getClientOriginalExtension();
      $data['hero_image']->storeAs('image/settings', 'hero.' . $ext, 'public');
      $settings->hero_image = $ext;
    }

    $this->repository->saveSiteSettings($settings);

    // Clear cache
    cache()->forget('site_settings');
  }
}
