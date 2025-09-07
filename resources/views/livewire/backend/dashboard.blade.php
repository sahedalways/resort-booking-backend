@section('title', siteSetting()->site_title)

<div>
    <div class="row" wire:poll.60s>
        <div class="col-lg-12">
            <div class="row mt-5">

                <!-- Today Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card text-white shadow h-100 py-2" style="background-color:#a919e6c0;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Today’s Bookings</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827" style="color: #111827">2</div>
                            </div>
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Monthly Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Monthly Bookings</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">33</div>
                            </div>
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Yearly Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-warning text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Yearly Bookings</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">76</div>
                            </div>
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Profit / Sales -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-danger text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Profit</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">৳767</div>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Hotels & Resorts -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-info text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Hotels & Resorts</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">10</div>
                            </div>
                            <i class="fas fa-hotel fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-secondary text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Users</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">5</div>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card text-white shadow h-100 py-2" style="background-color:#1E93AB;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Pending Bookings</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">4</div>
                            </div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-light text-dark shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Cancelled Bookings</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">2</div>
                            </div>
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-primary text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Revenue</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">৳35,000</div>
                            </div>
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Customer Feedbacks -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Customer Feedbacks</div>
                                <div class="h5 mb-0 fw-bold" style="color: #111827">12</div>
                            </div>
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
