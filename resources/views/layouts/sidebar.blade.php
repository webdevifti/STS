<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if(admin_logged_in())
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.dashboard' ? 'active':'' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
      
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.tickets.index' ? 'active':'' }}" href="{{ route('admin.tickets.index') }}">
                <i class="ri-ticket-2-fill"></i>
                <span>Tickets</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.categories.index' ? 'active':'' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-card-checklist"></i>
                <span>Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.labels.index' ? 'active':'' }}" href="{{ route('admin.labels.index') }}">
                <i class="bi bi-tag-fill"></i>
                <span>Labels</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'admin.customers.index' ? 'active':'' }}" href="{{ route('admin.customers.index') }}">
                <i class="ri-file-user-fill"></i>
                <span>Customers</span>
            </a>
        </li>
        @endif

        @if(customer_logged_in())
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'customer.dashboard' ? 'active':'' }}" href="{{ route('customer.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ Route::currentRouteName() == 'customer.tickets.index' ? 'active':'' }}" href="{{ route('customer.tickets.index') }}">
                <i class="ri-ticket-2-fill"></i>
                <span>My Tickets</span>
            </a>
        </li>
        @endif
    </ul>

</aside>
