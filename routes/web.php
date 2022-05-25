<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

//MASTER
use App\Http\Controllers\Master\ViewController as MasterViewController;
use App\Http\Controllers\Master\UsersController as MasterUsersController;

//SMART CONTROLLER
use App\Http\Controllers\Smart\ViewController as SmartViewController;
use App\Http\Controllers\Smart\SuratjalanController as SmartSuratjalanController;
use App\Http\Controllers\Smart\TruckController as SmartTruckController;
use App\Http\Controllers\Smart\LoadController as SmartLoadController;
use App\Http\Controllers\Smart\ItemController as SmartItemController;
use App\Http\Controllers\Smart\ReportController as SmartReportController;

//LTL CONTROLLER
use App\Http\Controllers\Ltl\ViewController as LtlViewController;
use App\Http\Controllers\Ltl\ReportController as LtlReportController;
use App\Http\Controllers\Ltl\LoadController as LtlLoadController;
use App\Http\Controllers\Ltl\SuratjalanController as LtlSuratjalanController;

//GREENFIELDS CONTROLLER
use App\Http\Controllers\Greenfields\ViewController as GreenfieldsViewController;
use App\Http\Controllers\Greenfields\SuratjalanController as GreenfieldsSuratjalanController;
use App\Http\Controllers\Greenfields\LoadController as GreenfieldsLoadController;
use App\Http\Controllers\Greenfields\ReportController as GreenfieldsReportController;

//LOA CONTROLLEr
use App\Http\Controllers\Loa\ViewController as LoaViewController;
use App\Http\Controllers\Loa\WarehouseController as LoaWarehouseController;
use App\Http\Controllers\Loa\TransportController as LoaTransportController;

//SALES CONTROLLER
use App\Http\Controllers\Sales\ViewController as SalesViewController;
use App\Http\Controllers\Sales\TruckController as SalesTruckController;
use App\Http\Controllers\SharedController;

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
/*
Route::middleware(['auth','priviledge:ltl,master'])->group(function(){

});
*/
//MASTER
Route::get('/',[MasterViewController::class, 'gotoLandingPage']);
Route::prefix('/user')->group(function (){
    //Auth
    Route::post('/authenticate', [MasterUsersController::class, 'onLogin']);
    Route::post('/logout', [MasterUsersController::class, 'onLogout']);
    Route::get('/notAuthorized', [MasterViewController::class, 'notAuthorized']);
    Route::get('/notPriviledges', [MasterViewController::class, 'notPriviledges']);
});

//SMART ROUTES
Route::middleware(['auth','priviledge:smart,master'])->group(function () {
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
            Route::get('/get-sj-byid/{id}',[SmartViewController::class, 'getSjById']);
        });

        Route::prefix('/suratjalan')->group(function () {
            Route::get('/check/{id_so}',[SmartSuratjalanController::class, 'checkSj']);
            Route::get('/autofill-load/{load_id}',[SmartSuratjalanController::class, 'autofillSj']);
            Route::post('/delete',[SmartSuratjalanController::class, 'delete']);
            Route::post('/addSj',[SmartSuratjalanController::class, 'addSj']);
            Route::post('/update',[SmartSuratjalanController::class, 'update']);
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
});

//LTL
Route::middleware(['auth','priviledge:ltl,master'])->group(function () {
    Route::prefix('/lautanluas')->group(function () {
        Route::get('/',[LtlViewController::class, 'gotoLandingPage']);
        Route::get('/nav-so-new',[LtlViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list',[LtlViewController::class, 'gotoSoList']);
        Route::get('/nav-report-generate',[LtlViewController::class, 'gotoReportGenerate']);

        //View Function
        Route::prefix('/data')->group(function () {
            //Surat Jalan
            Route::get('/get-sj',[LtlViewController::class, 'getSj']);
            Route::get('/get-sj-byid/{id_so}',[LtlViewController::class, 'getSjById']);
        });

        //Surat Jalan LTL
        Route::prefix('/suratjalan')->group(function () {
            Route::get('/check/{id_so}/{no_do}',[LtlSuratjalanController::class, 'checkSj']);
            Route::post('/delete',[LtlSuratjalanController::class, 'delete']);
            Route::post('/update',[LtlSuratjalanController::class, 'update']);
            Route::post('/addSj',[LtlSuratjalanController::class, 'addSj']);
        });

        Route::prefix('/load')->group(function () {
            Route::post('/check-bluejay',[LtlLoadController::class, 'checkBluejay']);
            Route::post('/bluejay-table',[LtlLoadController::class, 'bluejayTable']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate',[LtlReportController::class, 'generateReport']);
            Route::get('/get-preview',[LtlReportController::class, 'getPreviewResult']);
            Route::get('/get-warning',[LtlReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport',[LtlReportController::class, 'downloadExcel']);
        });
    });
});

//Greenfields
Route::middleware(['auth','priviledge:gfs,master'])->group(function () {
    //GREENFIELDS
    Route::prefix('/greenfields')->group(function () {
        Route::get('/',[GreenfieldsViewController::class, 'gotoLandingPage']);
        Route::get('/nav-so-new',[GreenfieldsViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list',[GreenfieldsViewController::class, 'gotoSoList']);
        Route::get('/nav-report-generate',[GreenfieldsViewController::class, 'gotoReportGenerate']);

        //View Function
        Route::prefix('/data')->group(function () {
            //Surat Jalan
            Route::get('/get-sj',[GreenfieldsViewController::class, 'getSj']);
        });

        //Surat Jalan
        Route::prefix('/suratjalan')->group(function (){
            Route::get('/check/{id1}/{id2}',[GreenfieldsSuratjalanController::class, 'checkSj']);
            Route::post('/delete',[GreenfieldsSuratjalanController::class, 'delete']);
            Route::post('/addSj',[GreenfieldsSuratjalanController::class, 'addSj']);
        });

        //Reporting
        Route::prefix('/load')->group(function () {
            Route::post('/check-bluejay',[GreenfieldsLoadController::class, 'checkBluejay']);
            Route::post('/bluejay-table',[GreenfieldsLoadController::class, 'bluejayTable']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate',[GreenfieldsReportController::class, 'generateReport']);
            Route::get('/get-preview',[GreenfieldsReportController::class, 'getPreviewResult']);
            Route::get('/get-warning',[GreenfieldsReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport',[GreenfieldsReportController::class, 'downloadExcel']);
        });
    });
});

//LOA
Route::middleware(['auth','priviledge:loa,master'])->group(function () {
    //LOA
    Route::prefix('/loa')->group(function (){
        //View Navigation
        Route::get('/',[LoaViewController::class, 'gotoLandingPage']);
        Route::get('/nav-loa-new',[LoaViewController::class, 'gotoInputLoa']);
        Route::get('/nav-loa-list', [LoaViewController::class, 'gotoListLoa']);
        Route::get('/nav-search-transport',[LoaViewController::class, 'gotoSearchTransport']);
        Route::get('/nav-blujay-compare', [LoaViewController::class, 'gotoCrossCompare']);

        Route::prefix('/action/blujay')->group(function(){
            //Action
            Route::post('/compare', [LoaTransportController::class, 'crossCompareLoa']);
        });

        Route::prefix('/action/warehouse')->group(function (){
            //CRUD
            Route::get('/nav-insert',[LoaViewController::class, 'gotoInputWarehouse']);
            Route::post('/insert',[LoaWarehouseController::class, 'insert']);
            Route::get('/list',[LoaViewController::class, 'gotoListWarehouse']);
            Route::get('/read',[LoaViewController::class, 'getWarehouseData']);
            Route::get('/detail/{id}',[LoaWarehouseController::class, 'gotoDetailWarehouse']);

            //Action
            Route::post('/prolong-period',[LoaWarehouseController::class, 'prolongPeriod']);
        });

        Route::prefix('/action/transport')->group(function (){
            //CRUD
            Route::get('/nav-insert',[LoaViewController::class, 'gotoInputTransport']);
            Route::post('/insert',[LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}',[LoaTransportController::class, 'getRoutes']);
            Route::get('/list',[LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes',[LoaTransportController::class, 'searchTransport']);
            Route::post('/search-billable',[LoaTransportController::class, 'searchBillableBlujay']);
            Route::get('/read',[LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}',[LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
            Route::get('/dloa-local/{id}', [LoaTransportController::class, 'getDetailLoaLocal']);
            Route::get('/local-info/{customer}/{route_start}/{route_end}', [LoaViewController::class, 'getLocalData']);
        });

        Route::prefix('/action/exim')->group(function (){
            //CRUD
            Route::get('/nav-insert',[LoaViewController::class, 'gotoInputExim']);
            Route::post('/insert',[LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}',[LoaTransportController::class, 'getRoutes']);
            Route::get('/list',[LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes',[LoaTransportController::class, 'searchTransport']);
            Route::get('/read',[LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}',[LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
        });

        Route::prefix('/action/bulk')->group(function (){
            //CRUD
            Route::get('/nav-insert',[LoaViewController::class, 'gotoInputTransport']);
            Route::post('/insert',[LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}',[LoaTransportController::class, 'getRoutes']);
            Route::get('/list',[LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes',[LoaTransportController::class, 'searchTransport']);
            Route::get('/read',[LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}',[LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
        });
    });

    //GET LOA FILES
    Route::get('/show-pdf/{filename}/{content_path}', function($filename, $content_path){
        return response()->file(storage_path("app/".$content_path."/".$filename));
    })->name('show-pdf');

    Route::get('/show-png/{filename}/{content_path}', function($filename, $content_path){
        $path = storage_path("app/".$content_path."/".$filename);

        if(!File::exists($path)){
            return response()->json(["message" => "image not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-png');

    Route::get('/show-xlxs/{filename}/{content_path}', function($filename, $content_path){
        $path = storage_path("app/".$content_path."/".$filename);

        if(!File::exists($path)){
            return response()->json(["message" => "file not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-xlxs');
});

//SALES
Route::middleware(['auth','priviledge:sales,master'])->group(function () {
    Route::prefix('/sales')->group(function (){
        //View Navigation
        Route::get('/',[SalesViewController::class, 'gotoLandingPage']);
        Route::get('/monitoring-master',[SalesViewController::class, 'gotoMonitoringMaster']);
        Route::get('/by-sales/{name}',[SalesViewController::class, 'gotoBySales']);
        Route::get('/by-division/{division}',[SalesViewController::class, 'gotoByDivision']);
        Route::get('/export/pdf',[SalesViewController::class, 'gotoExportPdf']);
        
        //Utility
        Route::get('/filter-date/{month}/{year}', [SalesViewController::class, 'filterSalesDate']);

        //Export
        Route::get('/export/filter-customer/{division}/{sales}',[SalesViewController::class, 'getFilteringCustomer']);
        Route::get('/export/generate-report/{division}/{sales}/{customer}/{isDatatable}',[SalesViewController::class, 'generateSalesReport']);

        Route::prefix('/data')->group(function () {
            //DATA VIEW
            Route::get('/get-budget-actual',[SalesViewController::class, 'getBudgetActual']);
            Route::get('/get-sales-performance/{sales}',[SalesViewController::class, 'getSalesPerformance']);
            Route::get('/get-sales-overview/{sales}', [SalesViewController::class, 'getSalesOverview']);
            Route::get('/get-division-performance/{division}',[SalesViewController::class, 'getDivisionPerformance']);
            Route::get('/get-division-overview/{division}', [SalesViewController::class, 'getDivisionOverview']);
            Route::get('/get-yearly-achievement/{id}',[SalesViewController::class, 'getYearlyAchievement']);
            Route::get('/get-yearly-revenue',[SalesViewController::class, 'getYearlyRevenue']);
            Route::get('/get-monthly-achievement',[SalesViewController::class, 'getMonthlyAchievement']);
            Route::get('/get-sales-pie/{sales}',[SalesViewController::class, 'getSalesPie']);
            Route::get('/get-division-pie/{division}',[SalesViewController::class, 'getDivisionPie']);
            Route::get('/get-division-pie',[SalesViewController::class, 'getAllDivisionPie']);
        });
        
        Route::prefix('/truck')->group(function () {
            //View and Generate
            Route::get('/performance',[SalesViewController::class, 'gotoTruckingPerformance']);
            Route::get('/performance-generate/{ownership}/{division}/{nopol}',[SalesTruckController::class, 'generateTruckingPerformance']);
            Route::get('/performance-customer/{ownership}/{division}/{nopol}',[SalesTruckController::class, 'generateCustomerPerformance']);
            Route::get('/utility',[SalesViewController::class, 'gotoTruckingUtility']);
            
            //Data
            Route::get('/filter-nopol/{division}/{ownership}',[SalesTruckController::class, 'getFilteringTruck']);
            Route::get('/filter-customer/{division}/{ownership}/{nopol}',[SalesTruckController::class, 'getFilteringCustomer']);
            Route::get('get-monthly-customers/{nopol}/{division}',[SalesTruckController::class, 'getCustomerData']);
        });

        //LOAD ID DETAIL INVOICE
        Route::get('/load-detail/{load_id}',[SalesViewController::class, 'showLoadDetail']);
    });
});


//LOA FILE MANAGEMENT
Route::middleware(['auth','priviledge:loa,master'])->group(function () {
    //GET LOA FILES
    Route::get('/show-pdf/{filename}/{content_path}', function($filename, $content_path){
        return response()->file(storage_path("app/".$content_path."/".$filename));
    })->name('show-pdf');

    Route::get('/show-png/{filename}/{content_path}', function($filename, $content_path){
        $path = storage_path("app/".$content_path."/".$filename);

        if(!File::exists($path)){
            return response()->json(["message" => "image not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-png');

    Route::get('/show-xlxs/{filename}/{content_path}', function($filename, $content_path){
        $path = storage_path("app/".$content_path."/".$filename);

        if(!File::exists($path)){
            return response()->json(["message" => "file not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-xlxs');
});

//DEPENDENT INDONESIA DROPDOWN
Route::get('/provinces/{id}', 'IndonesiaDropdownController@provinces')->name('provinces');
Route::get('/cities/{id}', 'IndonesiaDropdownController@cities')->name('cities');
Route::get('/districts/{id}', 'IndonesiaDropdownController@districts')->name('districts');
Route::get('/villages/{id}', 'IndonesiaDropdownController@villages')->name('villages');

//SHARED API and RANDOM PERSONAL QUEST
Route::get('/lincrest/statistic/routes/{filterDate}',[SharedController::class, 'generateRoutesReport']);
Route::get('/lincrest/statistic/billableBlujay',[SharedController::class, 'generateBillableBlujayReport']);