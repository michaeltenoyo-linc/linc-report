import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminItems = () => {
    console.log("loading adminProduct JS");

    const getItems = () => {
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

        $('#yajra-datatable-items-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/smart/data/get-items",
            columns: [
              {data: 'material_code', name: 'material_code'},
              {data: 'description', name: 'description'},
              {data: 'gross_weight', name: 'gross_weight'},
              {data: 'nett_weight', name: 'nett_weight'},
              {data: 'category', name: 'category'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    }

    const autocompleteItems = () => {
        $('#sj-items-modal .input-item-name').typeahead({
            source: function (query, process) {
                return $.get('/smart/data/autocomplete-items', {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });

        console.log("loading typeahead done.");
    }

    const checkMaterialCode = () => {
        $('#form-items-new .check-item').on('click', function(e){
            var currentStats = $(this).val();
            e.preventDefault();

            if(currentStats == "check"){
                console.log("Checking Item...");

                var id = $('#form-items-new .input-id-item').val();
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
                    url: '/smart/items/check-existing/'+id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);

                        if(!data['check']){
                            $(this).val("cancel");
                            $(this).html("Cancel");

                            $('#form-items-new .input-id-item').prop('readonly', true);
                            $('#form-items-new .input-item-deskripsi').prop('readonly', false);
                            $('#form-items-new .input-item-grossw').prop('readonly', false);
                            $('#form-items-new .input-item-nettw').prop('readonly', false);
                            $('#form-items-new .input-item-category').prop('readonly', false);     
                            $('#form-items-new .input-item-submit').prop('disabled', false);                            

                            Snackbar.show({
                                text: "Item belum terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }else{
                            Snackbar.show({
                                text: "Item sudah terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }

                    }
                });
            }else{
                $(this).val("check");
                $(this).html('Check Kode');

                $('#form-items-new .input-id-item').prop('readonly', false);
                $('#form-items-new .input-item-deskripsi').prop('readonly', true);
                $('#form-items-new .input-item-grossw').prop('readonly', true);
                $('#form-items-new .input-item-nettw').prop('readonly', true);
                $('#form-items-new .input-item-category').prop('readonly', true);     
                $('#form-items-new .input-item-submit').prop('disabled', true);  

                Snackbar.show({
                    text: "Silahkan cek kembali material code.",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            }


            return false;
        }); 

    }

    const addItem = () => {
        $('#form-items-new').on('submit', function(e){
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
                        url: '/smart/items/addItem',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data item baru sudah disimpan.',
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

    const deleteItem = () => {
        $(document).on('submit','#btn-items-delete', function(e){
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
                        url: '/smart/items/delete',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data item sudah dihapus.',
                                icon: 'success'
                            }).then(function(){
                                var table = $('#yajra-datatable-items-list').DataTable();
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

    addItem();
    deleteItem();
    autocompleteItems();
    getItems();
    checkMaterialCode();
};
