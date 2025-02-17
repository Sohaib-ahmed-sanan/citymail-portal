<div class="app-header">
    <div class="d-flex">
        <button class="navbar-toggler hamburger hamburger--elastic toggle-sidebar" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
        <button class="navbar-toggler hamburger hamburger--elastic toggle-sidebar-mobile" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </div>
    <div class="d-flex align-items-center">
        <div class="search-link">
            <div class="d-none d-lg-flex">
                <i class="fas search-icon fa-search"></i>
                <input type="text" class="number" placeholder="Track Shipments...." id="track-nav" onkeyup=""
                    autocomplete="off">
            </div>
        </div>
        <div class="user-box ml-2">
            <a href="#" data-trigger="click"
                data-popover-class="popover-secondary popover-custom-wrapper popover-custom-lg"
                data-rel="popover-close-outside" data-tip="account-popover"
                class="p-0 d-flex align-items-center popover-custom" data-placement="bottom" data-boundary="'viewport'">
                <div class="d-block p-0 avatar-icon-wrapper">
                    <span class="badge badge-circle badge-success p-top-a">Online</span>
                    <div class="avatar-icon rounded">
                        <img src="{{ asset('images/default/svg/avatar.svg') }}" alt="">
                    </div>
                </div>
                <div class="d-none d-md-block pl-2">
                    <div class="font-weight-bold">
                        {{ session('first_name') }}
                    </div>
                </div>
                <span class="pl-3"><i class="fas fa-angle-down opacity-5"></i></span>
            </a>
        </div>
        <div id="account-popover" class="d-none">
            <li class="list-group-item rounded-top">
                <ul class="nav nav-pills nav-pills-hover flex-column">
                    <li class="nav-header d-flex text-primary pt-1 pb-2 font-weight-bold align-items-center">
                        <div>
                            Profile options
                        </div>
                        <div class="ml-auto font-size-xs">
                            <a href="#" title="">
                            </a>
                        </div>
                    </li>
                    @if (session('type') == '1')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('admin.company_settings') }}">
                                Company Settings
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ is_portal() || is_customer_sub() ? Route('admin.customerProfile') : Route('admin.profile') }}">
                            My Account
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ Route('admin.changePass') }}">
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Route('admin.developer-center') }}">
                            Developer Center
                        </a>
                    </li>
                </ul>
            </li>
            <li class="list-group-item rounded-bottom text-center">
                <a href="{{ Route('admin.logout') }}" class="ml-1 btn-logout-icon" title="">
                    <i class="fas fa-power-off mr-1"></i>
                </a>
            </li>
        </div>
    </div>
</div>
