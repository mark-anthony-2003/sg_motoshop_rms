<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('home-page') }}" class="nav-link fw-bold">SG</a>
            </li>
            @if (auth()->check() && (auth()->check() && auth()->user()->user_type === 'admin'))
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            @endif
        </ul>
        <ul class="navbar-nav">
            @if (
                !auth()->check() ||
                (auth()->check() && auth()->user()->user_type === 'customer') ||
                (auth()->check() && auth()->user()->user_type === 'employee'))
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('shop.items') }}" class="nav-link">Items</a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="#" class="nav-link">Services</a>
                </li>
            @endif
            @auth
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-bold text-primary bg-light px-3 py-2 rounded-pill">
                            {{ strtoupper(auth()->user()->first_name[0]) }}{{ strtoupper(auth()->user()->last_name[0]) }}
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
                        <li class="dropdown-header text-bg-primary text-center py-3 fw-bold">
                            {{ ucfirst(strtolower(auth()->user()->first_name)) }} {{ ucfirst(strtolower(auth()->user()->last_name)) }}
                        </li>                        
                        <li class="dropdown-divider"></li>
                        @if (auth()->check() && (auth()->check() && auth()->user()->user_type === 'customer'))
                            <li>
                                <a href="{{ route('customer.profile', ['userId' => auth()->user()->user_id]) }}" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2"></i> User Profile
                                </a>
                            </li>
                        @elseif (auth()->check() && (auth()->check() && auth()->user()->user_type === 'employee'))
                            <li>
                                <a href="{{ route('employee.profile', ['userId' => auth()->user()->user_id]) }}" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2"></i> User Profile
                                </a>
                            </li>
                        @endif
                        <li class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('sign-out') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>            
            @else
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('sign-in.selection') }}" class="nav-link">
                        Sign in
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>