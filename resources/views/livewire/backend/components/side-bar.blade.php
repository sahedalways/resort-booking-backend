<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps ps--active-y"
    id="sidenav-main" data-color="primary">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/img/site-logo.png') }}" class="navbar-brand-img h-100 scale-200" alt="main_logo">
            <span class="ms-2 h6 font-weight-bold text-uppercase">Sports Booking</span>
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
                {{-- 
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/manage-books') ? 'active' : '' }}"
                        href="{{ route('admin.manage-books') }}">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-book text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('messages.manage_books') }}</span>
                    </a>
                </li> --}}




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
