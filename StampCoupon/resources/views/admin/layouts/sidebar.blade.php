<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (auth()->check())
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->email }}</a>
                </div>

            </div>
            <div>

                <a href="{{ route('admin.logout') }}" class="btn btn-block btn-danger btn-sm">Logout</a>
            </div>
        @endif

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if (auth()->check() && auth()->user()->type == Admin::TYPE_SYSTEM_ADMIN)
                    <li class="nav-item">
                        <a href="{{ route('admin.index') }}" class="nav-link">
                            <i class="nav-icon far fa-image"></i>
                            <p>
                                Admin
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('application.index') }}" class="nav-link">
                            <i class="nav-icon far fa-image"></i>
                            <p>
                                Application
                            </p>
                        </a>
                    </li>

                @endif
                <li class="nav-item">
                    <a href="{{ route('coupon.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Coupons
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stamp.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Stamps
                        </p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{ route('store.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Store
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Export Coupon
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

