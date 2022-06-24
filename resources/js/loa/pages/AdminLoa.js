import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const inputLoa = () => {
        $('#form-loa-new').on('submit', function(e){
            e.preventDefault();
            console.log("Saving new LOA...");

            //AJAX Save
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
                        url: '/loa/data/insert',
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: new FormData($('#form-loa-new')[0]),
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

    const getLoa = () => {
        let type = $('#loa_type_raw').val();
        console.log(type);
        $('#yajra-datatable-loa-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/loa/data/read/'+type,
            columns: [
                {data: 'reference', name: 'reference'},
                {data: 'name', name: 'name'},
                {data: 'last_period', name: 'last_period'},
                {data: 'count', name: 'count'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }

    inputLoa();
    getLoa();
};
