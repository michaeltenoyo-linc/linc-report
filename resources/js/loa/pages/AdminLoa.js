import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const onChangeLoaDivision = () => {
        $('#form-loa-new .input-divisi').on('change',function(e){
            e.preventDefault();
            var division = $(this).val();

            if(division == "exim" || division == "transport"){
                $('#form-loa-new .transport-exim').removeClass("hidden");
                $('#form-loa-new .warehouse').addClass("hidden");
                $('#form-loa-new .bulk').addClass("hidden");
            }else if(division == "warehouse"){
                $('#form-loa-new .transport-exim').addClass("hidden");
                $('#form-loa-new .warehouse').removeClass("hidden");
                $('#form-loa-new .bulk').addClass("hidden");
            }else if(division == "bulk"){
                $('#form-loa-new .transport-exim').addClass("hidden");
                $('#form-loa-new .warehouse').addClass("hidden");
                $('#form-loa-new .bulk').removeClass("hidden");
            }
        });
    }    

    onChangeLoaDivision();
};
