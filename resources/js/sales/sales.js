import { Landing } from "./pages/landing";
import { masterBudget } from "./pages/masterBudget";
import { BySales } from "./pages/bySales";
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
        } catch (error) {console.log(error);}

        //By Division
        try {
            $('#yajra-datatable-division-budget').DataTable().ajax.reload(null, false);   
            
            $('.salesPie').empty();

            let canvasAdit = '<canvas id="chartDivisionAdit" width="100%" height="30%"></canvas>';
            let canvasEdwin = '<canvas id="chartDivisionEdwin" width="100%" height="30%"></canvas>';
            let canvasWillem = '<canvas id="chartDivisionWillem" width="100%" height="30%"></canvas>';
            
            $('#canvas-adit').html(canvasAdit);
            $('#canvas-edwin').html(canvasEdwin);
            $('#canvas-willem').html(canvasWillem);

            RefreshDivisionPie();
        } catch (error) {console.log(error);}
    })

    Landing();
    masterBudget();
    BySales();
    ByDivision();
    RefreshDivisionPie();
};

load();
