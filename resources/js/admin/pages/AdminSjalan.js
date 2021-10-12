import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminSjalan = () => {
    console.log("loading adminSjalan JS");

    const getSj = () => {
        $('#yajra-datatable-sj-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/data/get-sj",
            columns: [
              {data: 'id_so', name: 'id_so'},
              {data: 'load_id', name: 'load_id'},
              {data: 'nopol', name: 'nopol'},
              {data: 'penerima', name: 'penerima'},
              {data: 'total_weightSO', name: 'total_weightSO'},
              {data: 'utilitas', name: 'utilitas'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });

        return false;
    }

    const checkSj = () => {
        $('#form-so-new .check-sj').on('click', function(e){
            var currentStats = $(this).val();
            e.preventDefault();

            if(currentStats == "check"){
                console.log("Checking SJ...");

                var id = $('#form-so-new .input-id-so').val();
                //console.log(id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                });
                $.ajax({
                    url: '/suratjalan/check/'+id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);

                        if(data['check']){
                            $(this).val("cancel");
                            $(this).html("Cancel");

                            $('#form-so-new .input-id-so').prop('readonly',true);
                            $('#form-so-new .input-loadid').prop('readonly',false);
                            $('#form-so-new .input-nopol').prop('readonly',false);
                            $('#form-so-new .input-penerima').prop('readonly',false);
                            $('#form-so-new .input-bongkar').prop('readonly',false);
                            $('#form-so-new .input-muat').prop('readonly',false);
                            $('#form-so-new .input-driver-nmk').prop('readonly',false);
                            $('#form-so-new .input-driver-name').prop('readonly',false);
                            $('#form-so-new .btn-simpan').prop('disabled',false);

                            Snackbar.show({
                                text: "Surat jalan belum terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }else{
                            Snackbar.show({
                                text: "Surat jalan sudah terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }

                    }
                });
            }else{
                $(this).val("check");
                $(this).html('Check SJ');

                $('#form-so-new .input-id-so').prop('readonly',false);
                $('#form-so-new .input-loadid').prop('readonly',true);
                $('#form-so-new .input-nopol').prop('readonly',true);
                $('#form-so-new .input-penerima').prop('readonly',true);
                $('#form-so-new .input-bongkar').prop('readonly',true);
                $('#form-so-new .input-muat').prop('readonly',true);
                $('#form-so-new .input-driver-nmk').prop('readonly',true);
                $('#form-so-new .input-driver-name').prop('readonly',true);
                $('#form-so-new .btn-simpan').prop('disabled',true);

                Snackbar.show({
                    text: "Silahkan cek kembali nomor SJ.",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            }


            return false;
        });
    }

    const addSj = () => {
        $('#form-so-new').on('submit', function(e){
            e.preventDefault();

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
                        url: '/suratjalan/addSj',
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
        })
    }

    const deleteSj = () => {
        $(document).on('submit','#btn-sj-delete', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus!'
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
                        url: '/suratjalan/delete',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data surat jalan sudah dihapus.',
                                icon: 'success'
                            }).then(function(){
                                var table = $('#yajra-datatable-sj-list').DataTable();
                                table.ajax.reload(null, false);
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
    

    getSj();
    addSj();
    deleteSj();
    checkSj();
};
