import { Landing, loadStaticChart, loadDynamicChart } from "./pages/landing";
import { masterBudget } from "./pages/masterBudget";
import { BySales, RefreshSalesPie } from "./pages/bySales";
import { ByDivision, RefreshDivisionPie } from "./pages/byDivision";

export const load = () => {
    //Loading Spinner

    $(document).on({
        ajaxStart: function(){
            $('#loader').removeClass('hidden');
        },
        ajaxStop: function(){
            $("#loader").addClass("hidden");
        }
    });

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
        let chartBahanaMonthly = '<canvas id="chartBahanaMonthly" width="100%" height="30%"></canvas>';
        let chartTransportDaily = '<canvas id="chartTransportDaily" width="100%" height="35%"></canvas>';
        let chartEximDaily = '<canvas id="chartEximDaily" width="100%" height="30%"></canvas>';
        let chartBulkDaily = '<canvas id="chartBulkDaily" width="100%" height="30%"></canvas>';

        $('#canvas-bahana-monthly').empty();
        $('#canvas-transport-daily').empty();
        $('#canvas-exim-daily').empty();
        $('#canvas-bulk-daily').empty();

        $('#canvas-bahana-monthly').html(chartBahanaMonthly);
        $('#canvas-transport-daily').html(chartTransportDaily);
        $('#canvas-exim-daily').html(chartEximDaily);
        $('#canvas-bulk-daily').html(chartBulkDaily);

        loadDynamicChart();
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

    Landing();
    masterBudget();
    BySales();
    RefreshSalesPie();
    ByDivision();
    RefreshDivisionPie();
};

load();
