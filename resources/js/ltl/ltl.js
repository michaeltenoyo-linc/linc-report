import { AdminSjalan } from "./pages/AdminSjalan";
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
    })
    
    AdminSjalan();
    AdminReport();
};

load();
