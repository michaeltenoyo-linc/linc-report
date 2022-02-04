import { Landing } from "./pages/landing";
import { masterBudget } from "./pages/masterBudget";
import { BySales } from "./pages/bySales";
import { ByDivision } from "./pages/byDivision";

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

    Landing();
    masterBudget();
    BySales();
    ByDivision();
};

load();
