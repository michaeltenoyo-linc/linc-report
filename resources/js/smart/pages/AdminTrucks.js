import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminTrucks = () => {
    console.log("loading adminTrucks JS");

    const getTrucks = () => {
        /*
        $('#admin-master-account').ready(function () {
            console.log("Taking Data...");
            var table = $('#admin-master-account .yajra-datatable ').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/user/action/get_list_customer",
                columns: [
                  {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
            console.log(table);
        });
        */

        $('#yajra-datatable-trucks-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/smart/data/get-trucks",
            columns: [
              {data: 'nopol', name: 'nopol'},
              {data: 'fungsional', name: 'fungsional'},
              {data: 'ownership', name: 'ownership'},
              {data: 'owner', name: 'owner'},
              {data: 'type', name: 'type'},
              {data: 'v_gps', name: 'v_gps'},
              {data: 'site', name: 'site'},
              {data: 'area', name: 'area'},
              {data: 'taken', name: 'taken'},
              {data: 'kategori', name: 'kategori'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    }

    const autocompleteTrucks = () => {
        $('#form-so-new .autocomplete-trucks').typeahead({
            source: function (query, process) {
                return $.get('/smart/data/autocomplete-trucks', {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });

        console.log("loading typeahead done.");
    }

    const checkTruck = () => {
        $('#form-so-new .check-truck').on('click', function(e){
            var currentStats = $(this).val();
            e.preventDefault();

            if(currentStats == "check"){
                console.log("Checking Truck...");

                var id = $('#form-so-new .input-nopol').val();
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
                    url: '/smart/trucks/check/'+id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);

                        if(!data['check']){
                            Snackbar.show({
                                text: data['message'],
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }else{
                            $(this).val("cancel");
                            $(this).html("Cancel");

                            //setup value
                            $('#form-so-new .kategori-truck').val(data['kategori']);
                            $('#form-so-new .teks-total-weight').html("Total : 0 Kg. | 0");
                            $('#form-so-new .teks-utility').html("Utilitas : 0%");
                            $('#form-so-new .input-total-weight').val(0);
                            $('#form-so-new .input-total-utility').val(0);
                            $('#form-so-new .input-total-qty').val(0);

                            //disable element
                            $('#form-so-new .input-nopol').prop('readonly',true);
                            $('#form-so-new .open-item-modal').prop('disabled',false);

                            Snackbar.show({
                                text: "Kendaraan ditemukan.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }

                    }
                });
            }else{
                $(this).val("check");
                $(this).html('Cek Kendaraan');
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

                Snackbar.show({
                    text: "Silahkan cek kembali nopol kendaraan.",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            }


            return false;
        });

        $('#form-trucks-new .check-truck').on('click', function(e){
            e.preventDefault();

            var currentStats = $(this).val();

            if(currentStats == "check"){
                console.log("Checking Truck...");

                var id = $('#form-trucks-new .input-nopol').val();
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
                    url: '/smart/trucks/check/'+id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);

                        if(!data['check']){
                            Snackbar.show({
                                text: "Kendaraan tidak ada, dapat melanjutkan.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });

                            $('#form-trucks-new .input-nopol').prop('readonly',true);
                            $(this).val("cancel");
                            $(this).html("Cancel");

                            //Enable form input
                            $('#form-trucks-new .input-fungsional').prop('readonly',false);
                            $('#form-trucks-new .input-ownership').prop('readonly',false);
                            $('#form-trucks-new .input-owner').prop('readonly',false);
                            $('#form-trucks-new .input-type').prop('readonly',false);
                            $('#form-trucks-new .input-vgps').prop('readonly',false);
                            $('#form-trucks-new .input-site').prop('readonly',false);
                            $('#form-trucks-new .input-area').prop('readonly',false);
                            $('#form-trucks-new .input-pengambilan').prop('disabled',false);
                            $('#form-trucks-new .input-kategori').prop('readonly',false);
                            $('#form-trucks-new .input-submit').prop('disabled',false);
                        }else{
                            Snackbar.show({
                                text: "Kendaraan SUDAH ADA. Harap dicek kembali pada LIST TRUCK.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }

                    }
                });
            }else{
                $(this).val("check");
                $(this).html('Cek Nopol');
                $('#form-trucks-new .input-nopol').prop('readonly',false);

                Snackbar.show({
                    text: "Silahkan cek kembali nopol kendaraan.",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });

                //Disable form input
                $('#form-trucks-new .input-fungsional').prop('readonly',true);
                $('#form-trucks-new .input-ownership').prop('readonly',true);
                $('#form-trucks-new .input-owner').prop('readonly',true);
                $('#form-trucks-new .input-type').prop('readonly',true);
                $('#form-trucks-new .input-vgps').prop('readonly',true);
                $('#form-trucks-new .input-site').prop('readonly',true);
                $('#form-trucks-new .input-area').prop('readonly',true);
                $('#form-trucks-new .input-pengambilan').prop('disabled',true);
                $('#form-trucks-new .input-kategori').prop('readonly',true);
                $('#form-trucks-new .input-submit').prop('disabled',true);
            }

            return false;
        });
    }

    const deleteTruck = () => {
        $(document).on('submit', '#btn-trucks-delete', function(e){
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
                        url: '/smart/trucks/delete',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data kendaraan sudah dihapus.',
                                icon: 'success'
                            }).then(function(){
                                var table = $('#yajra-datatable-trucks-list').DataTable();
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
            
            return false;
        });
    }

    const newTruck = () => {
        $('#form-trucks-new').on('submit', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan data sudah terisi dengan benar!",
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
                        url: '/smart/trucks/create',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data kendaraan baru sudah disimpan.',
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
            });
        });
    }

    getTrucks();
    autocompleteTrucks();
    checkTruck();
    deleteTruck();
    newTruck();
};
