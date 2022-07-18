import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';
import moment from 'moment';

export const AdminSjalan = () => {
    console.log("loading adminSjalan JS");

    const getSj = () => {
        $('#yajra-datatable-sj-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/smart/data/get-sj",
            columns: [
              {data: 'splitId', name: 'id_so'},
              {data: 'load_id', name: 'load_id'},
              {data: 'created_at_format', name: 'created_at_format'},
              {data: 'penerima', name: 'penerima'},
              //{data: 'total_weightSO', name: 'total_weightSO'},
              //{data: 'utilitas', name: 'utilitas'},
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

                if($('#form-so-new .input-no-do').val()){
                    id += "$"+$('#form-so-new .input-no-do').val();
                }
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
                    url: '/smart/suratjalan/check/'+id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);

                        if(data['check']){
                            $(this).val("cancel");
                            $(this).html("Cancel");

                            $('#form-so-new .input-id-so').prop('readonly',true);
                            $('#form-so-new .input-no-do').prop('readonly',true);
                            $('#form-so-new .input-loadid').prop('readonly',false);
                            $('#form-so-new .input-nopol').prop('readonly',false);
                            $('#form-so-new .input-penerima').prop('readonly',false);
                            $('#form-so-new .input-customer-type').prop('disabled',false);
                            $('#form-so-new .input-bongkar').prop('readonly',false);
                            $('#form-so-new .input-multidrop').prop('readonly',false);
                            $('#form-so-new .input-overnight').prop('readonly',false);
                            $('#form-so-new .input-muat').prop('readonly',false);
                            $('#form-so-new .input-setor-sj').prop('readonly',false);
                            $('#form-so-new .input-note').prop('readonly',false);
                            $('#form-so-new .input-driver-nmk').prop('readonly',false);
                            $('#form-so-new .input-driver-name').prop('readonly',false);
                            $('#form-so-new .check-truck').prop('disabled',false);
                            $('#form-so-new .check-load-smart').prop('disabled',false);
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
                $('#form-so-new .input-no-do').prop('readonly',false);
                $('#form-so-new .input-loadid').prop('readonly',true);
                $('#form-so-new .input-customer-type').prop('disabled',true);
                $('#form-so-new .input-nopol').prop('readonly',true);
                $('#form-so-new .input-penerima').prop('readonly',true);
                $('#form-so-new .input-bongkar').prop('readonly',true);
                $('#form-so-new .input-multidrop').prop('readonly',true);
                $('#form-so-new .input-overnight').prop('readonly',true);
                $('#form-so-new .input-muat').prop('readonly',true);
                $('#form-so-new .input-setor-sj').prop('readonly',true);
                $('#form-so-new .input-note').prop('readonly',true);
                $('#form-so-new .input-driver-nmk').prop('readonly',true);
                $('#form-so-new .input-driver-name').prop('readonly',true);
                $('#form-so-new .check-truck').prop('disabled',true);
                $('#form-so-new .check-load-smart').prop('disabled',true);
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

    const checkAutofillLoad = () => {
        $('#form-so-new .check-load-smart').on('click', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Seluruh isian akan diubah secara otomatis!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, ubah!'
              }).then((result) => {
                if (result.isConfirmed) {
                    var id = $('#form-so-new .input-loadid').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                    });
                    $.ajax({
                        url: '/smart/suratjalan/autofill-load/'+id,
                        type: 'GET',
                        success: (data) => {
                            console.log(data);
                            
                            if(data['isExist']){
                                //Reset Vehicle and Items
                                $('#form-so-new .check-truck').val("check");
                                $('#form-so-new .check-truck').html('Cek Kendaraan');
                                $('#form-so-new .input-nopol').prop('readonly',false);
                                $('#form-so-new .open-item-modal').prop('disabled',true);

                                //reset item value
                                $('#form-so-new .so-items-list-body').empty();
                                $('#form-so-new .kategori_truck').val(0);
                                $('#form-so-new .input-total-weight').val(0);
                                $('#form-so-new .input-total-utility').val(0);
                                $('#form-so-new .input-total-qty').val(0);
                                $('#form-so-new .teks-total-weight').html("Total : Cek Kendaraan...");
                                $('#form-so-new .teks-utility').html("Utilitas : Cek Kendaraan...");
                            
                                //Autofill Form
                                $('#form-so-new .input-customer-type').val(data['suratjalan']['customer_type']);
                                $('#form-so-new .input-penerima').val(data['suratjalan']['penerima']);
                                $('#form-so-new .input-driver-name').val(data['suratjalan']['driver_name']);
                                $('#form-so-new .input-nopol').val(data['suratjalan']['nopol']);
                                $('#form-so-new .input-note').val(data['suratjalan']['note']);

                                let date_setor = moment(data['suratjalan']['tgl_setor_sj']).format('YYYY-MM-DD');
                                let date_terima = moment(data['suratjalan']['tgl_terima']).format('YYYY-MM-DD');

                                $('#form-so-new .input-setor-sj').val(date_setor);
                                $('#form-so-new .input-muat').val(date_terima);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: "Silahkan cek kembali autofill suratjalan!",
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: "Tidak ditemukan SJ Smart dengan LOAD ID berikut. :P",
                                });
                            }
                        
                        }
                    });
                }
            })
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
                        url: '/smart/suratjalan/addSj',
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
                        url: '/smart/suratjalan/delete',
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
    checkAutofillLoad();
    deleteSj();
    checkSj();
};
