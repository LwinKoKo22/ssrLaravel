<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\FeatureController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\TwoFactorCodeController;
use App\Http\Controllers\PageController as FrontEndController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend
Route::get('/',[FrontEndController::class,'index'])->middleware('auth:customer')->name('feature.room');
Route::get('/features/{feature}',[FrontEndController::class,'feature_detail']);
Route::get('/image',[FrontEndController::class,'image']);

Route::get('/customer/register', [CustomerController::class,'register'])->name('customer.register')->middleware('guest:customer');
Route::post('/customer/register',[CustomerController::class,'storeRegister'])->name('customer.storeRegister');
Route::get('/customer/login',[CustomerController::class,'login'])->middleware('guest:customer')->name('customerLogin');
Route::post('/customer/login',[CustomerController::class,'store'])->name('customer.store');
Route::post('/customer/logout',[CustomerController::class,'logout'])->name('customer.logout');

Route::post('/posts/store',[PostController::class,'store']);
Route::post('/posts/delete',[PostController::class,'destroy']);
Route::get('/posts/edit',[PostController::class,'edit']);
Route::post('/posts/update',[PostController::class,'update']);
// Auth
require __DIR__.'/auth.php';
Route::get('/verify/resend',[TwoFactorCodeController::class,'resend'])->name('verify.resend');
Route::resource('verify',TwoFactorCodeController::class)->only(['index','store']);
//Backend
Route::prefix('admin')->middleware(['auth','twoFactor'])->name('admin.')->group(function(){
    Route::get('/',[PageController::class,'index'])->name('dashboard');
    Route::resource('company',CompanyController::class);
    Route::get('/company/datatable/ssd',[CompanyController::class,'ssd']);
    Route::resource('employee',EmployeeController::class);
    Route::get('/employee/datatable/ssd',[EmployeeController::class,'ssd']);
    Route::get('/company_export',[CompanyController::class, 'get_employee_data'])->name('company.export');
    Route::get('/employee_export',[EmployeeController::class,'get_employee_data'])->name('employee.export');
    Route::resource('feature',FeatureController::class);
    Route::get('/feature/datatable/ssd',[FeatureController::class,'ssd']);
});
