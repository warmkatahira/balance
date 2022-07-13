<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceRegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CargoHandlingController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LaborCostController;
use App\Http\Controllers\MonthlyExpenseSettingController;
use App\Http\Controllers\BalanceListDailyController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/balance_register', [BalanceRegisterController::class, 'index'])->name('balance_register.index');
Route::post('/balance_register', [BalanceRegisterController::class, 'register'])->name('balance_register.register');
Route::get('/balance_get_ajax/{balance_id}', [BalanceRegisterController::class, 'balance_get_ajax'])->name('balance.get_ajax');
Route::get('/balance_register_customer_data_get_ajax/{customer_id}', [BalanceRegisterController::class, 'balance_register_customer_data_get_ajax'])->name('balance_register.cargo_handling_get_ajax');
Route::get('/balance_detail/id={balance_id}', [BalanceRegisterController::class, 'detail_index'])->name('balance.detail_index');
Route::get('/balance_delete/{balance_id}', [BalanceRegisterController::class, 'delete'])->name('balance.delete');

Route::get('/balance_list_daily', [BalanceListDailyController::class, 'index'])->name('balance_list_daily.index');
Route::get('/balance_list_daily_detail', [BalanceListDailyController::class, 'detail'])->name('balance_list_daily.detail');


Route::get('/base', [BaseController::class, 'index'])->name('base.index');
Route::get('/monthly_expense_setting/{base_id}', [MonthlyExpenseSettingController::class, 'index'])->name('monthly_expense_setting.index');
Route::post('/monthly_expense_setting_register', [MonthlyExpenseSettingController::class, 'register'])->name('monthly_expense_setting.register');
Route::get('/monthly_expense_setting_delete/{monthly_expense_setting_id}', [MonthlyExpenseSettingController::class, 'delete'])->name('monthly_expense_setting.delete');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer_sort', [CustomerController::class, 'sort'])->name('customer.sort');
Route::post('/customer_register', [CustomerController::class, 'register'])->name('customer.register');
Route::get('/customer_detail/{customer_id}', [CustomerController::class, 'detail'])->name('customer.detail');
Route::post('/customer_setting_update', [CustomerController::class, 'customer_setting_update'])->name('customer_setting.update');

Route::get('/cargo_handling', [CargoHandlingController::class, 'index'])->name('cargo_handling.index');
Route::post('/cargo_handling_register', [CargoHandlingController::class, 'register'])->name('cargo_handling.register');

Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
Route::post('/expense_register', [ExpenseController::class, 'register'])->name('expense.register');

Route::get('/shipping_method', [ShippingMethodController::class, 'index'])->name('shipping_method.index');

Route::get('/labor_cost', [LaborCostController::class, 'index'])->name('labor_cost.index');