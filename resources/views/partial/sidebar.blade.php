<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-solid fa-globe"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ERP Systems</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item  @if(in_array(Route::currentRouteName(), ['dashboard'])) active @endif">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    @if(Auth::user()->role_id == 1)
    <li class="nav-item @if(in_array(Route::currentRouteName(), ['product.index','product.create','product.edit'])) active @endif">
        <a class="nav-link" href="{{ route('product.index') }}">
            <i class="fas fa-solid fa-cart-plus"></i>
            <span>Inventory</span></a>
    </li>
    @endif
    <!-- Nav Item - Tables -->
    <li class="nav-item @if(in_array(Route::currentRouteName(), ['sales_orders.index','sales_orders.create','sales_orders.show'])) active @endif">
        <a class="nav-link" href="{{ route('sales_orders.index') }}">
            <i class="fas fa-solid fa-truck"></i>
            <span>Sales</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
