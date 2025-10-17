<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps ps--active-y"
    id="sidenav-main" data-color="primary">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset(siteSetting()->logo_url) }}" class="navbar-brand-img h-100 scale-200" alt="main_logo">
            <span class="ms-2 h6 font-weight-bold ">{{ siteSetting()->site_title }} </span>

        </a>

    </div>
    <hr class="horizontal mt-0">
    <div class="collapse navbar-collapse w-auto h-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if (app('authUser')->user_type == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gauge text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#users"
                        class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" aria-controls="users"
                        role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fas fa-users text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" id="users">
                        <ul class="nav ms-4">

                            <!-- Users Management -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/users/manage') ? 'active' : '' }}"
                                    href="{{ route('admin.users.manage') }}">
                                    <i class="fas fa-users sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Users Management </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#resortManage"
                        class="nav-link {{ Request::is('admin/resort-manage*') ? 'active' : '' }}"
                        aria-controls="resortManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-building text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> Resorts</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/resort-manage*') ? 'show' : '' }}" id="resortManage">
                        <ul class="nav ms-4">
                            <li class="nav-item">

                                <a class="nav-link {{ Request::is('admin/resort-manage') ? 'active' : '' }}"
                                    href="{{ route('admin.resort-manage.index') }}">
                                    <i class="ni ni-building text-danger text-sm opacity-10"></i>

                                    <span class="sidenav-normal side-bar-inner"> Manage Resort </span>
                                </a>


                                <a class="nav-link {{ Request::is('admin/resort-manage/service-type') ? 'active' : '' }}"
                                    href="{{ route('admin.resort-manage.service-type') }}">
                                    <i class="fas fa-concierge-bell sidenav-mini-icon side-bar-inner"></i>

                                    <span class="sidenav-normal side-bar-inner"> Service Type </span>
                                </a>


                                <a class="nav-link {{ Request::is('admin/resort-manage/package-type') ? 'active' : '' }}"
                                    href="{{ route('admin.resort-manage.package-type') }}">
                                    <i class="fas fa-box-open sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Package Type </span>
                                </a>


                                <a class="nav-link {{ Request::is('admin/resort-manage/manage-facilities') ? 'active' : '' }}"
                                    href="{{ route('admin.resort-manage.manage-facilities') }}">
                                    <i class="fas fa-concierge-bell sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Manage Facilities </span>
                                </a>


                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/daylong-manage*') ? 'active' : '' }}"
                        href="{{ route('admin.daylong-manage.index') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fas fa-sun text-warning text-sm me-2 opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manage Day-Long</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#roomManage"
                        class="nav-link {{ Request::is('admin/room-manage*') ? 'active' : '' }}"
                        aria-controls="roomManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fas fa-door-open text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Rooms</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/room-manage*') ? 'show' : '' }}" id="roomManage">
                        <ul class="nav ms-4">
                            <li class="nav-item">

                                <a class="nav-link {{ Request::is('admin/room-manage') ? 'active' : '' }}"
                                    href="{{ route('admin.room-manage.index') }}">
                                    <i class="fas fa-door-open text-danger text-sm opacity-10"></i>
                                    <span class="sidenav-normal side-bar-inner"> Manage Rooms </span>
                                </a>


                                <a class="nav-link {{ Request::is('admin/room-manage/bed-type') ? 'active' : '' }}"
                                    href="{{ route('admin.room-manage.bed-type') }}">
                                    <i class="fas fa-bed sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Bed Type </span>
                                </a>

                                <a class="nav-link {{ Request::is('admin/room-manage/view-type') ? 'active' : '' }}"
                                    href="{{ route('admin.room-manage.view-type') }}">
                                    <i class="fas fa-eye sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> View Type </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#bookingManage"
                        class="nav-link {{ Request::is('admin/booking-info*') ? 'active' : '' }}"
                        aria-controls="bookingManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-folder-open text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Booking Info</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/booking-info*') ? 'show' : '' }}" id="bookingManage">
                        <ul class="nav ms-4">

                            {{-- Pending --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/booking-info/pending') ? 'active' : '' }}"
                                    href="{{ route('admin.booking-info.pending') }}">
                                    <i
                                        class="fa-solid fa-hourglass-half sidenav-mini-icon side-bar-inner text-warning"></i>
                                    <span class="sidenav-normal side-bar-inner"> Pending Bookings </span>
                                </a>
                            </li>

                            {{-- Confirmed --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/booking-info/confirm') ? 'active' : '' }}"
                                    href="{{ route('admin.booking-info.confirm') }}">
                                    <i
                                        class="fa-solid fa-circle-check sidenav-mini-icon side-bar-inner text-success"></i>
                                    <span class="sidenav-normal side-bar-inner"> Confirmed Bookings </span>
                                </a>
                            </li>

                            {{-- Cancelled --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/booking-info/cancelled') ? 'active' : '' }}"
                                    href="{{ route('admin.booking-info.cancelled') }}">
                                    <i class="fa-solid fa-ban sidenav-mini-icon side-bar-inner text-danger"></i>
                                    <span class="sidenav-normal side-bar-inner"> Cancelled Bookings </span>
                                </a>
                            </li>

                            {{-- Completed --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/booking-info/completed') ? 'active' : '' }}"
                                    href="{{ route('admin.booking-info.completed') }}">
                                    <i
                                        class="fa-solid fa-clipboard-check sidenav-mini-icon side-bar-inner text-primary"></i>
                                    <span class="sidenav-normal side-bar-inner"> Completed Bookings </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>





                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#eventManage"
                        class="nav-link {{ Request::is('admin/event-manage*') ? 'active' : '' }}"
                        aria-controls="eventManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manage Event</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/event-manage*') ? 'show' : '' }}" id="eventManage">
                        <ul class="nav ms-4">

                            <!-- Hero & Call Now -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/event-manage/hero') ? 'active' : '' }}"
                                    href="{{ route('admin.event-manage.hero') }}">
                                    <i class="fas fa-image sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Hero Settings </span>
                                </a>
                            </li>

                            <!-- Event Services -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/event-manage/services') ? 'active' : '' }}"
                                    href="{{ route('admin.event-manage.services') }}">
                                    <i class="fas fa-th-large sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Event Services </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/coupons*') ? 'active' : '' }}"
                        href="{{ route('admin.coupons') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-ticket text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Coupons</span>
                    </a>
                </li>





                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#contentManage"
                        class="nav-link {{ Request::is('admin/content-manage*') ? 'active' : '' }}"
                        aria-controls="contentManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-folder-open text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Content Management</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/content-manage*') ? 'show' : '' }}"
                        id="contentManage">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/content-manage/features-images') ? 'active' : '' }}"
                                    href="{{ route('admin.content-manage.features-images') }}">
                                    <i class="fa-solid fa-images sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Features Images </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reviews*') ? 'active' : '' }}"
                        href="{{ route('admin.reviews.index') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">

                            <i class="fa-solid fa-star text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Rating & Reviews</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/payments*') ? 'active' : '' }}"
                        href="{{ route('admin.payments.index') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">

                            <i class="fa-solid fa-credit-card text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Payments</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/contact-info*') ? 'active' : '' }}"
                        href="{{ route('admin.contact-info.index') }}">

                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-envelope text-primary text-sm opacity-10"></i>
                        </div>

                        <span class="nav-link-text ms-1">Contact Inquiries</span>

                        @if (isset($unreadContacts) && $unreadContacts > 0)
                            <span class="badge bg-danger ms-auto">{{ $unreadContacts }}</span>
                        @endif
                    </a>
                </li>



                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#settings"
                        class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}"
                        aria-controls="settings" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Settings</span>
                    </a>
                    <div class="collapse {{ Request::is('admin/settings*') ? 'show' : '' }}" id="settings">
                        <ul class="nav ms-4">

                            <!-- Site Settings -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/site') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.site') }}">
                                    <i class="fas fa-cog sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Site Settings </span>
                                </a>
                            </li>

                            <!-- Mail Settings -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/mail') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.mail') }}">
                                    <i class="fas fa-envelope sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Mail Settings </span>
                                </a>
                            </li>

                            <!-- Payment Settings -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/payment') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.payment') }}">
                                    <i class="fas fa-credit-card sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Payment Settings </span>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/social') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.social') }}">
                                    <i class="fab fa-facebook-f sidenav-mini-icon side-bar-inner"></i>

                                    <span class="sidenav-normal side-bar-inner"> Social Settings </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/contact-info') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.contact-info') }}">
                                    <i class="fas fa-address-book sidenav-mini-icon side-bar-inner"></i>
                                    <!-- contact icon -->
                                    <span class="sidenav-normal side-bar-inner"> Contact Info Settings </span>
                                </a>
                            </li>



                            <!-- Password Settings -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/settings/password') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.password') }}">
                                    <i class="fas fa-lock sidenav-mini-icon side-bar-inner"></i>
                                    <span class="sidenav-normal side-bar-inner"> Password Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>





                <li class="nav-item">
                    <a class="nav-link" wire:click.prevent="logout" href="#">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-right-from-bracket text-secondary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <hr class="horizontal dark mt-2">
</aside>
