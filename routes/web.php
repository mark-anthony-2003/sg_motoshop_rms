<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserSignInController;
use App\Http\Controllers\UserSignUpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.index');
})->name('home-page');

Route::middleware('auth')->group(function() {
    // dashboard for employees onlys
    Route::get('/dashboard', function () {
        if (Auth::user()->user_type === 'employee') {
            return view('admin.dashboard.analytics');
        }
        return abort(403); // Forbidden for non-employees
    })->name('admin-dashboard');

    // product management (only for employees)
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

    // service type management
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

    // logout
    Route::post('/sign-out', function() {
        Auth::logout();
        return redirect()->route('sign-in.selection');
    })->name('sign-out');
});

// guests routes
Route::middleware('guest')->group(function() {
    Route::get('/sign-in-selection', function() {
        return view('pages.auth.index');
    })->name('sign-in.selection');

    Route::get('/sign-in/customer', [UserSignInController::class, 'showCustomerForm'])
        ->name('sign-in.customer');
    Route::get('/sign-in/employee', [UserSignInController::class, 'showEmployeeForm'])
        ->name('sign-in.employee');
    
    Route::post('/sign-in', [UserSignInController::class, 'signIn'])
        ->name('sign-in.submit');

    Route::get('/sign-up', [UserSignUpController::class, 'showCustomerForm'])
        ->name('sign-up');
    Route::post('/sign-up', [UserSignUpController::class, 'signUp'])
        ->name('sign-up.submit');
});

// address api routes
Route::prefix('address')->group(function() {
    Route::get('/countries', [AddressController::class, 'getCountries']);
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{provinceCode}', [AddressController::class, 'getStates']);
    Route::get('/barangays/{stateCode}', [AddressController::class, 'getBarangays']);
});

