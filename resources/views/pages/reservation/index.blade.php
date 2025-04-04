@extends('includes.app')

@section('content')
    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">SG MOTOSHOP RESERVATION FORM</h2>

        <div class="card shadow p-4">
            <form action="{{ route('shop.reservation.submit', $customer->user_id) }}" method="POST">
                @csrf

                {{-- Customer Information --}}
                <div class="mb-4">
                    <h4 class="fw-bold border-bottom pb-2">Customer's Information</h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $customer->first_name) }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $customer->last_name) }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <h4 class="fw-bold border-bottom pb-2">Address</h4>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" name="barangay" class="form-control" value="{{ old('barangay', $address->first()->barangay ?? '') }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $address->first()->city ?? '') }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" name="province" class="form-control" value="{{ old('province', $address->first()->province ?? '') }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $address->first()->country ?? '') }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="mb-4">
                    <h4 class="fw-bold border-bottom pb-2">Contact Information</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_no" class="form-label">Contact No</label>
                            <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no', $customer->contact_no) }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address (optional)</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Service Selection --}}
                <div class="row">
                    {{-- Available Services --}}
                    <div class="col-md-6">
                        <h4 class="fw-bold border-bottom pb-2">Available Services</h4>
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Service Offered</th>
                                    <th>Cost/Price</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($serviceTypes as $serviceType)
                                    <tr>
                                        <td>{{ $serviceType->service_type_name }}</td>
                                        <td>₱{{ number_format($serviceType->service_type_price, 2) }}</td>
                                        <td>
                                            <input type="checkbox" 
                                                class="service-checkbox" 
                                                data-price="{{ $serviceType->service_type_price }}"
                                                data-name="{{ $serviceType->service_type_name }}"
                                                value="{{ $serviceType->service_type_id }}" 
                                                name="serviceTypes[]">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Services Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Selected Services --}}
                    <div class="col-md-6">
                        <h4 class="fw-bold border-bottom pb-2">Selected Services</h4>
                        <ul id="selected-services" class="list-group mb-3 min-vh-50"></ul>

                        <h4 class="fw-bold">Total: <span id="total-price">₱0.00</span></h4>
                    </div>
                </div>

                {{-- Transaction Date --}}
                <div class="mb-4">
                    <h4 class="fw-bold border-bottom pb-2">Transaction Date</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="preferred_date" class="form-label">Preferred Date</label>
                            <input type="date" name="preferred_date" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="mb-4">
                    <h4 class="fw-bold border-bottom pb-2">Payment Method</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="radio" name="payment_method" value="cash" class="form-check-input" id="cash_on_delivery">
                                <label class="form-check-label" for="cash">Cash</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="payment_method" value="gcash" class="form-check-input" id="gcash">
                                <label class="form-check-label" for="gcash">GCash</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="ref_no" class="form-label">Reference No (If Online Payment)</label>
                            <input type="text" name="ref_no" class="form-control" id="ref_no">
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-dark btn-md">Submit Reservation</button>
                </div>

            </form>
        </div>
    </div>

    {{-- JavaScript for Dynamic Price Calculation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".service-checkbox");
            const totalPriceEl = document.getElementById("total-price");
            const selectedServicesEl = document.getElementById("selected-services");

            function updateTotal() {
                let total = 0;
                selectedServicesEl.innerHTML = "";

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.dataset.price);

                        // Add to selected services list
                        let li = document.createElement("li");
                        li.textContent = checkbox.closest("tr").querySelector("td:first-child").textContent;
                        li.classList.add("list-group-item");
                        selectedServicesEl.appendChild(li);
                    }
                });

                totalPriceEl.textContent = `₱${total.toFixed(2)}`;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateTotal);
            });
        });
    </script>
@endsection
