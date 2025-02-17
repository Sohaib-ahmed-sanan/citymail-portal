<div class="app-sidebar  app-sidebar--light">
    <div class="app-sidebar--header">
        <div class="nav-logo w-100 text-center">
            <a href="{{ Route('admin.index') }}" class="d-block brand-logo" data-toggle="tooltip" title="">
                <img src="{{ asset(session('company_logo') == 'orio-logo.svg' ? 'images/default/svg/' . session('company_logo') : 'images/' . session('company_id') . '/' . session('company_logo')) }}"
                    alt="">
            </a>
        </div>
        <button class="toggle-sidebar rounded-circle btn btn-sm bg-white shadow-sm-dark text-primary"
            data-toggle="tooltip" data-placement="right" title="Expand sidebar" type="button">
            <i class="fas fa-arrows-alt-h"></i>
        </button>
    </div>
    <div class="app-sidebar--content scrollbar-container">
        <div class="sidebar-navigation">
            <ul id="sidebar-nav">
                <li class="sidebar-header">
                    <button style="width: 172px !important;" class="btn btn-create"
                        onclick="window.location.href = '{{ Route('admin.add_edit_bookings') }}'">Create Shipments</button>
                </li>
                <li class="sidebar-header text-center">
                    {{ session('company_name') }}&nbsp&nbsp{{ is_ops() ? 'OPS' : 'Portal' }}
                </li>
                <li>
                    <a href="{{ Route('admin.index') }}" aria-expanded="true">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-pie-chart">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                            <span>Dashboard</span>
                        </span>
                    </a>
                </li>
                @foreach (session('menues') as $key => $mainMenu)
                    @if ($mainMenu->parent_id === null)
                        <li class="m-menu__item{{ $loop->iteration }} m-menu__item--submenu{{ $loop->iteration }} ">
                            <a href="javascript:void(0);" aria-expanded="true">
                                <span>
                                    @if ((is_portal() || is_customer_sub()) && $mainMenu->title == 'Operations')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                    @else
                                        {!! $mainMenu->icon !!}
                                    @endif
                                    <span>
                                        @if (is_portal() || is_customer_sub())
                                            @if ($mainMenu->title == 'Admin')
                                                {{ 'Account' }}
                                            @elseif ($mainMenu->title == 'Operations')
                                                {{ 'Shipments' }}
                                            @else
                                                {{ $mainMenu->title }}
                                            @endif
                                        @else
                                            {{ $mainMenu->title }}
                                        @endif
                                    </span>
                                </span><i class="fas fa-angle-right"></i>
                            </a>
                            <ul aria-expanded="true" class="animated fade mm-collapse" style="">
                                @php $subCount = 1; @endphp
                                @foreach (session('menues') as $subMenu)
                                    @if ($subMenu->parent_id !== null)
                                        @if ($subMenu->parent_id == $mainMenu->id)
                                        @if($subMenu->id == '10')
                                            @php session()->put('is_loadsheet','1');@endphp
                                        @endif
                                          @if($subMenu->id != '39')
                                                <li
                                                    class="m-menu__item{{ $subCount }} {{ Route::is($subMenu->route) ? 'mm-active' : '' }}">
                                                    <a class="sub_menu__items pr-2" href="{{ route($subMenu->route) }}">
                                                        <span>{{ $subMenu->title }}</span>
                                                    </a>
                                                </li>
                                                @php $subCount++; @endphp
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
                <li class="m-menu__item-def m-menu__item--submenu-def ">
                    <a href="javascript:void(0);" aria-expanded="true">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                            <span>Listings</span>
                        </span><i class="fas fa-angle-right"></i>
                    </a>
                    <ul aria-expanded="true" class="animated fade mm-collapse" style="">
                        <li
                            class="m-menu__item-def {{ Route::is('admin.city-list') ? 'mm-active' : '' }}">
                            <a class="sub_menu__items pr-2" href="{{ route('admin.city-list') }}">
                                <span>Cities List</span>
                            </a>
                        </li>          
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="app-sidebar--footer d-block text-center py-3">
        <a href="{{ Route('admin.logout') }}" class="btn btn-secondary-orio btn-logout Montserrat-Regular"><i
                class="fas fa-power-off mr-1" aria-hidden="true"></i> Log Out</a>
    </div>
</div>
<div class="sidebar-mobile-overlay"></div>
