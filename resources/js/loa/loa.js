import { AdminLoa } from "./pages/AdminLoa";
import { TransportModal } from "./modals/TransportModal";
import PDFObject from 'pdfobject';

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

    AdminLoa();
    TransportModal();
};

load();
