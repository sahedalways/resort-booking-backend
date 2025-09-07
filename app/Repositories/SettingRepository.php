<?php

namespace App\Repositories;

use App\Models\EmailSetting;
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



  /**
   * Save or update mail settings
   *
   * @param array $data
   * @return EmailSetting
   */
  public function saveMailSettings(array $data): EmailSetting
  {
    $settings = EmailSetting::firstOrNew(['id' => 1]);

    $settings->mail_mailer       = $data['mail_mailer'] ?? null;
    $settings->mail_host         = $data['mail_host'] ?? null;
    $settings->mail_port         = $data['mail_port'] ?? null;
    $settings->mail_username     = $data['mail_username'] ?? null;
    $settings->mail_password     = $data['mail_password'] ?? null;
    $settings->mail_encryption   = $data['mail_encryption'] ?? null;
    $settings->mail_from_address = $data['mail_from_address'] ?? null;
    $settings->mail_from_name    = $data['mail_from_name'] ?? null;

    $settings->save();

    return $settings;
  }
}
