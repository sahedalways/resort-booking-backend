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




  if (!function_exists('shortText')) {
    /**
     * Limit text to a specific length
     *
     * @param string|null $text
     * @param int $limit
     * @return string
     */
    function shortText(?string $text, int $limit = 55): string
    {
      return \Illuminate\Support\Str::limit($text, $limit);
    }
  }


  if (!function_exists('activeBadge')) {
    function activeBadge($isActive, $id = 0)
    {
      $statusText  = $isActive ? 'Active' : 'Inactive';
      $statusClass = $isActive ? 'bg-success' : 'bg-danger';

      return '<span class="badge ' . $statusClass . '" 
                     style="cursor:pointer;" 
                     title="Change Status" 
                     wire:click="toggleActive(' . $id . ')">' . $statusText . '</span>';
    }
  }


  if (!function_exists('paymentStatusBadge')) {
    function paymentStatusBadge(string $status): string
    {
      switch ($status) {
        case 'completed':
          return '<span class="badge bg-success text-white px-2 py-1">Completed</span>';
        case 'pending':
          return '<span class="badge bg-warning text-dark px-2 py-1">Pending</span>';
        case 'failed':
          return '<span class="badge bg-danger text-white px-2 py-1">Failed</span>';
        case 'refunded':
          return '<span class="badge bg-info text-white px-2 py-1">Refunded</span>';
        default:
          return '<span class="badge bg-secondary text-white px-2 py-1">Unknown</span>';
      }
    }
  }
}
