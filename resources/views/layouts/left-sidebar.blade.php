<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    
    <!-- LOGO -->
    <a href="{{ route('home') }}" class="logo text-center bg-sunlit w-80">
        <span class="logo-lg bg-sunlit">
            <img src="/images/logo.png" alt="" height="48">
        </span>
        <span class="logo-sm">
            <img src="/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">
            @can('view dashboard')
            <li class="side-nav-item {{ (Request::is('dashboard*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('dashboard')}}" class="side-nav-link {{ (Request::is('dashboard*') ? ' active' : '') }}">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            @endcan

            @can('list inventories')
            <li class="side-nav-item {{ (Request::is('inventory*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('inventory')}}" class="side-nav-link {{ (Request::is('inventory*') ? ' active' : '') }}">
                    <i class="uil-shop"></i>
                    <span> Inventory </span>
                </a>
            </li>
            @endcan

            <li class="side-nav-title side-nav-item mt-4">Orders</li>

            @can('list sale orders')
            <li class="side-nav-item {{ (Request::is('sale-orders*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('sale-orders')}}" class="side-nav-link {{ (Request::is('sale-orders*') ? ' active' : '') }}">
                    <i class="mdi mdi-basket-outline"></i>
                    <span> Sales </span>
                </a>
            </li>
            @endcan

            @can('list purchase orders')
            <li class="side-nav-item {{ (Request::is('purchase-orders*') ? ' menuitem-active' : '') }}">
                <a data-bs-toggle="collapse" href="#sidebarPurchases" aria-expanded="false" aria-controls="sidebarPurchases" class="side-nav-link">
                    <i class="mdi mdi-cart-outline"></i>
                    <span> Purchases </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPurchases">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('purchase-orders')}}">Orders</a>
                        </li>
                        <li>
                            <a href="{{ route('purchase-order-invoices')}}">Invoices</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            
            
    
            <li class="side-nav-title side-nav-item mt-4">Components</li>
            @can('list products')
            <li class="side-nav-item {{ (Request::is('products*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('products')}}" class="side-nav-link {{ (Request::is('products*') ? ' active' : '') }}">
                    <i class="uil-shop"></i>
                    <span> Products </span>
                </a>
            </li>
            @endcan
            @can('list suppliers')
            <li class="side-nav-item {{ (Request::is('suppliers*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('suppliers')}}" class="side-nav-link {{ (Request::is('suppliers*') ? ' active' : '') }}">
                    <i class="uil-truck-loading"></i>
                    <span> Suppliers </span>
                </a>
            </li>
            @endcan
            @can('list dealers')
            <li class="side-nav-item {{ (Request::is('dealers*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('dealers')}}" class="side-nav-link {{ (Request::is('dealers*') ? ' active' : '') }}">
                    <i class="uil-users-alt"></i>
                    <span> Dealers </span>
                </a>
            </li>
            @endcan
            @can('list warehouses')
            <li class="side-nav-item {{ (Request::is('warehouses*') ? ' menuitem-active' : '') }}">
                <a href="{{ route('warehouses')}}" class="side-nav-link {{ (Request::is('warehouses*') ? ' active' : '') }}">
                    <i class="mdi mdi-store"></i>
                    <span> Warehouses </span>
                </a>
            </li>
            @endcan


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false" aria-controls="sidebarSettings" class="side-nav-link">
                    <i class="uil-server"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSettings">
                    <ul class="side-nav-second-level">
                        @can('list taxes')
                        <li>
                            <a href="{{ route('taxes')}}" {{ (Request::is('taxes*') ? 'class=" active"' : '') }}>
                                <span> Taxes </span>
                            </a>
                        </li>
                        @endcan
                        @can('list categories')
                        <li>
                            <a href="{{ route('categories')}}" {{ (Request::is('categories*') ? 'class=" active"' : '') }}>
                                <span> Categories </span>
                            </a>
                        </li>
                        @endcan
                        @can('list users')
                        <li>
                            <a href="{{ route('users')}}" {{ (Request::is('users*') ? 'class=" active"' : '') }}>
                                <span> Users </span>
                            </a>
                        </li>
                        @endcan

                        <li>
                            <a href="{{ route('freight-zones')}}" {{ (Request::is('freight-zones*') ? 'class=" active"' : '') }}>
                                <span> Freight Zones </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('states')}}" {{ (Request::is('states*') ? 'class=" active"' : '') }}>
                                <span> States </span>
                            </a>
                        </li>

                        @can('edit settings')
                        <li>
                            <a href="{{ route('settings')}}" {{ (Request::is('settings*') ? 'class=" active"' : '') }}>
                                <span> Global Settings </span>
                            </a>
                        </li>
                        @endcan 
                    </ul>
                </div>
            </li>

        </ul>

        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->