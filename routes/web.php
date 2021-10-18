<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\SuratjalanController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;

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

//View Navigation
Route::get('/',[ViewController::class, 'gotoLandingPage']);
Route::get('/nav-items-new',[ViewController::class, 'gotoItemNew']);
Route::get('/nav-items-list',[ViewController::class, 'gotoItemList']);
Route::get('/nav-trucks-new',[ViewController::class, 'gotoTrucksNew']);
Route::get('/nav-trucks-list',[ViewController::class, 'gotoTrucksList']);
Route::get('/nav-so-new',[ViewController::class, 'gotoSoNew']);
Route::get('/nav-so-list',[ViewController::class, 'gotoSoList']);
Route::get('/nav-report-generate',[ViewController::class, 'gotoReportGenerate']);

//View Function
Route::prefix('/data')->group(function () {
    //Item
    Route::get('/get-items',[ViewController::class, 'getItems']);
    Route::post('/get-items-fromid',[ViewController::class, 'getItemsFromid']);
    Route::post('/get-items-fromname',[ViewController::class, 'getItemsFromName']);
    Route::get('/autocomplete-items',[ViewController::class,'search_getItems']);
    //Trucks
    Route::get('/get-trucks',[ViewController::class, 'getTrucks']);
    Route::get('/autocomplete-trucks',[ViewController::class,'search_getTrucks']);
    //Surat Jalan
    Route::get('/get-sj',[ViewController::class, 'getSj']);
});

Route::prefix('/suratjalan')->group(function () {
    Route::get('/check/{id_so}',[SuratjalanController::class, 'checkSj']);
    Route::post('/delete',[SuratjalanController::class, 'delete']);
    Route::post('/addSj',[SuratjalanController::class, 'addSj']);
});

Route::prefix('/trucks')->group(function () {
    Route::get('/check/{nopol}',[TruckController::class, 'checkTruck']);
    Route::post('/delete',[TruckController::class, 'delete']);
});

Route::prefix('/items')->group(function () {
    Route::post('/addItem', [ItemController::class, 'addItem']);
    Route::post('/delete',[ItemController::class, 'delete']);
    Route::get('/check-existing/{material_code}',[ItemController::class, 'checkItemExist']);
});

Route::prefix('/load')->group(function () {
    Route::post('/check-bluejay',[LoadController::class, 'checkBluejay']);
    Route::post('/bluejay-table',[LoadController::class, 'bluejayTable']);
});

Route::prefix('/report')->group(function () {
    Route::post('/generate',[ReportController::class, 'generateReport']);
    Route::get('/get-preview',[ReportController::class, 'getPreviewResult']);
    Route::get('/get-warning',[ReportController::class, 'getPreviewWarning']);
    Route::get('/downloadReport',[ReportController::class, 'downloadExcel']);
});
