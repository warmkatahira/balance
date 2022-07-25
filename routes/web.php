<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceRegisterController;
use App\Http\Controllers\BalanceDeleteController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CargoHandlingController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\ExpensesItemController;
use App\Http\Controllers\LaborCostSettingController;
use App\Http\Controllers\MonthlyExpensesSettingController;
use App\Http\Controllers\BalanceListController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\BalanceModifyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    // ホーム
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');
    Route::post('/home', [HomeController::class, 'month_result_disp'])->name('home.search');
    Route::get('/balance_progress_get_ajax', [HomeController::class, 'balance_progress_get_ajax']);

    // 収支登録
    Route::get('/balance_register', [BalanceRegisterController::class, 'index'])->name('balance_register.index');
    Route::post('/balance_register', [BalanceRegisterController::class, 'register'])->name('balance_register.register');
    Route::get('/balance_get_ajax/{balance_id}', [BalanceRegisterController::class, 'balance_get_ajax'])->name('balance.get_ajax');
    Route::get('/balance_register_customer_data_get_ajax/{customer_id}', [BalanceRegisterController::class, 'balance_register_customer_data_get_ajax'])->name('balance_register.cargo_handling_get_ajax');

    // 収支一覧
    Route::get('/balance_list', [BalanceListController::class, 'index'])->name('balance_list.index');
    Route::get('/balance_list_search', [BalanceListController::class, 'search'])->name('balance_list.search');
    Route::get('/get_customer_ajax/{base_id}', [BalanceListController::class, 'get_customer_ajax']);
    Route::get('/balance_list_zensha', [BalanceListController::class, 'index_zensha'])->name('balance_list_zensha.index');
    Route::get('/balance_list_base', [BalanceListController::class, 'index_base'])->name('balance_list_base.index');
    Route::get('/balance_list_customer', [BalanceListController::class, 'index_customer'])->name('balance_list_customer.index');
    Route::get('/balance_detail/id={balance_id}', [BalanceListController::class, 'detail'])->name('balance_list.detail');
    Route::get('/balance_detail_get_ajax/{balance_id}', [BalanceListController::class, 'balance_detail_get_ajax']);
    Route::get('/balance_delete', [BalanceDeleteController::class, 'delete'])->name('balance.delete');
    Route::get('/balance_modify', [BalanceModifyController::class, 'index'])->name('balance_modify.index');
    Route::post('/balance_modify', [BalanceModifyController::class, 'modify'])->name('balance_modify.modify');

    // 拠点マスタ
    Route::get('/base', [BaseController::class, 'index'])->name('base.index');
    Route::get('/monthly_expenses_setting/{base_id}', [MonthlyExpensesSettingController::class, 'index'])->name('monthly_expenses_setting.index');
    Route::get('/monthly_expenses_setting_search', [MonthlyExpensesSettingController::class, 'index_search'])->name('monthly_expenses_setting.search');
    Route::post('/monthly_expenses_setting_register', [MonthlyExpensesSettingController::class, 'register'])->name('monthly_expenses_setting.register');
    Route::get('/monthly_expenses_setting_delete/{monthly_expenses_setting_id}', [MonthlyExpensesSettingController::class, 'delete'])->name('monthly_expenses_setting.delete');
    Route::get('/labor_cost_setting/{base_id}', [LaborCostSettingController::class, 'index'])->name('labor_cost_setting.index');
    Route::post('/labor_cost_setting_update', [LaborCostSettingController::class, 'update'])->name('labor_cost_setting.update');

    // 荷主マスタ
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer_search', [CustomerController::class, 'index_search'])->name('customer_search.index');
    Route::post('/customer_register', [CustomerController::class, 'register'])->name('customer.register');
    Route::get('/customer_detail/{customer_id}', [CustomerController::class, 'detail'])->name('customer.detail');
    Route::post('/customer_setting_update', [CustomerController::class, 'customer_setting_update'])->name('customer_setting.update');
    Route::get('/customer_base_info', [CustomerController::class, 'base_info_index'])->name('customer_base_info.index');
    Route::post('/customer_base_info', [CustomerController::class, 'base_info_update'])->name('customer_base_info.update');
    Route::get('/customer_cargo_handling_setting', [CustomerController::class, 'cargo_handling_setting_index'])->name('customer_cargo_handling_setting.index');
    Route::post('/customer_cargo_handling_setting', [CustomerController::class, 'cargo_handling_setting_update'])->name('customer_cargo_handling_setting.update');
    Route::get('/customer_shipping_method_setting', [CustomerController::class, 'shipping_method_setting_index'])->name('customer_shipping_method_setting.index');
    Route::post('/customer_shipping_method_setting', [CustomerController::class, 'shipping_method_setting_update'])->name('customer_shipping_method_setting.update');

    // 荷役マスタ
    Route::get('/cargo_handling', [CargoHandlingController::class, 'index'])->name('cargo_handling.index');
    Route::post('/cargo_handling_register', [CargoHandlingController::class, 'register'])->name('cargo_handling.register');

    // 経費項目マスタ
    Route::get('/expenses_item', [ExpensesItemController::class, 'index'])->name('expenses_item.index');
    Route::post('/expenses_item_register', [ExpensesItemController::class, 'register'])->name('expenses_item.register');

    // 売上項目マスタ
    Route::get('/sales_item', [SalesItemController::class, 'index'])->name('sales_item.index');
    Route::post('/sales_item_register', [SalesItemController::class, 'register'])->name('sales_item.register');

    // 配送方法マスタ
    Route::get('/shipping_method', [ShippingMethodController::class, 'index'])->name('shipping_method.index');

    // ユーザーマスタ
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});