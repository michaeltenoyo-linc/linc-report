import { LoginModal } from "./modals/LoginModal";

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

    LoginModal();
};

load();
