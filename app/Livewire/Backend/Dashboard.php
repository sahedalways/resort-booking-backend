<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\BookingInfo;
use App\Models\Resort;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $todaysBookings;
    public $monthlyBookings;
    public $yearlyBookings;
    public $totalProfit;
    public $totalUsers;
    public $customerFeedbacks;
    public $hotelsResorts;
    public $totalRevenue;
    public $pendingBookings;
    public $cancelledBookings;
    public $confirmedBookings;
    public $completedBookings;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $yearStart = Carbon::now()->startOfYear();

        // Bookings with status 'completed'
        $completedBookings = BookingInfo::where('status', 'completed');

        $this->todaysBookings = (clone $completedBookings)
            ->whereDate('created_at', $today)
            ->count();

        $this->monthlyBookings = (clone $completedBookings)
            ->whereBetween('created_at', [$monthStart, Carbon::now()])
            ->count();

        $this->yearlyBookings = (clone $completedBookings)
            ->whereBetween('created_at', [$yearStart, Carbon::now()])
            ->count();

        $this->totalProfit = (clone $completedBookings)
            ->sum('amount');

        $this->totalRevenue = (clone $completedBookings)
            ->sum('amount');


        $statuses = BookingInfo::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $this->completedBookings = $statuses['completed'] ?? 0;
        $this->confirmedBookings = $statuses['confirmed'] ?? 0;
        $this->pendingBookings   = $statuses['pending'] ?? 0;
        $this->cancelledBookings = $statuses['cancelled'] ?? 0;

        $this->totalUsers = User::where('user_type', 'user')->count();

        $this->customerFeedbacks = Review::count();

        $this->hotelsResorts = Resort::count();
    }

    public function render()
    {
        return view('livewire.backend.dashboard', [
            'todaysBookings'     => $this->todaysBookings,
            'monthlyBookings'    => $this->monthlyBookings,
            'yearlyBookings'     => $this->yearlyBookings,
            'totalProfit'        => $this->totalProfit,
            'totalUsers'         => $this->totalUsers,
            'customerFeedbacks'  => $this->customerFeedbacks,
            'hotelsResorts'      => $this->hotelsResorts,
            'totalRevenue'       => $this->totalRevenue,
            'pendingBookings'    => $this->pendingBookings,
            'cancelledBookings'  => $this->cancelledBookings,
            'completedBookings'  => $this->completedBookings,
            'confirmedBookings'  => $this->confirmedBookings,
        ]);
    }
}
