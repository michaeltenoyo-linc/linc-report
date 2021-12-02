import { AdminLoa } from "./pages/AdminLoa";
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
};

load();
