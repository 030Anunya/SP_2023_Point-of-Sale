<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\DepartMentController;
use App\Http\Controllers\HistorySaleController;
use App\Http\Controllers\HomeReportController;
use App\Http\Controllers\inventoryController;
use App\Http\Controllers\listsaleController;
use App\Http\Controllers\MyPdfController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\MyShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\subcategoryController;
use App\Http\Controllers\UpdateStockController;
use App\Http\Controllers\UserController;
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



Route::middleware(['auth'])->group(function () {
    Route::resource('/users', UserController::class)->middleware('admin');
    Route::post('/users/status/{id}', [UserController::class,'updatestatus'])->middleware('admin');
    Route::resource('/products', ProductController::class);
    Route::resource('/categorys', categoryController::class);
    Route::resource('/subcategory', subcategoryController::class);
    Route::resource('/listsale', listsaleController::class);
    Route::resource('/inventory', inventoryController::class);
    Route::post('/updateStock', [UpdateStockController::class, 'updateStock']);
    Route::get('/', [HomeReportController::class, 'index'])->name('home');
    Route::resource('/myprofile', MyProfileController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/generate-pdffull/{id}', [MyPdfController::class, 'generatePDFfull']);
    Route::get('/generate-pdfmini/{id}', [MyPdfController::class, 'generatePDFmini']);
    Route::get('/generate-pdfProduct', [MyPdfController::class, 'generatePDFproduct']);
    Route::resource('/department', DepartMentController::class);
    Route::post('/update_stock', [UpdateStockController::class, 'updateStock']);
    Route::post('/searchProduct', [ProductController::class, 'searchProduct']);
    Route::get('/barcodeProduct/{id}', [ProductController::class, 'generateQRCode']);
    Route::resource('/department', DepartMentController::class);
    Route::post('/products/import', [ProductController::class, 'importProduct']);
    Route::post('/products/status/{id}', [ProductController::class, 'togglestatus']);

    Route::get('/historysale', [HistorySaleController::class, 'showHistorySale'])->middleware('admin');
    Route::get('/historysale/detail/{id}', [HistorySaleController::class, 'detailHistory'])->name('detial_history');
    Route::get('/historySaleMonth', [HistorySaleController::class, 'showHistoryMonth'])->middleware('admin');
    Route::get('/historySaleMonth/{id}', [HistorySaleController::class, 'showHistoryMonth'])->middleware('admin');
    Route::get('/historyProduct', [HistorySaleController::class, 'showHistoryProduct'])->middleware('admin');
    Route::get('/historySaleYear', [HistorySaleController::class, 'showHistorySaleYear'])->middleware('admin');
    Route::get('/myshop', [MyShopController::class,'index'])->middleware('admin');
    Route::resource('feature',SkuController::class);
    Route::post('/myshop/update', [MyShopController::class,'update'])->middleware('admin');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'loginpost']);
