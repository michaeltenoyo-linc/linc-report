<?php

use Illuminate\Support\Facades\Route;

//MASTER
use App\Http\Controllers\Master\ViewController as MasterViewController;

//SMART CONTROLLER
use App\Http\Controllers\Smart\ViewController as SmartViewController;
use App\Http\Controllers\Smart\SuratjalanController as SmartSuratjalanController;
use App\Http\Controllers\Smart\TruckController as SmartTruckController;
use App\Http\Controllers\Smart\LoadController as SmartLoadController;
use App\Http\Controllers\Smart\ItemController as SmartItemController;
use App\Http\Controllers\Smart\ReportController as SmartReportController;

//LTL CONTROLLER
use App\Http\Controllers\Ltl\ViewController as LtlViewController;
use App\Http\Controllers\Ltl\SuratjalanController as LtlSuratjalanController;

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

//MASTER
Route::get('/',[MasterViewController::class, 'gotoLandingPage']);

//SMART ROUTES
Route::prefix('/smart')->group(function (){
    //View Navigation
    Route::get('/',[SmartViewController::class, 'gotoLandingPage']);
    Route::get('/nav-items-new',[SmartViewController::class, 'gotoItemNew']);
    Route::get('/nav-items-list',[SmartViewController::class, 'gotoItemList']);
    Route::get('/nav-trucks-new',[SmartViewController::class, 'gotoTrucksNew']);
    Route::get('/nav-trucks-list',[SmartViewController::class, 'gotoTrucksList']);
    Route::get('/nav-so-new',[SmartViewController::class, 'gotoSoNew']);
    Route::get('/nav-so-list',[SmartViewController::class, 'gotoSoList']);
    Route::get('/nav-report-generate',[SmartViewController::class, 'gotoReportGenerate']);

    //View Function
    Route::prefix('/data')->group(function () {
        //Item
        Route::get('/get-items',[SmartViewController::class, 'getItems']);
        Route::post('/get-items-fromid',[SmartViewController::class, 'getItemsFromid']);
        Route::post('/get-items-fromname',[SmartViewController::class, 'getItemsFromName']);
        Route::get('/autocomplete-items',[SmartViewController::class,'search_getItems']);
        //Trucks
        Route::get('/get-trucks',[SmartViewController::class, 'getTrucks']);
        Route::get('/autocomplete-trucks',[SmartViewController::class,'search_getTrucks']);
        //Surat Jalan
        Route::get('/get-sj',[SmartViewController::class, 'getSj']);
    });

    Route::prefix('/suratjalan')->group(function () {
        Route::get('/check/{id_so}',[SmartSuratjalanController::class, 'checkSj']);
        Route::post('/delete',[SmartSuratjalanController::class, 'delete']);
        Route::post('/addSj',[SmartSuratjalanController::class, 'addSj']);
    });

    Route::prefix('/trucks')->group(function () {
        Route::get('/check/{nopol}',[SmartTruckController::class, 'checkTruck']);
        Route::post('/create',[SmartTruckController::class, 'Create']);
        Route::post('/delete',[SmartTruckController::class, 'delete']);
    });

    Route::prefix('/items')->group(function () {
        Route::post('/addItem', [SmartItemController::class, 'addItem']);
        Route::post('/delete',[SmartItemController::class, 'delete']);
        Route::get('/check-existing/{material_code}',[SmartItemController::class, 'checkItemExist']);
    });

    Route::prefix('/load')->group(function () {
        Route::post('/check-bluejay',[SmartLoadController::class, 'checkBluejay']);
        Route::post('/bluejay-table',[SmartLoadController::class, 'bluejayTable']);
    });

    Route::prefix('/report')->group(function () {
        Route::post('/generate',[SmartReportController::class, 'generateReport']);
        Route::get('/get-preview',[SmartReportController::class, 'getPreviewResult']);
        Route::get('/get-warning',[SmartReportController::class, 'getPreviewWarning']);
        Route::get('/downloadReport',[SmartReportController::class, 'downloadExcel']);
    });
});

//LTL
Route::prefix('/lautanluas')->group(function () {
    Route::get('/',[LtlViewController::class, 'gotoLandingPage']);
    Route::get('/nav-so-new',[LtlViewController::class, 'gotoSoNew']);
    Route::get('/nav-so-list',[LtlViewController::class, 'gotoSoList']);

    //View Function
    Route::prefix('/data')->group(function () {
        //Surat Jalan
        Route::get('/get-sj',[LtlViewController::class, 'getSj']);
    });

    //Surat Jalan LTL
    Route::prefix('/suratjalan')->group(function () {
        Route::get('/check/{id_so}',[LtlSuratjalanController::class, 'checkSj']);
        Route::post('/addSj',[LtlSuratjalanController::class, 'addSj']);
    });
});

