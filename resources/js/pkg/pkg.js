import { AdminTicket } from "./pages/AdminTicket";

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

    AdminTicket();
};

load();
