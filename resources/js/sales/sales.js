import { Landing, loadStaticChart, loadDynamicChart } from "./pages/landing";
import { masterBudget } from "./pages/masterBudget";
import { BySales, RefreshSalesPie } from "./pages/bySales";
import { ByDivision, RefreshDivisionPie } from "./pages/byDivision";
import { ExportToPDF } from "./pages/exportPdf";
import { trucking } from "./pages/trucking";
import moment from 'moment';

export const load = () => {
    //Loading Spinner
    const viewContent = $('#page-content').val();
    const defaultDate = async () => {
        //Date Default
        $('#date-filter').val(moment().format('YYYY-MM'));
        $('#date-filter-landing').val(moment().format('YYYY-MM'));
        $('.date-filter-between').val(moment().format('YYYY-MM-DD'));
    }  

    /*
    $(document).on({
        ajaxStart: function(){
            $('#loader').removeClass('hidden');
        },
        ajaxStop: function(){
            $("#loader").addClass("hidden");
        }
    });
    */

    //Disable Scroll on input
    $('form').on('focus', 'input[type=number]', function(e){
        $(this).on('wheel.disableScroll', function(e){
            e.preventDefault();
        });
    });

    $('form').on('blur', 'input[type=number]', function(e){
        $(this).off('wheel.disableScroll');
    });


    //Filtering date landing page
    $('#date-filter-landing').on('change', async function(){
        var inputDate = new Date($(this).val());
        var year = inputDate.getFullYear();
        var month = inputDate.getMonth()+1;

        const fetchChangeDate = await $.get('/sales/filter-date/'+month+'/'+year);

        //Chart Refresh
        let chartTransportMonthly = '<canvas id="chartTransportMonthly" width="100%" height="30%"></canvas>';
        let chartEximMonthly = '<canvas id="chartEximMonthly" width="100%" height="30%"></canvas>';
        let chartBulkMonthly = '<canvas id="chartBulkMonthly" width="100%" height="30%"></canvas>';
        let chartWarehouseMonthly = '<canvas id="chartWarehouseMonthly" width="100%" height="30%"></canvas>';
        let chartTransportDaily = '<canvas id="chartTransportDaily" width="100%" height="35%"></canvas>';
        let chartEximDaily = '<canvas id="chartEximDaily" width="100%" height="30%"></canvas>';
        let chartBulkDaily = '<canvas id="chartBulkDaily" width="100%" height="30%"></canvas>';


        $('.canvas-landing-dynamic').empty();

        $('#canvas-transport-monthly').html(chartTransportMonthly);
        $('#canvas-exim-monthly').html(chartEximMonthly);
        $('#canvas-bulk-monthly').html(chartBulkMonthly);
        $('#canvas-warehouse-monthly').html(chartWarehouseMonthly);
        $('#canvas-transport-daily').html(chartTransportDaily);
        $('#canvas-exim-daily').html(chartEximDaily);
        $('#canvas-bulk-daily').html(chartBulkDaily);

        loadDynamicChart();
    });

    //Filtering date between
    $(document).on('change', '.date-filter-between', async function(e){
        var inputDateFrom = new Date($('#from').val());
        var yearFrom = inputDateFrom.getFullYear();
        var monthFrom = inputDateFrom.getMonth();
        var dateFrom = inputDateFrom.getDate();

        var inputDateTo = new Date($('#to').val());
        inputDateTo.setDate(inputDateTo.getDate() + 1);
        var yearTo = inputDateTo.getFullYear();
        var monthTo = inputDateTo.getMonth();
        var dateTo = inputDateTo.getDate();

        //Change Date Session
        const fetchChangeDate = await $.get('/sales/filter-date-between/'+dateFrom+'/'+monthFrom+'/'+yearFrom+'/'+dateTo+'/'+monthTo+'/'+yearTo);
        console.log(fetchChangeDate);
    });

    //Filtering date
    $('#date-filter').on('change', async function(){
        var inputDate = new Date($(this).val());
        var year = inputDate.getFullYear();
        var month = inputDate.getMonth()+1;

        const fetchChangeDate = await $.get('/sales/filter-date/'+month+'/'+year);

        //Monitoring Master
        try {
            $('#yajra-datatable-monitoring-budget').DataTable().ajax.reload(null, false);   
        } catch (error) {console.log(error);}

        //By Sales
        try {
            $('#yajra-datatable-sales-budget').DataTable().ajax.reload(null, false);

            $('.divisionPie').empty();

            let canvasTransport = '<canvas id="chartSalesTransport" width="100%" height="30%"></canvas>';
            let canvasExim = '<canvas id="chartSalesExim" width="100%" height="30%"></canvas>';
            let canvasBulk = '<canvas id="chartSalesBulk" width="100%" height="30%"></canvas>';
            
            $('#canvas-transport').html(canvasTransport);
            $('#canvas-exim').html(canvasExim);
            $('#canvas-bulk').html(canvasBulk);
            RefreshSalesPie();
        } catch (error) {console.log(error);}

        //By Division
        try {
            $('#yajra-datatable-division-budget').DataTable().ajax.reload(null, false);   
            
            $('.salesPie').empty();
            $('#unlocated-division-customers').empty();

            let canvasAdit = '<canvas id="chartDivisionAdit" width="100%" height="30%"></canvas>';
            let canvasEdwin = '<canvas id="chartDivisionEdwin" width="100%" height="30%"></canvas>';
            let canvasWillem = '<canvas id="chartDivisionWillem" width="100%" height="30%"></canvas>';
            let canvasUnlocated = '<canvas id="chartDivisionUnlocated" width="100%" height="30%"></canvas>';
            
            $('#canvas-adit').html(canvasAdit);
            $('#canvas-edwin').html(canvasEdwin);
            $('#canvas-willem').html(canvasWillem);
            $('#canvas-unlocated').html(canvasUnlocated);

            RefreshDivisionPie();
        } catch (error) {console.log(error);}
    })

    
    defaultDate();   
    //Load Function for each Layer
    if(viewContent == "landing"){
        Landing();
    }else if(viewContent == "masterMonitoring"){
        masterBudget();
    }else if(viewContent == "BySales"){
        BySales();
        RefreshSalesPie();
    }else if(viewContent == "ByDivision"){
        ByDivision();
        RefreshDivisionPie();
    }else if(viewContent == "exportPDF"){
        $(document).on({
            ajaxStart: function(){
                $('#loader').removeClass('hidden');
            },
            ajaxStop: function(){
                $("#loader").addClass("hidden");
            }
        });
        
        ExportToPDF();
    }else if(viewContent == "unitPerformance"){
        $(document).on({
            ajaxStart: function(){
                $('#loader').removeClass('hidden');
            },
            ajaxStop: function(){
                $("#loader").addClass("hidden");
            }
        });

        trucking();
    }
};

load();
