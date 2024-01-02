<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a gfroup which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//product
Route::get('/add-product', [ProductController::class, 'index'])->middleware(['auth'])->name('add.product');

Route::post('/insert-product', [ProductController::class, 'store'])->middleware(['auth']);

Route::get('/all-product', [ProductController::class, 'allProduct'])->middleware(['auth'])->name('all.product');

Route::get('/available-products', [ProductController::class, 'availableProducts'])->middleware(['auth'])->name('available.products');

Route::get('/purchase-products/{id}', [ProductController::class, 'purchaseData'])->middleware(['auth']);

Route::post('/insert-purchase-products', [ProductController::class, 'storePurchase'])->middleware(['auth']);

//invoice
Route::get('/add-invoice/{id}', [InvoiceController::class, 'formData'])->middleware(['auth']);

Route::get('/new-invoice', [InvoiceController::class, 'newformData'])->middleware(['auth'])->name('new.invoice');

Route::post('/insert-invoice', [InvoiceController::class, 'store'])->middleware(['auth']);

Route::get('/all-invoice', [InvoiceController::class, 'allInvoices'])->middleware(['auth'])->name('all.invoices');
Route::get('/pay-due/{id}', [InvoiceController::class, 'payDue'])->name('pay.due');
Route::get('/sold-products', [InvoiceController::class, 'soldProducts'])->middleware(['auth'])->name('sold.products');
// Route::get('/delete', [InvoiceController::class,'delete']);

//order
Route::get('/add-order/{name}', [ProductController::class, 'formData'])->middleware(['auth'])->name('add.order');

Route::post('/insert-order', [OrderController::class, 'store'])->middleware(['auth']);

Route::get('/all-orders', [OrderController::class, 'ordersData'])->middleware(['auth'])->name('all.orders');

Route::get('/pending-orders', [OrderController::class, 'pendingOrders'])->middleware(['auth'])->name('pending.orders');

Route::get('/delivered-orders', [OrderController::class, 'deliveredOrders'])->middleware(['auth'])->name('delivered.orders');

Route::get('/new-order', [OrderController::class, 'newformData'])->middleware(['auth'])->name('new.order');

Route::post('/insert-new-order', [OrderController::class, 'newStore'])->middleware(['auth']);

Route::post('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('delete.order');

//customer
Route::get('/add-customer', function () {
    return view('Admin.add_customer');
})->middleware(['auth'])->name('add.customer');
Route::post('/insert-customer', [CustomerController::class, 'store'])->middleware(['auth']);
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::post('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::get('/all-customers', [CustomerController::class, 'customersData'])->middleware(['auth'])->name('all.customers');
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.details');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/category', [CategoryController::class, 'index'])->middleware(['auth'])->name('add.category');
Route::post('/add-category', [CategoryController::class, 'store'])->middleware(['auth']);
Route::post('/update-category/{id}', [CategoryController::class, 'update'])->name('update.category');
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('get.category');

//settings
Route::get('/settings', [UserController::class, 'editSettings'])->name('settings.edit');
Route::post('/settings', [UserController::class, 'updateSettings'])->name('settings.update');
Route::get('/activity-log', [UserController::class, 'showActivityLog'])->name('activity.log');

require __DIR__.'/auth.php';
