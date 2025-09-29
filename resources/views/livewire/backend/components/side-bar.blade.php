<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps ps--active-y"
    id="sidenav-main" data-color="primary">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset(siteSetting()->logo_url) }}" class="navbar-brand-img h-100 scale-200" alt="main_logo">
            <span class="ms-2 h6 font-weight-bold text-uppercase">{{ siteSetting()->site_title }} </span>

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
                        <span class="nav-link-text ms-1">Manage Resort</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/resort-manage*') ? 'show' : '' }}" id="resortManage">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/resort-manage/service-type') ? 'active' : '' }}"
                                    href="{{ route('admin.resort-manage.service-type') }}">
                                    <i class="fas fa-concierge-bell sidenav-mini-icon side-bar-inner"></i>

                                    <span class="sidenav-normal side-bar-inner"> Service Type </span>
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
                    <a data-bs-toggle="collapse" href="#contentManage"
                        class="nav-link {{ Request::is('admin/content-manage*') ? 'active' : '' }}"
                        aria-controls="contentManage" role="button" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-folder-open text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Content Management</span>
                    </a>

                    <div class="collapse {{ Request::is('admin/content-manage*') ? 'show' : '' }}" id="contentManage">
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
