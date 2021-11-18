import { LoginModal } from "./modals/LoginModal";
import { Auth } from "./pages/auth";

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
    Auth();
};

load();
