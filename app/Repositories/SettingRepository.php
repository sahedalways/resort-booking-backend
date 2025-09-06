<?php

namespace App\Repositories;

use App\Models\SiteSetting;

class SettingRepository
{
  /**
   * Get or create site settings (id = 1).
   *
   * @return \App\Models\SiteSetting
   */
  public function getSiteSettings(): SiteSetting
  {
    return SiteSetting::firstOrNew(['id' => 1]);
  }

  /**
   * Save site settings
   *
   * @param \App\Models\SiteSetting $settings
   * @return void
   */
  public function saveSiteSettings(SiteSetting $settings): void
  {
    $settings->save();
  }
}
