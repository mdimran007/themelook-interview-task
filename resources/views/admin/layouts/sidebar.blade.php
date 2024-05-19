<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{asset('admin')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{@$dashboardActive}}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.product.add')}}" class="nav-link {{@$productActive}}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Add Product
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.pos.index')}}" class="nav-link {{@$posActive}}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            POS
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.order.index')}}" class="nav-link {{@$orderActive}}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Order List
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
