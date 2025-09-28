@section('title', siteSetting()->site_title)

<div>
    <div class="row" wire:poll.60s>
        <div class="col-lg-12">
            <div class="row mt-5">

                @php
                    $cardStyle = 'background-color: rgba(229,231,235,0.8); color: #111827; border-radius: 12px;';
                    $cardStyle2 = 'background-color: #30633c; color: #ffffff; border-radius: 12px;';
                @endphp

                <!-- Today Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Today’s Bookings</div>
                                <div class="h5 mb-0 fw-bold">2</div>
                            </div>
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Monthly Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Monthly Bookings</div>
                                <div class="h5 mb-0 fw-bold">33</div>
                            </div>
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Yearly Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Yearly Bookings</div>
                                <div class="h5 mb-0 fw-bold">76</div>
                            </div>
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Profit -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Profit</div>
                                <div class="h5 mb-0 fw-bold">৳767</div>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>


                <!-- Total Users -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle2 }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Users</div>
                                <div class="h5 mb-0 fw-bold text-white">5</div>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>



                <!-- Customer Feedbacks -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle2 }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1 text-white">Customer Feedbacks</div>
                                <div class="h5 mb-0 fw-bold text-white">12</div>
                            </div>
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Hotels & Resorts -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Hotels & Resorts</div>
                                <div class="h5 mb-0 fw-bold ">10</div>
                            </div>
                            <i class="fas fa-hotel fa-2x"></i>
                        </div>
                    </div>
                </div>





                <!-- Total Revenue -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Total Revenue</div>
                                <div class="h5 mb-0 fw-bold ">৳35,000</div>
                            </div>
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>







                <!-- Pending Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Pending Bookings</div>
                                <div class="h5 mb-0 fw-bold">4</div>
                            </div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="{{ $cardStyle }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs fw-bold text-uppercase mb-1">Cancelled Bookings</div>
                                <div class="h5 mb-0 fw-bold ">2</div>
                            </div>
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
