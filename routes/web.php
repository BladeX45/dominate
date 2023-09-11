<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstructureController;
use App\Http\Controllers\TransactionController;

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
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
// Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

// route group prefix
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::get('/dashboard', [PageController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/users', [PageController::class, 'users'])->name('admin.users');
    Route::get('/customers', [PageController::class, 'customers'])->name('admin.customers');
    Route::get('/assets', [PageController::class, 'assets'])->name('admin.assets');
    Route::get('/plans', [PageController::class, 'plans'])->name('admin.plans');
    Route::post('/add-asset',[CarController::class, 'store'])->name('admin.addAsset');
    Route::post('/add-plan',[PlanController::class, 'store'])->name('admin.addPlan');
    Route::post('/add-User', [UserController::class, 'registerUser'])->name('admin.addUser');
    Route::get('/edit-plan/{id}',[PlanController::class, 'edit'])->name('admin.editPlan');
    Route::post('/update-plan/{id}',[PlanController::class, 'update'])->name('admin.updatePlan');
    Route::delete('/delete-plan/{id}',[PlanController::class, 'destroy'])->name('admin.deletePlan');
    Route::get('/edit-asset/{id}',[CarController::class, 'edit'])->name('admin.editAsset');
    Route::get('/show-instructor/{id}', [InstructureController::class, 'show'])->name('admin.showInstructor');
    Route::get('/transactions', [PageController::class, 'indexTransactions'])->name('admin.transactions');
});

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
		Route::get('pricing', ['as' => 'pages.pricing', 'uses' => 'App\Http\Controllers\PageController@pricing']);
		// Route::get('pricing', ['as' => 'pages.pricing', 'uses' => 'App\Http\Controllers\PageController@pricing']);
        // // profile.photo

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile', ['as' => 'profile.photo', 'uses' => 'App\Http\Controllers\ProfileController@updatePhoto']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

// Route group prefix for customer
Route::group(['prefix' => 'customer', 'middleware' => ['auth']], function(){
    Route::get('/dashboard', [PageController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::post('/orders', [TransactionController::class, 'order'])->name('customer.orders');
    Route::get('/transactions', [TransactionController::class, 'customerTransactions'])->name('customer.transactions');
    // upload evidence
    Route::put('/upload-evidence', [TransactionController::class, 'uploadEvidence'])->name('customer.uploadEvidence');
});

