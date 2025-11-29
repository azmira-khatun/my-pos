<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('assets-admin/dist/img/pages-makna-logo-2.webp') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">POS Project</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets-admin/dist/img/avatar2.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Azmira Khatun</a>
            </div>
        </div>

        <!-- Sidebar Search Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="{{ url('/dashboard') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('units.index') }}" class="nav-link @if(request()->routeIs('units.*')) active @endif">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>Units</p>
                    </a>
                </li>


{{-- Currencies (কারেন্সি) মডিউল --}}
<li class="nav-item">
    {{-- route('currencies.index') ব্যবহার করা হয়েছে --}}
    <a href="{{ route('currencies.index') }}" class="nav-link @if(request()->routeIs('currencies.*')) active @endif">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Currencies</p>
    </a>
</li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Reports <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ url('/report/purchase') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Purchase Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/sales') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Sales Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/inventory') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Inventory Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/profit-loss') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Profit/Loss Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/customers') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Customers Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/vendors') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Vendors Report</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
