<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserEmployeeController;
use App\Http\Controllers\UserSignInController;
use App\Http\Controllers\UserSignUpController;
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

    Route::get('/sign-in/customer', [UserSignInController::class, 'showCustomerForm'])
        ->name('sign-in.customer');
    Route::get('/sign-in/employee', [UserSignInController::class, 'showEmployeeForm'])
        ->name('sign-in.employee');
    Route::get('/admin', [UserSignInController::class, 'showAdminForm'])
        ->name('sign-in.admin');
    
    Route::post('/sign-in', [UserSignInController::class, 'signIn'])
        ->name('sign-in.submit');

    Route::get('/sign-up', [UserSignUpController::class, 'showCustomerForm'])
        ->name('sign-up');
    Route::post('/sign-up', [UserSignUpController::class, 'signUp'])
        ->name('sign-up.submit');
});

// Admin Routes (Admin Access)
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/dashboard', function () {
        if (Auth::user()->user_type === 'admin') {
            return view('admin.dashboard.analytics');
        }
        return abort(403); // Forbidden for non-employees & customers
    })->name('admin-dashboard');

    // Product Management (Admin Only)
    Route::prefix('items')->group(function() {
        Route::get('/', [ItemController::class, 'showItemsTable'])
            ->name('items-table');
        Route::get('/create-item', [ItemController::class, 'showItemForm'])
            ->name('create-item');
        Route::post('/store-item', [ItemController::class, 'storeItem'])
            ->name('store-item');
        Route::get('/{item}', [ItemController::class, 'showItemDetail'])
            ->name('show-item');
        Route::get('/{item}/edit', [ItemController::class, 'editItem'])
            ->name('edit-item');
        Route::post('/{item}/update', [ItemController::class, 'updateItem'])
            ->name('update-item');
        Route::post('/{item}/delete', [ItemController::class, 'deleteItem'])
            ->name('delete-item');
    });

    // Service Type Management
    Route::prefix('service-types')->group(function() {
        Route::get('/', [ServiceTypeController::class, 'showServiceTypesTable'])
            ->name('service-type-table');
        Route::get('/create-service-type', [ServiceTypeController::class, 'showServiceTypeForm'])
            ->name('create-service-type');
        Route::post('/store-service-type', [ServiceTypeController::class, 'storeServiceType'])
            ->name('store-service-type');
        Route::get('/{serviceType}/edit', [ServiceTypeController::class, 'editServiceType'])
            ->name('edit-service-type');
        Route::post('/{serviceType}/update', [ServiceTypeController::class, 'updateServiceType'])
            ->name('update-service-type');
        Route::post('/{serviceType}/delete', [ServiceTypeController::class, 'deleteServiceType'])
            ->name('delete-service-type');
    });

    // User Management - Customers (Admin Access Only)
    Route::prefix('customers')->group(function() {
        Route::get('/', [UserCustomerController::class, 'showCustomersTable'])
            ->name('customers-table');
    });
    // User Management - Employees (Admin Access Only)
    Route::prefix('employees')->group(function() {
        Route::get('/', [UserEmployeeController::class, 'showEmployeesTable'])
            ->name('employees-table');
    });

    // Logout Route
    Route::post('/sign-out', function() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('sign-in.selection');
    })->name('sign-out');
});

Route::middleware('auth')->group(function() {
    // Customer Routes
    Route::get('/{customerId}', [UserCustomerController::class, 'showCustomerProfile'])
        ->name('customer.profile');
    Route::post('/{customerId}', [UserCustomerController::class, 'updateCustomerProfile'])
        ->name('customer.profile_update');
    
    // Logout Route
    Route::post('/sign-out', function() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('sign-in.selection');
    })->name('sign-out');
});

// Address API Routes
Route::prefix('address')->group(function() {
    Route::get('/countries', [AddressController::class, 'getCountries']);
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{provinceCode}', [AddressController::class, 'getStates']);
    Route::get('/barangays/{stateCode}', [AddressController::class, 'getBarangays']);
});

