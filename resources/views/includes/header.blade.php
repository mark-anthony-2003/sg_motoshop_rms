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

            @if (auth()->check() && auth()->user()->user_type === 'customer')
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-cart fs-5"></i>
                        @if ($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 300px;" id="cartDropdown">
                        <form action="{{ route('shop.orderSummary') }}" method="POST">
                            @csrf
                            {{-- Cart Items --}}
                            @forelse($carts as $cart)
                                <li class="d-flex align-items-center px-3 py-2">
                                    <input 
                                        type="checkbox"
                                        name="selected_items[]"
                                        value="{{ $cart->cart_id }}"
                                        class="form-check-input me-2 item-checkbox"
                                        id="cart-item-{{ $cart->item_id }}"
                                        data-price="{{ $cart->item->price }}"
                                        data-id="{{ $cart->item_id }}">
                                    <img 
                                        src="{{ asset('storage/' . $cart->item->item_image) }}"
                                        alt="{{ $cart->item->item_name }}"
                                        width="50"
                                        class="rounded me-3">
                                    <div class="flex-grow-1">
                                        <label for="cart-item-{{ $cart->item->item_id }}">
                                            <p class="mb-0 fw-semibold">{{ Str::title($cart->item->item_name) }}</p>
                                        </label>
                                        <small class="text-muted">₱{{ number_format($cart->item->price, 2) }}</small>

                                        <!-- Quantity Controls -->
                                        <div class="input-group mt-2" style="width: auto;" onclick="event.stopPropagation();">
                                            <button 
                                                type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="changeCartQuantity('{{ $cart->item_id }}', -1)"
                                                {{ $cart->item->item_status === 'out_of_stock' ? 'disabled' : '' }}>-</button>

                                            <input 
                                                type="number"
                                                id="quantity-{{ $cart->item->item_id }}"
                                                name="quantities[{{ $cart->item->item_id }}]"
                                                class="form-control text-center quantity-input"
                                                style="max-width: 70px;"
                                                min="1"
                                                max="{{ $cart->item->stocks }}"
                                                value="{{ $cart->quantity }}"
                                                data-id="{{ $cart->item_id }}"
                                                required>

                                            <button 
                                                type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="changeCartQuantity('{{ $cart->item_id }}', 1)"
                                                {{ $cart->item->item_status === 'out_of_stock' ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center p-3">
                                    <p class="mb-0">Your cart is empty.</p>
                                </li>
                            @endforelse

                            <li><hr class="dropdown-divider"></li>

                            <li class="d-flex justify-content-between align-items-center px-3 py-2">
                                @if($carts->count() > 0)
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                        <label for="selectAll" class="fw-semibold">All</label>
                                    </div>
                                @endif

                                <div class="ms-auto text-end">
                                    <p class="fw-semibold mb-1">Total: ₱<span id="totalAmount">0.00</span></p>
                                    <button type="submit" class="btn btn-dark btn-sm" id="checkoutButton" disabled>
                                        Check out ({{ $cartCount }})
                                    </button>
                                </div>
                            </li>
                        </form>
                    </ul>
                </div>
            @endif

            @auth
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-bold text-primary bg-light px-3 py-2 rounded-pill">
                            {{ strtoupper(auth()->user()->first_name[0]) }}{{ strtoupper(auth()->user()->last_name[0]) }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 300px;">
                        <li class="text-center py-3 fw-bold">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll')
        const itemCheckboxes = document.querySelectorAll('.item-checkbox')
        const checkoutButton = document.getElementById('checkoutButton')
        const totalAmountDisplay = document.getElementById('totalAmount')
        const quantityInputs = document.querySelectorAll('.quantity-input')

        selectAllCheckbox?.addEventListener('change', function () {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked
            })
            updateCartSummary()
        })

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCartSummary)
        })

        quantityInputs.forEach(input => {
            input.addEventListener('input', updateCartSummary)
        })

        window.changeCartQuantity = function(itemId, change) {
            const quantityInput = document.getElementById(`quantity-${itemId}`)
            if (!quantityInput) return

            let currentValue = parseInt(quantityInput.value) || 1
            const max = parseInt(quantityInput.max) || Infinity
            const min = parseInt(quantityInput.min) || 1

            const newValue = currentValue + change
            if (newValue >= min && newValue <= max) {
                quantityInput.value = newValue
                updateCartSummary()
            }
        }

        function updateCartSummary() {
            let totalAmount = 0
            let isAnyChecked = false

            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const itemId = checkbox.getAttribute('data-id')
                    const price = parseFloat(checkbox.getAttribute('data-price')) || 0
                    const quantityInput = document.getElementById(`quantity-${itemId}`)
                    const quantity = parseInt(quantityInput.value) || 1

                    totalAmount += price * quantity
                    isAnyChecked = true
                }
            })

            totalAmountDisplay.textContent = totalAmount.toFixed(2)
            checkoutButton.disabled = !isAnyChecked
            selectAllCheckbox.checked = itemCheckboxes.length > 0 && Array.from(itemCheckboxes).every(checkbox => checkbox.checked)
        }
    })
</script>
