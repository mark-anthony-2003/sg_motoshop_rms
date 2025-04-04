<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdyenWebhookController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserEmployeeController;
use App\Http\Controllers\UserSignInController;
use App\Http\Controllers\UserSignUpController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceTransactionController;
use App\Http\Controllers\ShipmentController;
use App\Models\ServiceTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnSelf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Home Page
Route::get('/', function () {
    return view('pages.index');
})->name('home-page');

// Guest Routes (For Sign-in & Sign Up)
Route::middleware('guest')->group(function() {
    Route::get('/sign-in-selection', function() {
        // Check if the user is already logged in an redirect based on thier role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'admin') {
                return redirect()->route('admin-dashboard');
            } elseif ($user->user_type === 'employee') {
                return redirect()->route('home-page');
            } elseif ($user->user_type === 'customer') {
                return redirect()->route('home-page');
            }
        }
        return view('pages.auth.index');
    })->name('sign-in.selection');

    // Sign in as Admin
    Route::get('/admin', [UserSignInController::class, 'showAdminForm'])->name('sign-in.admin');

    // Sign in as Customer
    Route::get('/sign-in/customer', [UserSignInController::class, 'showCustomerForm'])->name('sign-in.customer');
    Route::post('/sign-in', [UserSignInController::class, 'signIn'])->name('sign-in.submit');
    // Sign up as Customer
    Route::get('/sign-up', [UserSignUpController::class, 'showCustomerForm'])->name('sign-up');
    Route::post('/sign-up', [UserSignUpController::class, 'signUp'])->name('sign-up.submit');
    
    // Sign in as Employee
    Route::get('/sign-in/employee', [UserSignInController::class, 'showEmployeeForm'])->name('sign-in.employee');
    Route::get('/sign-in/employee/manager', [UserSignInController::class, 'showEmployeeManagerForm'])->name('sign-in.employee-manager');
    Route::get('/sign-in/employee/laborer', [UserSignInController::class, 'showEmployeeLaborerForm'])->name('sign-in.employee-laborer');
    Route::post('/sign-in/employee', [UserSignInController::class, 'employeeSignin'])->name('sign-in.employee-submit');
});

// Admin Routes (Admin Access)
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/dashboard', function() {
        if (Auth::user()->user_type === 'admin') {
            return view('admin.dashboard.analytics');
        }
        return abort(403); // Forbidden for non-employees & customers
    })->name('admin-dashboard');

    // Product Management (Admin Only)
    Route::prefix('items')->group(function() {
        Route::get('/', [ItemController::class, 'showItemsTable'])->name('items-table');
        Route::get('/create-item', [ItemController::class, 'showItemForm'])->name('create-item');
        Route::post('/store-item', [ItemController::class, 'storeItem'])->name('store-item');
        Route::get('/{item}', [ItemController::class, 'showItemDetail'])->name('show-item');
        Route::get('/{item}/edit', [ItemController::class, 'editItem'])->name('edit-item');
        Route::post('/{item}/update', [ItemController::class, 'updateItem'])->name('update-item');
        Route::post('/{item}/delete', [ItemController::class, 'deleteItem'])->name('delete-item');
    });

    // Service Type Management
    Route::prefix('service-types')->group(function() {
        Route::get('/', [ServiceTypeController::class, 'showServiceTypesTable'])->name('service-type-table');
        Route::get('/create-service-type', [ServiceTypeController::class, 'showServiceTypeForm'])->name('create-service-type');
        Route::post('/store-service-type', [ServiceTypeController::class, 'storeServiceType'])->name('store-service-type');
        Route::get('/{serviceType}/edit', [ServiceTypeController::class, 'editServiceType'])->name('edit-service-type');
        Route::post('/{serviceType}/update', [ServiceTypeController::class, 'updateServiceType'])->name('update-service-type');
        Route::post('/{serviceType}/delete', [ServiceTypeController::class, 'deleteServiceType'])->name('delete-service-type');
    });

    // User Management - Customers (Admin Access Only)
    Route::prefix('customers')->group(function() {
        Route::get('/', [UserCustomerController::class, 'showCustomersTable'])->name('customers-table');
    });
    // User Management - Employees (Admin Access Only)
    Route::prefix('employees')->group(function() {
        Route::get('/', [UserEmployeeController::class, 'showEmployeesTable'])->name('employees-table');
        Route::get('/{employeeInfo}', [UserEmployeeController::class, 'adminShowEmployeeInfo'])->name('show-employeeInfo');
        Route::get('/{employeeInfo}/edit', [UserEmployeeController::class, 'adminEditEmployeeInfo'])->name('edit.employeeInfo');
        Route::post('/{employeeInfo}/update', [UserEmployeeController::class, 'adminUpdateEmployeeInfo'])->name('update.employeeInfo');
    });
});

// Employee Routes
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/manager-home', function() {
        return view('pages.auth.employee.manager_homepage');
    })->name('manager-homepage');

    Route::get('/laborer-home', function() {
        return view('pages.auth.employee.laborer_homepage');
    })->name('laborer-homepage');

    // Employee Routes
    Route::prefix('/employee')->group(function() {
        // Profile Settings
        Route::get('/{userId}', [UserEmployeeController::class, 'showEmployeeProfile'])->name('employee.profile');
        Route::post('/{userId}', [UserEmployeeController::class, 'updateEmployeeProfile'])->name('employee.profile_update');
    });
});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function() {
    // Customer Routes
    Route::prefix('customer')->group(function() {
        // Profile Settings
        Route::get('/{userId}/profile', [UserCustomerController::class, 'showCustomerProfile'])->name('customer.profile');
        Route::post('/{userId}/profile', [UserCustomerController::class, 'updateCustomerProfile'])->name('customer.profile_update');
    });

    Route::prefix('shop')->group(function() {
        // Items
        Route::get('/items', [OrderItemController::class, 'showItemCards'])->name('shop.items');
        Route::get('/items/{orderItemId}', [OrderItemController::class, 'showItemCardDetail'])->name('shop.showOrderItem');
        Route::post('/items/{orderItemId}', [OrderItemController::class, 'addToCartItem'])->name('shop.addToCartItem');

        // Orders
        Route::post('/order-summary', [OrderItemController::class, 'checkoutCartItems'])->name('shop.orderSummary');
        Route::get('/order-summary', [OrderItemController::class, 'showOrderSummary'])->name('shop.showOrderSummary');

        // Orders Payment
        Route::post('/payment/gcash', [PaymentController::class, 'processPayment'])->name('payment.process');
        Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
        Route::post('/webhook/adyen', [AdyenWebhookController::class, 'handle']);
        
        // Reservation
        Route::get('/reservation', [ServiceTransactionController::class, 'showReservationForm'])->name('shop.reservation');
        Route::post('/reservation/{customerId}', [ServiceTransactionController::class, 'makeReservation'])->name('shop.reservation.submit');
    });
});

// Address API Routes
Route::prefix('address')->group(function() {
    Route::get('/countries', [AddressController::class, 'getCountries']);
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{provinceCode}', [AddressController::class, 'getStates']);
    Route::get('/barangays/{stateCode}', [AddressController::class, 'getBarangays']);
});

// Universal Logout Route (for all authenticated users)
Route::middleware(['auth'])->post('/sign-out', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('sign-in.selection');
})->name('sign-out');

