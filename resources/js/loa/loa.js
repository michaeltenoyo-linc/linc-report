import { AdminLoa } from "./pages/AdminLoa";
import PDFObject from 'pdfobject';
import { LoaDetail } from "./pages/LoaDetail";
import { LoaModal } from "./modals/LoaModal";

export const load = () => {
    const viewContent = $('#page-content').val();
    //Loading Spinner
    $(document).on({
        ajaxStart: function(){
            $('#loader').removeClass('hidden');
        },
        ajaxStop: function(){
            $("#loader").addClass("hidden");
        }
    })

    if(viewContent == 'list-loa-detail'){
        LoaDetail();
    }

    AdminLoa();
    LoaModal();
};

load();
