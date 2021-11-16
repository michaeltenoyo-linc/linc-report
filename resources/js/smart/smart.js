import { AdminItems } from "./pages/AdminItems";
import { AdminTrucks } from "./pages/AdminTrucks";
import { AdminSjalan } from "./pages/AdminSjalan";
import { ItemsModal } from "./modals/ItemsModal";
import { AdminReport } from "./pages/AdminReport";

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
    

    AdminItems();
    AdminTrucks();
    AdminSjalan();
    ItemsModal();
    AdminReport();
};

load();
