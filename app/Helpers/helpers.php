<?php

use App\Models\SiteSetting;

if (!function_exists('siteSetting')) {
  function siteSetting()
  {
    return cache()->remember('site_settings', 3600, function () {
      $settings = SiteSetting::first();

      return $settings;
    });
  }



  if (!function_exists('fa_icon')) {
    /**
     * Return FontAwesome icon HTML dynamically
     *
     * @param string|null $iconClass
     * @return string
     */
    function fa_icon(?string $iconClass): string
    {
      if (!$iconClass) {
        return '';
      }
      return '<i class="' . e($iconClass) . ' me-1"></i>';
    }
  }


  if (!function_exists('getRefundableText')) {
    function getRefundableText(?bool $isRefundable): string
    {
      return (bool) $isRefundable ? 'Refundable' : 'Non-Refundable';
    }
  }
}
