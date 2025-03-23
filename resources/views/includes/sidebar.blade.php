@if (auth()->check() && auth()->user()->user_type === 'admin')
    <aside class="app-sidebar bg-body-secondary shadow">
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin-dashboard') }}" class="nav-link {{ request()->routeIs('admin-dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
    
                    <!-- Inventory Management -->
                    <li class="nav-header">Inventory Management</li>
                    <li class="nav-item">
                        <a href="{{ route('items-table') }}" class="nav-link {{ request()->routeIs('items-table') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box"></i>
                            <p>Items</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-tools"></i>
                            <p>Equipments</p>
                        </a>
                    </li>
    
                    <!-- User Management -->
                    <li class="nav-header">User Management</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('employees-table') }}" class="nav-link {{ request()->routeIs('employees-table') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customers-table') }}" class="nav-link {{ request()->routeIs('customers-table') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-circle"></i>
                            <p>Customers</p>
                        </a>
                    </li>
    
                    <!-- Transaction Management -->
                    <li class="nav-header">Transaction Management</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-calendar-check"></i>
                            <p>Reservations</p>
                        </a>
                    </li>

                    <!-- Service Management -->
                    <li class="nav-header">Services Management</li>
                    <li class="nav-item">
                        <a href="{{ route('service-type-table') }}" class="nav-link {{ request()->routeIs('service-type-table') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-list-check"></i>
                            <p>Service Types</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
@endif
