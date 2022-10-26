<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

//PKG CONTROLLER
use App\Http\Controllers\Pkg\ViewController as PkgViewController;
use App\Http\Controllers\Pkg\TicketController as PkgTicketController;
use App\Http\Controllers\Pkg\ReportController as PkgReportController;

//GREENFIELDS CONTROLLER
use App\Http\Controllers\Greenfields\ViewController as GreenfieldsViewController;
use App\Http\Controllers\Greenfields\SuratjalanController as GreenfieldsSuratjalanController;
use App\Http\Controllers\Greenfields\LoadController as GreenfieldsLoadController;
use App\Http\Controllers\Greenfields\ReportController as GreenfieldsReportController;

//LOA CONTROLLER LAMA OLD
use App\Http\Controllers\LoaOld\ViewController as LoaOldViewController;
use App\Http\Controllers\LoaOld\WarehouseController as LoaOldWarehouseController;
use App\Http\Controllers\LoaOld\TransportController as LoaOldTransportController;

//LOA
use App\Http\Controllers\Loa\ViewController as LoaViewController;
use App\Http\Controllers\Loa\DataController as LoaDataController;

//SALES CONTROLLER
use App\Http\Controllers\Sales\ViewController as SalesViewController;
use App\Http\Controllers\Sales\TruckController as SalesTruckController;
use App\Http\Controllers\SharedController;
use App\Models\LoaFile;

//THIRD PARTY CONTROLLER
use App\Http\Controllers\ThirdParty\ViewController as ThirdPartyViewController;
use App\Http\Controllers\ThirdParty\BlujayController as ThirdPartyBlujayController;
use Google\Service\DisplayVideo\ThirdPartyUrl;
//MESSAGE
use Hfig\MAPI;
use Hfig\MAPI\OLE\Pear;

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
Route::get('/', [MasterViewController::class, 'gotoLandingPage']);
Route::prefix('/user')->group(function () {
    //Auth
    Route::post('/authenticate', [MasterUsersController::class, 'onLogin']);
    Route::post('/logout', [MasterUsersController::class, 'onLogout']);
    Route::get('/notAuthorized', [MasterViewController::class, 'notAuthorized']);
    Route::get('/notPriviledges', [MasterViewController::class, 'notPriviledges']);
    Route::get('/underMaintenance', [MasterViewController::class, 'underMaintenance']);
    Route::get('/back', [MasterViewController::class, 'back']);
});

//SMART ROUTES
Route::middleware(['auth', 'priviledge:smart,master'])->group(function () {
    Route::prefix('/smart')->group(function () {
        //View Navigation
        Route::get('/', [SmartViewController::class, 'gotoLandingPage']);
        Route::get('/nav-items-new', [SmartViewController::class, 'gotoItemNew']);
        Route::get('/nav-items-list', [SmartViewController::class, 'gotoItemList']);
        Route::get('/nav-trucks-new', [SmartViewController::class, 'gotoTrucksNew']);
        Route::get('/nav-trucks-list', [SmartViewController::class, 'gotoTrucksList']);
        Route::get('/nav-so-new', [SmartViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list', [SmartViewController::class, 'gotoSoList']);
        Route::get('/nav-so-detail/{id_so}', [SmartViewController::class, 'gotoSoDetail']);
        Route::get('/nav-report-generate', [SmartViewController::class, 'gotoReportGenerate']);

        //View Function
        Route::prefix('/data')->group(function () {
            //Item
            Route::get('/get-items', [SmartViewController::class, 'getItems']);
            Route::get('/get-items-json', [SmartViewController::class, 'getItemsJson']);
            Route::post('/get-items-fromid', [SmartViewController::class, 'getItemsFromid']);
            Route::get('/get-items-fromid/{code}', [SmartViewController::class, 'getItemsFromidGET']);
            Route::post('/get-items-fromname', [SmartViewController::class, 'getItemsFromName']);
            Route::get('/autocomplete-items', [SmartViewController::class, 'search_getItems']);
            //Trucks
            Route::get('/get-trucks', [SmartViewController::class, 'getTrucks']);
            Route::get('/autocomplete-trucks', [SmartViewController::class, 'search_getTrucks']);
            //Surat Jalan
            Route::get('/get-sj', [SmartViewController::class, 'getSj']);
            Route::get('/get-sj-byid/{id}', [SmartViewController::class, 'getSjById']);
        });

        Route::prefix('/suratjalan')->group(function () {
            Route::get('/check/{id_so}', [SmartSuratjalanController::class, 'checkSj']);
            Route::get('/autofill-load/{load_id}', [SmartSuratjalanController::class, 'autofillSj']);
            Route::post('/delete', [SmartSuratjalanController::class, 'delete']);
            Route::post('/addSj', [SmartSuratjalanController::class, 'addSj']);
            Route::post('/update', [SmartSuratjalanController::class, 'update']);
        });

        Route::prefix('/trucks')->group(function () {
            Route::get('/check/{nopol}', [SmartTruckController::class, 'checkTruck']);
            Route::post('/create', [SmartTruckController::class, 'Create']);
            Route::post('/delete', [SmartTruckController::class, 'delete']);
        });

        Route::prefix('/items')->group(function () {
            Route::post('/addItem', [SmartItemController::class, 'addItem']);
            Route::post('/delete', [SmartItemController::class, 'delete']);
            Route::get('/check-existing/{material_code}', [SmartItemController::class, 'checkItemExist']);
            Route::post('/update', [SmartItemController::class, 'update']);
        });

        Route::prefix('/load')->group(function () {
            Route::post('/check-bluejay', [SmartLoadController::class, 'checkBluejay']);
            Route::post('/bluejay-table', [SmartLoadController::class, 'bluejayTable']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate', [SmartReportController::class, 'generateReport']);
            Route::get('/get-preview', [SmartReportController::class, 'getPreviewResult']);
            Route::get('/get-warning', [SmartReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport', [SmartReportController::class, 'downloadExcel']);
        });
    });
});

//LTL
Route::middleware(['auth', 'priviledge:ltl,master'])->group(function () {
    Route::prefix('/lautanluas')->group(function () {
        Route::get('/', [LtlViewController::class, 'gotoLandingPage']);
        Route::get('/nav-so-new', [LtlViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list', [LtlViewController::class, 'gotoSoList']);
        Route::get('/nav-report-generate', [LtlViewController::class, 'gotoReportGenerate']);

        //View Function
        Route::prefix('/data')->group(function () {
            //Surat Jalan
            Route::get('/get-sj', [LtlViewController::class, 'getSj']);
            Route::get('/get-sj-byid/{id_so}', [LtlViewController::class, 'getSjById']);
        });

        //Surat Jalan LTL
        Route::prefix('/suratjalan')->group(function () {
            Route::get('/check/{id_so}/{no_do}', [LtlSuratjalanController::class, 'checkSj']);
            Route::post('/delete', [LtlSuratjalanController::class, 'delete']);
            Route::post('/update', [LtlSuratjalanController::class, 'update']);
            Route::post('/addSj', [LtlSuratjalanController::class, 'addSj']);
        });

        Route::prefix('/load')->group(function () {
            Route::post('/check-bluejay', [LtlLoadController::class, 'checkBluejay']);
            Route::post('/bluejay-table', [LtlLoadController::class, 'bluejayTable']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate', [LtlReportController::class, 'generateReport']);
            Route::get('/get-preview', [LtlReportController::class, 'getPreviewResult']);
            Route::get('/get-warning', [LtlReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport', [LtlReportController::class, 'downloadExcel']);
        });
    });
});

//PKG
Route::middleware(['auth', 'priviledge:pkg,master'])->group(function () {
    Route::prefix('/pkg')->group(function () {
        Route::get('/', [PkgViewController::class, 'gotoLandingPage']);
        Route::get('/nav-so-new', [PkgViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list', [PkgViewController::class, 'gotoSoList']);
        Route::get('/nav-report-generate', [PkgViewController::class, 'gotoGenerateReport']);

        //Ticket
        Route::prefix('/ticket')->group(function () {
            Route::get('/read', [PkgTicketController::class, 'getTicket']);
            Route::get('/read/{posto}', [PkgTicketController::class, 'getDetail']);
            Route::get('/read-loads/{posto}', [PkgTicketController::class, 'getLoads']);
            Route::post('/delete', [PkgTicketController::class, 'delete']);
            Route::post('/delete-load', [PkgTicketController::class, 'deleteLoad']);
            Route::post('/delete-booking-note', [PkgTicketController::class, 'deleteBookingNote']);
            Route::get('/check/{posto}', [PkgTicketController::class, 'checkPosto']);
            Route::get('/check-load/{load}', [PkgTicketController::class, 'checkLoad']);
            Route::post('/addPosto', [PkgTicketController::class, 'addPosto']);
            Route::post('/addLoads', [PkgTicketController::class, 'addLoads']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate', [PkgReportController::class, 'generateReport']);
            Route::get('/get-preview', [PkgReportController::class, 'getPreviewResult']);
            Route::get('/get-warning', [PkgReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport', [PkgReportController::class, 'downloadExcel']);
        });
    });
});

//Greenfields
Route::middleware(['auth', 'priviledge:gfs,master'])->group(function () {
    //GREENFIELDS
    Route::prefix('/greenfields')->group(function () {
        Route::get('/', [GreenfieldsViewController::class, 'gotoLandingPage']);
        Route::get('/nav-so-new', [GreenfieldsViewController::class, 'gotoSoNew']);
        Route::get('/nav-so-list', [GreenfieldsViewController::class, 'gotoSoList']);
        Route::get('/nav-report-generate', [GreenfieldsViewController::class, 'gotoReportGenerate']);

        //View Function
        Route::prefix('/data')->group(function () {
            //Surat Jalan
            Route::get('/get-sj', [GreenfieldsViewController::class, 'getSj']);
        });

        //Surat Jalan
        Route::prefix('/suratjalan')->group(function () {
            Route::get('/check/{id1}/{id2}', [GreenfieldsSuratjalanController::class, 'checkSj']);
            Route::post('/delete', [GreenfieldsSuratjalanController::class, 'delete']);
            Route::post('/addSj', [GreenfieldsSuratjalanController::class, 'addSj']);
        });

        //Reporting
        Route::prefix('/load')->group(function () {
            Route::post('/check-bluejay', [GreenfieldsLoadController::class, 'checkBluejay']);
            Route::post('/bluejay-table', [GreenfieldsLoadController::class, 'bluejayTable']);
        });

        Route::prefix('/report')->group(function () {
            Route::post('/generate', [GreenfieldsReportController::class, 'generateReport']);
            Route::get('/get-preview', [GreenfieldsReportController::class, 'getPreviewResult']);
            Route::get('/get-warning', [GreenfieldsReportController::class, 'getPreviewWarning']);
            Route::get('/downloadReport', [GreenfieldsReportController::class, 'downloadExcel']);
        });
    });
});

//THIRD PARTY ACCESS
Route::middleware(['auth', 'priviledge:master'])->group(function () {
    Route::prefix('/third-party')->group(function () {
        //View Navigation
        Route::get('/', [ThirdPartyViewController::class, 'gotoLandingPage']);

        Route::prefix('/blujay')->group(function () {
            Route::get('/', [ThirdPartyViewController::class, 'gotoBlujayMaster']);
            Route::get('/refresh', [ThirdPartyViewController::class, 'gotoBlujayRefresh']);
            Route::post('/injectSql', [ThirdPartyBlujayController::class, 'injectSql']);
            Route::get('/streamSqlProgress', [ThirdPartyBlujayController::class, 'streamSqlProgress']);
        });
    });
});

//LOA NEW REVISION
Route::middleware(['auth', 'priviledge:loa,loa_view,master'])->group(function () {
    Route::prefix('/loa')->group(function () {
        //View Navigation
        Route::get('/', [LoaViewController::class, 'gotoLandingPage']);

        Route::middleware(['auth', 'priviledge:loa,master'])->group(function () {
            Route::get('/nav-loa-new', [LoaViewController::class, 'gotoInputType']);
            Route::get('/nav-loa-new/{type}', [LoaViewController::class, 'gotoInputForm']);
        });

        Route::get('/nav-loa-list', [LoaViewController::class, 'gotoListType']);
        Route::get('/nav-loa-list/{type}', [LoaViewController::class, 'gotoListMaster']);

        //Data CRUD
        Route::prefix('/data')->group(function () {
            Route::post('/insert', [LoaDataController::class, 'insert']);
            Route::post('/insertFile', [LoaDataController::class, 'insertFile']);
            Route::get('/read/{type}', [LoaDataController::class, 'read']);
            Route::get('/activationById/{id}', [LoaDataController::class, 'activationById']);
            Route::get('/pinById/{id}', [LoaDataController::class, 'pinById']);
            Route::post('/editDetailByLoa/{id}', [LoaDataController::class, 'editDetailByLoa']);
            Route::post('/deleteDetailByLoa/{id}', [LoaDataController::class, 'deleteDetailByLoa']);
            Route::post('/insertDetailByLoa/{id}', [LoaDataController::class, 'insertDetailByLoa']);
            Route::get('/deleteById/{id}', [LoaDataController::class, 'deleteById']);
            Route::get('/deleteFileById/{id}', [LoaDataController::class, 'deleteFileById']);
            Route::get('/read/byCustomer/{type}/{reference}', [LoaDataController::class, 'readByCustomer']);
            Route::get('/read/byId/{id}', [LoaDataController::class, 'readById']);
            Route::get('/getGroupByCustomer/{type}/{reference}', [LoaDataController::class, 'getGroupByCustomer']);
            Route::get('/getTimelineByGroup/{type}/{reference}/{group}', [LoaDataController::class, 'getTimelineByGroup']);
            Route::get('/getFileByGroup/{groupId}', [LoaDataController::class, 'getFileByGroup']);
            Route::get('/getFileById/{id}', [LoaDataController::class, 'getFileById']);
            Route::get('/getRatesByLoa/{id}/{type}', [LoaDataController::class, 'getRatesByLoa']);
            Route::get('/getPinnedGroup/{type}/{customer}', [LoaDataController::class, 'getPinnedLoa']);
        });
    });
});

//LOA OLD VERSION
Route::middleware(['auth', 'priviledge:loa,master'])->group(function () {
    //LOA
    Route::prefix('/loa-old')->group(function () {
        //View Navigation
        Route::get('/', [LoaViewController::class, 'gotoLandingPage']);
        Route::get('/nav-loa-new', [LoaViewController::class, 'gotoInputLoa']);
        Route::get('/nav-loa-list', [LoaViewController::class, 'gotoListLoa']);
        Route::get('/nav-search-transport', [LoaViewController::class, 'gotoSearchTransport']);
        Route::get('/nav-blujay-compare', [LoaViewController::class, 'gotoCrossCompare']);

        Route::prefix('/action/blujay')->group(function () {
            //Action
            Route::post('/compare', [LoaTransportController::class, 'crossCompareLoa']);
        });

        Route::prefix('/action/warehouse')->group(function () {
            //CRUD
            Route::get('/nav-insert', [LoaViewController::class, 'gotoInputWarehouse']);
            Route::post('/insert', [LoaWarehouseController::class, 'insert']);
            Route::get('/list', [LoaViewController::class, 'gotoListWarehouse']);
            Route::get('/read', [LoaViewController::class, 'getWarehouseData']);
            Route::get('/detail/{id}', [LoaWarehouseController::class, 'gotoDetailWarehouse']);

            //Action
            Route::post('/prolong-period', [LoaWarehouseController::class, 'prolongPeriod']);
        });

        Route::prefix('/action/transport')->group(function () {
            //CRUD
            Route::get('/nav-insert', [LoaViewController::class, 'gotoInputTransport']);
            Route::post('/insert', [LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}', [LoaTransportController::class, 'getRoutes']);
            Route::get('/list', [LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes', [LoaTransportController::class, 'searchTransport']);
            Route::post('/search-billable', [LoaTransportController::class, 'searchBillableBlujay']);
            Route::get('/read', [LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}', [LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
            Route::get('/dloa-local/{id}', [LoaTransportController::class, 'getDetailLoaLocal']);
            Route::get('/local-info/{customer}/{route_start}/{route_end}', [LoaViewController::class, 'getLocalData']);
        });

        Route::prefix('/action/exim')->group(function () {
            //CRUD
            Route::get('/nav-insert', [LoaViewController::class, 'gotoInputExim']);
            Route::post('/insert', [LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}', [LoaTransportController::class, 'getRoutes']);
            Route::get('/list', [LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes', [LoaTransportController::class, 'searchTransport']);
            Route::get('/read', [LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}', [LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
        });

        Route::prefix('/action/bulk')->group(function () {
            //CRUD
            Route::get('/nav-insert', [LoaViewController::class, 'gotoInputTransport']);
            Route::post('/insert', [LoaTransportController::class, 'insert']);
            Route::get('/get-routes/{id}', [LoaTransportController::class, 'getRoutes']);
            Route::get('/list', [LoaViewController::class, 'gotoListTransport']);
            Route::post('/search-routes', [LoaTransportController::class, 'searchTransport']);
            Route::get('/read', [LoaViewController::class, 'getTransportData']);
            Route::get('/detail/{id}', [LoaTransportController::class, 'gotoDetailTransport']);
            Route::get('/dloa/{id}', [LoaTransportController::class, 'getDetailLoa']);
        });
    });

    //GET LOA FILES
    Route::get('/show-pdf/{filename}/{content_path}', function ($filename, $content_path) {
        return response()->file(storage_path("app/" . $content_path . "/" . $filename));
    })->name('show-pdf');

    Route::get('/show-png/{filename}/{content_path}', function ($filename, $content_path) {
        $path = storage_path("app/" . $content_path . "/" . $filename);

        if (!File::exists($path)) {
            return response()->json(["message" => "image not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-png');

    Route::get('/show-xlxs/{filename}/{content_path}', function ($filename, $content_path) {
        $path = storage_path("app/" . $content_path . "/" . $filename);

        if (!File::exists($path)) {
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
Route::middleware(['auth', 'priviledge:sales,master,statistic'])->group(function () {
    Route::prefix('/sales')->group(function () {
        //View Navigation
        Route::get('/', [SalesViewController::class, 'gotoLandingPage']);
        Route::get('/monitoring-master', [SalesViewController::class, 'gotoMonitoringMaster']);
        //Route::get('/by-sales/{name}',[SalesViewController::class, 'gotoBySales']); MAINTENANCE
        Route::get('/by-sales/{name}', [MasterViewController::class, 'underMaintenance']);
        //Route::get('/by-division/{division}',[SalesViewController::class, 'gotoByDivision']); MAINTENANCE
        Route::get('/by-division/{division}', [MasterViewController::class, 'underMaintenance']);
        Route::get('/export/pdf', [SalesViewController::class, 'gotoExportPdf']);
        Route::get('/export/forecast', [SalesViewController::class, 'gotoExportForecast']);

        //Utility
        Route::get('/filter-date/{month}/{year}', [SalesViewController::class, 'filterSalesDate']);
        Route::get('/filter-date-landing/{month}/{year}', [SalesViewController::class, 'filterSalesDateLanding']);
        Route::get('/filter-date-between/{fromDate}/{fromMonth}/{fromYear}/{toDate}/{toMonth}/{toYear}', [SalesViewController::class, 'filterSalesDateBetween']);
        Route::get('/filter-start-date/{month}/{year}', [SalesViewController::class, 'filterStartDate']);
        Route::get('/filter-end-date/{month}/{year}', [SalesViewController::class, 'filterEndDate']);

        //Export
        Route::get('/export/filter-customer/{division}/{sales}', [SalesViewController::class, 'getFilteringCustomer']);
        Route::get('/export/generate-report/{constraint}/{status}/{division}/{sales}/{customer}/{isDatatable}', [SalesViewController::class, 'generateSalesReport']);
        Route::get('/export/download-forecast/{constraint}/{status}/{division}/{sales}/{customer}/{isDatatable}', [SalesViewController::class, 'downloadForecastReport']);

        Route::prefix('/data')->group(function () {
            //DATA VIEW
            Route::get('/get-budget-actual', [SalesViewController::class, 'getBudgetActual']);
            Route::get('/get-sales-performance/{sales}', [SalesViewController::class, 'getSalesPerformance']);
            Route::get('/get-sales-overview/{sales}', [SalesViewController::class, 'getSalesOverview']);
            Route::get('/get-division-performance/{division}', [SalesViewController::class, 'getDivisionPerformance']);
            Route::get('/get-division-overview/{division}', [SalesViewController::class, 'getDivisionOverview']);
            Route::get('/get-yearly-achievement/{id}', [SalesViewController::class, 'getYearlyAchievement']);
            Route::get('/get-yearly-revenue/{division}', [SalesViewController::class, 'getYearlyRevenue']);
            Route::get('/get-yearly-detail/{division}', [SalesViewController::class, 'getYearlyDetail']);
            Route::get('/get-monthly-achievement', [SalesViewController::class, 'getMonthlyAchievement']);
            Route::get('/get-sales-pie/{sales}', [SalesViewController::class, 'getSalesPie']);
            Route::get('/get-division-pie/{division}', [SalesViewController::class, 'getDivisionPie']);
            Route::get('/get-division-pie', [SalesViewController::class, 'getAllDivisionPie']);
            Route::get('/get-daily-update/{section}/{step}', [SalesViewController::class, 'getDailyUpdate']);
            Route::get('/get-undefined-customer-transaction', [SalesViewController::class, 'getUndefinedCustomerTransaction']);
            Route::get('/get-customer-loads/{customer}/{division}', [SalesViewController::class, 'getCustomerLoads']);
        });

        Route::prefix('/truck')->group(function () {
            //View and Generate
            Route::get('/performance', [SalesViewController::class, 'gotoTruckingPerformance']);
            Route::get('/performance-generate/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'generateTruckingPerformance']);
            Route::get('/performance-customer/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'generateCustomerPerformance']);
            Route::get('/performance-routes/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'generateRoutesPerformance']);
            Route::get('/utility', [SalesViewController::class, 'gotoTruckingUtility']);
            Route::get('/utility-generate/{ownership}', [SalesTruckController::class, 'generateTruckingUtility']);

            //Export
            Route::get('/performance-generate-download/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'downloadTruckingPerformance']);
            Route::get('/performance-routes-download/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'downloadRoutesPerformance']);
            Route::get('/performance-customer-download/{ownership}/{division}/{nopol}/{constraint}/{status}', [SalesTruckController::class, 'downloadCustomerPerformance']);

            //Data
            Route::get('/filter-nopol/{division}/{ownership}', [SalesTruckController::class, 'getFilteringTruck']);
            Route::get('/filter-customer/{division}/{ownership}/{nopol}', [SalesTruckController::class, 'getFilteringCustomer']);
            Route::get('get-monthly-customers/{nopol}/{division}', [SalesTruckController::class, 'getCustomerData']);
            Route::get('get-monthly-units/{customer}/{division}', [SalesTruckController::class, 'getUnitData']);
            Route::get('/get-yearly-achievement/{id}/{division}', [SalesTruckController::class, 'getYearlyAchievement']);
            Route::get('/get-lead-time', [SalesTruckController::class, 'getLeadTime']);
            Route::get('/get-trucking-calendar/{nopol}', [SalesTruckController::class, 'getTruckCalendar']);
        });

        //LOAD ID DETAIL INVOICE
        Route::get('/load-detail/{load_id}', [SalesViewController::class, 'showLoadDetail']);
    });
});


//LOA FILE MANAGEMENT
Route::middleware(['auth', 'priviledge:loa,master'])->group(function () {
    //GET LOA FILES
    Route::get('/show-pdf/{filename}/{content_path}', function ($filename, $content_path) {
        return response()->file(storage_path("app/loa_files/" . $content_path . "/" . $filename));
    })->name('show-pdf');

    Route::get('/show-png/{filename}/{content_path}', function ($filename, $content_path) {
        $path = storage_path("app/loa_files/" . $content_path . "/" . $filename);

        if (!File::exists($path)) {
            return response()->json(["message" => "image not found!"], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('show-png');

    Route::get('/show-excel-pages/{filename}/{content_path}', function ($filename, $content_path) {
        $path = storage_path("app/loa_files/" . $content_path . "/" . $filename);

        //Read File
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($path);

        $data['sheetCount'] = $spreadsheet->getSheetCount();
        $data['name'] = $spreadsheet->getSheetNames();

        return response($data, 200);
    })->name('show-excel-pages');

    Route::get('/show-excel/{filename}/{content_path}/{page}', function ($filename, $content_path, $page) {
        $path = storage_path("app/loa_files/" . $content_path . "/" . $filename);

        //Read File
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($path);

        $sheetCount = $spreadsheet->getSheetCount();

        $sheet = $spreadsheet->getSheet($page);
        $name = $spreadsheet->getSheetNames()[$page];

        $activeSpreadsheet = new Spreadsheet();
        $activeSpreadsheet->addExternalSheet($sheet, 0);

        $writer = IOFactory::createWriter($activeSpreadsheet, 'Html');
        $message = $writer->save('php://output');
    })->name('show-excel');

    Route::get('/show-msg/{filename}/{content_path}', function ($filename, $content_path) {
        $path = storage_path("app/loa_files/" . $content_path . "/" . $filename);

        $decodelocation = '/var/html/tmp/';
        $baseurl = 'http://example.com/tmp/';
        $uniquefolder = uniqid();
        // message parsing and file IO are kept separate
        $messageFactory = new MAPI\MapiMessageFactory();
        $documentFactory = new Pear\DocumentFactory();

        $ole = $documentFactory->createFromFile($path);
        $message = $messageFactory->parseMessage($ole);

        /*
        $html = preg_replace_callback($this->regex, "utf8replacer", $message->getBodyHTML());

        if (count($message->getAttachments()) > 0) {
            foreach ($message->getAttachments() as $attach) {
                $filename = $attach->getFilename();
                $temploc = $decodelocation . '/' . $uniquefolder . '/' . $filename;
                $fileurl = $baseurl . '/' . $uniquefolder . '/' . $filename;
                $replace_string = get_string_between($html, 'cid:' . $filename, '"');
                if ($replace_string) {
                    file_put_contents($temploc, $attach->getData());
                    $html = str_replace('cid:' . $filename . $replace_string, base_url($temploc), $html);
                } else {
                    $geturl = array(
                        'filename' => $filename,
                        'path' => cencode($temploc),
                    );
                    $attachments[] = '<a target="_blank" href="' . $fileurl . '">' . $filename . '</a>';
                }
            }
        }
        */
        foreach ($message->getRecipients() as $recipient) {
            $email = $recipient->getEmail();
            $name = $recipient->getName();
            if ($recipient->getType() == 'From') {
                $From[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
            } elseif ($recipient->getType() == 'To') {
                $To[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
            } elseif ($recipient->getType() == 'Cc') {
                $Cc[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
            } elseif ($recipient->getType() == 'Bcc') {
                $Bcc[] = ($name) ? '<a href="mailto:' . $email . '">' . $name . '</a>' : '<a href="mailto:' . $email . '">' . $email . '</a>';
            }
        }

        $data = array(
            'From' => '<a href="mailto:' . $message->properties['sender_email_address'] . '">' . $message->properties['sender_name'] . '</a>',
            'To' => (isset($To)) ? implode('; ', $To) : '',
            'Cc' => (isset($Cc)) ? implode('; ', $Cc) : '',
            'Bcc' => (isset($Bcc)) ? implode('; ', $Bcc) : '',
            'Subject' => $message->properties['subject'],
            'Sender' => $message->getSender(),
            'Body' => str_replace('\r\n', 'HAHA', $message->getBody()),
            'hasAttachment' => $message->properties['hasattach'],
            //'attachments' => ($attachments) ? implode('; ', $attachments) : false,
            //'html' => $html,
        );

        dd($data);
        //return ($data['Body']);
    })->name('show-msg');
});

//DEPENDENT INDONESIA DROPDOWN
Route::get('/provinces/{id}', 'IndonesiaDropdownController@provinces')->name('provinces');
Route::get('/cities/{id}', 'IndonesiaDropdownController@cities')->name('cities');
Route::get('/districts/{id}', 'IndonesiaDropdownController@districts')->name('districts');
Route::get('/villages/{id}', 'IndonesiaDropdownController@villages')->name('villages');

//SHARED API and RANDOM PERSONAL QUEST
Route::get('/lincrest/statistic/routes/{filterDate}', [SharedController::class, 'generateRoutesReport']);
Route::get('/lincrest/statistic/billableBlujay', [SharedController::class, 'generateBillableBlujayReport']);
