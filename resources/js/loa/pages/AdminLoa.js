import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const saveLoa = () =>{
        $('#form-loa-new').on('submit', function(e){
            e.preventDefault();
            console.log("Saving new LOA...");

            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan data sudah benar semua!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, simpan!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                    });
                    $.ajax({
                        url: '/loa/action/warehouse/insert',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data surat jalan sudah disimpan.',
                                icon: 'success'
                            }).then(function(){
                                location.reload();
                            });
                        },
                        error : function(request, status, error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: (JSON.parse(request.responseText)).message,
                            })
                        },
                    });


                }
              })
        });
    }

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
    saveLoa();
};
