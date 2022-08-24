import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminTicket = () => {
    console.log("loading AdminTicket PKG JS");

    const onCheckPosto = async () => {
        $('#check-posto').on('click', async function(e){
            e.preventDefault();
            let posto = $('.input-cek-posto').val();
            let checkCounter = $('#check-posto').val();
            $('.input-cek-posto').attr('readonly',true);

            if(checkCounter == "check"){
                console.log("Checking POSTO "+posto);  
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                });
                $.ajax({
                    url: '/pkg/ticket/check/'+posto,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);
                        $('#check-posto').val("cancel");
                        $('#check-posto').html("Cancel");
                        $('#check-posto').removeClass();
                        $('#check-posto').addClass('btn_red');
                        if(data['check']){
                            Snackbar.show({
                                text: "Ticket belum terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });

                            //Add POSTO DAHULU
                            $('#form-posto-new').removeClass("hidden");
                            $('#form-posto-new input').attr('readonly',false);
                            $('#form-posto-new .btn-simpan').attr('disabled',false);
                            $('#form-posto-new .btn-simpan').removeClass("hidden");
                        }else{
                            Snackbar.show({
                                text: "Ticket sudah terdaftar.",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });

                            //SHOW POSTO INFO AND DISABLE
                            $('#form-posto-new .input-posto').val(data['posto']['posto']);
                            $('#form-posto-new .input-produk').val(data['posto']['produk']);
                            $('#form-posto-new .input-qty').val(data['posto']['qty']);
                            $('#form-posto-new .input-tgl-terbit').val(data['posto']['terbit']);
                            $('#form-posto-new .input-tgl-expired').val(data['posto']['expired']);
                            $('#form-posto-new .input-tujuan').val(data['posto']['tujuan']);
                            $('#form-posto-new .info-posto').html("*POSTO sudah terdaftar, silahkan melanjutkan menambahkan LOAD.");

                            $('#form-posto-new').removeClass("hidden");
                            $('#form-posto-new input').attr('readonly',true);
                            $('#form-posto-new .btn-simpan').attr('disabled',true);
                            $('#form-posto-new .btn-simpan').addClass("hidden");

                            //Langsung ADD TICKET
                            $('#form-so-new').removeClass('hidden');
                            $('#form-so-new input').attr('readonly',false);
                            $('#form-so-new .btn-simpan').attr('disabled',false);
                            $('#form-so-new .btn-simpan').val("Simpan");
                            $('#form-so-new .btn-add').val(" + ");
                            $('#form-so-new .btn-add').attr('disabled',false);
                            $('#form-so-new .input-load-list').empty();
                            $('#form-so-new .counter').val(0);
                            
                            
                        }
                    }
                });
            }else{
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Semua data tidak akan tersimpan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, cancel!'
                  }).then((result) => {
                    if (result.isConfirmed) { 
                        console.log("Cancel Check Posto");
                        $('#check-posto').val("check");
                        $('#check-posto').html("Cek POSTO");
                        $('#check-posto').removeClass();
                        $('#check-posto').addClass('btn_blue');

                        $('.input-cek-posto').attr('readonly',false);
                        //Reset POSTO
                        $('#form-posto-new').addClass('hidden');
                        $('#form-posto-new input').attr('readonly',true);
                        $('#form-posto-new .btn-simpan').attr('disabled',true);
                        $('#form-posto-new input').val("");
                        $('#form-posto-new .info-posto').html("*POSTO belum terdaftar pada database lokal, mohon input POSTO baru.");
                        $('#form-posto-new .btn-simpan').val("Simpan");

                        //Reset TICKET
                        $('#form-so-new').addClass('hidden');
                        $('#form-so-new input').attr('readonly',true);
                        $('#form-so-new .btn-simpan').attr('disabled',true);
                        $('#form-so-new .btn-add').attr('disabled',true);
                        $('#form-so-new input').val("");
                        $('#form-so-new .input-load-list').empty();
                        $('#form-so-new .btn-simpan').val("Simpan");
                        $('#form-so-new .counter').val(0);
                    }
                });
            }     
        });
    }

    const onInputPosto = async () => {
        $('#form-posto-new').on('submit', async function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan semua data sudah terisi dengan benar!",
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
                        url: '/pkg/ticket/addPosto',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data POSTO sudah disimpan.',
                                icon: 'success'
                            }).then(function(){
                                //DISABLE AND SHOW POSTO
                                $('#form-posto-new .info-posto').html("*POSTO sudah terdaftar, silahkan melanjutkan menambahkan LOAD.");
                                $('#form-posto-new').removeClass("hidden");
                                $('#form-posto-new input').attr('readonly',true);
                                $('#form-posto-new .btn-simpan').attr('disabled',true);
                                $('#form-posto-new .btn-simpan').addClass("hidden");

                                //LANJUT TAMBAH LOADS
                                $('#form-so-new').removeClass('hidden');
                                $('#form-so-new input').attr('readonly',false);
                                $('#form-so-new .btn-simpan').attr('disabled',false);
                                $('#form-so-new .btn-simpan').val("Simpan");
                                $('#form-so-new .btn-add').val(" + ");
                                $('#form-so-new .input-load-list').empty();
                                $('#form-so-new .counter').val(0);
                                $('#form-so-new .btn-add').attr('disabled',false);
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

    const onAddLoad = async () => {
        $('#form-so-new .btn-add').on('click', async function(e){
            e.preventDefault();

            let load_id = $('#form-so-new .input-load').val();
            let booking = $('#form-so-new .input-booking').val();
            let counter = parseInt($('#form-so-new .counter').val());

            if(load_id != "" && booking != ""){
                //CHECK IF LOAD ALREADY EXIST
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                });
                $.ajax({
                    url: '/pkg/ticket/check-load/'+load_id,
                    type: 'GET',
                    success: (data) => {
                        //$(this).trigger('reset');
                        //console.log(data);
                        $('#check-posto').val("cancel");
                        $('#check-posto').html("Cancel");
                        $('#check-posto').removeClass();
                        $('#check-posto').addClass('btn_red');
                        if(data['check']){
                            //ADD TO DIV
                            let divRow = "";

                            divRow += '<div class="grid grid-cols-2 gap-2 mb-5 load-list-'+counter+'">';
                            divRow += '<input type="hidden" name="loads['+counter+']" value="'+load_id+'">';
                            divRow += '<input type="hidden" name="bookings['+counter+']" value="'+booking+'">';
                            divRow += '<div><b>'+load_id+'</b><br>'+booking+'</div>';
                            divRow += '<div id="'+counter+'" class="cursor-pointer text-3xl w-1 load-delete"><i class="fas fa-times"></i></div>';
                            divRow += '</div>';

                            $('#form-so-new .input-load-list').append(divRow);

                            //Add Counter and reset
                            $('#form-so-new .counter').val(counter+1);
                            $('#form-so-new .input-load').val("");
                            $('#form-so-new .input-booking').val("");
                        }else{
                            console.log(data);
                            Snackbar.show({
                                text: "Load ID sudah terdaftar pada POSTO : "+data['load']['posto']+".",
                                actionText: 'Tutup',
                                duration: 3000,
                                pos: 'bottom-center',
                            });
                        }
                    }
                });
            }else{
                Snackbar.show({
                    text: "Semua field harus terisi!",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            }
        });
    }

    const onRemoveLoad = async () => {
        $(document).on('click', '#form-so-new .load-delete', async function(e){
            e.preventDefault();

            let id = $(this).attr('id');

            $('#form-so-new .load-list-'+id).remove();
        })
    }

    const onSaveLoads = async () => {
        $('#form-so-new').on('submit', async function(e){
            e.preventDefault();

            let posto = $('#form-posto-new .input-posto').val();
            $('#form-so-new .input-posto').val(posto);

            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan semua data sudah terisi dengan benar!",
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
                        url: '/pkg/ticket/addLoads',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            console.log(data);
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data LOADS sudah disimpan.',
                                icon: 'success',
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

    const getTicket = () => {
        $('#yajra-datatable-ticket-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/pkg/ticket/read",
            columns: [
              {data: 'posto', name: 'posto'},
              {data: 'qty', name: 'qty'},
              {data: 'terbit', name: 'terbit'},
              {data: 'expired', name: 'expired'},
              {data: 'produk', name: 'produk'},
              {data: 'tujuan', name: 'tujuan'},
              {data: 'action', name: 'action'},
            ],
        });

        return false;
    }

    const onTicketDetail = async () => {
        $(document).on('click','#btn-detail-ticket', async function(e){
            let posto = $(this).val();
            console.log("DETAIL : "+posto);
        });
    }

    const onDeleteTicket = async () => {
        $(document).on('submit','#btn-ticket-delete', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Data akan dihapus secara permanen beserta semua loadnya!",
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
                        url: '/pkg/ticket/delete',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data Ticket sudah dihapus.',
                                icon: 'success'
                            }).then(function(){
                                var table = $('#yajra-datatable-ticket-list').DataTable();
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

    onDeleteTicket();
    onTicketDetail();
    onRemoveLoad();
    onCheckPosto();
    onInputPosto();
    onAddLoad();
    onSaveLoads();
    getTicket();
};
