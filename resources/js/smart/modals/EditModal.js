import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';

export const EditModal = () => {
    //Edit SJ
    $('#sj-edit-modal .detail-sj').on('click', function(e){
        e.preventDefault();
        let id_so = $('#sj-edit-modal .container-id-so').html();
        console.log("On Click Detail SJ : "+id_so);

        window.location.href = '/smart/nav-so-detail/'+id_so;
    });

    $(document).on('click', '#btn-sj-edit', function(e){
        e.preventDefault();
        let id_so = $(this).val();

        
        console.log("Open Modal :"+id_so);

        //GET SO DATA BY ID
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            dataType: 'JSON',
        });
        $.ajax({
            url: '/smart/data/get-sj-byid/'+id_so,
            type: 'GET',
            success: (data) => {
                $('#sj-edit-modal .container-id-so').html(data['data']['sj']['id_so']);
                $('#sj-edit-modal .id_so').val(data['data']['sj']['id_so']);
                $('#sj-edit-modal .input-load-id').val(data['data']['sj']['load_id']);
                $('#sj-edit-modal .input-penerima').val(data['data']['sj']['penerima']);
                $('#sj-edit-modal .input-customer-type').val(data['data']['sj']['customer_type']);
                $('#sj-edit-modal .input-note').val(data['data']['sj']['note']);
                $('#sj-edit-modal .input-bongkar').val(data['data']['sj']['biaya_bongkar']);
                $('#sj-edit-modal .input-overnight').val(data['data']['sj']['biaya_overnight']);
                $('#sj-edit-modal .input-multidrop').val(data['data']['sj']['biaya_multidrop']);
                               
                //ADDCOST   
                $('#sj-edit-modal .blujay-bongkar').html(data['data']['bongkar']);
            }
        });

        $('#sj-edit-modal .modal').removeClass('hidden');
    });

    $('#form-so-edit').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Data akan diubah secara permanen!",
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
                    url: '/smart/suratjalan/update',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    success: (data) => {
                        Swal.fire({
                            title: 'Tersimpan!',
                            text: 'Data item sudah diubah.',
                            icon: 'success'
                        }).then(function(){
                            console.log("Done Edit");
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
        });
    });

    //Edit Items
    $(document).on('click', '#btn-edit-item', async function(e){
        e.preventDefault();
        let code = $(this).val();        

        let fetchItem = await $.get('/smart/data/get-items-fromid/'+code);
        console.log(fetchItem);
        
        //Assign Data
        $('#item-edit-modal .container-code').html(fetchItem['item']['material_code']);
        $('#item-edit-modal .material_code').val(fetchItem['item']['material_code']);
        $('#item-edit-modal .input-description').val(fetchItem['item']['description']);
        $('#item-edit-modal .input-gross').val(fetchItem['item']['gross_weight']);
        $('#item-edit-modal .input-net').val(fetchItem['item']['nett_weight']);
        $('#item-edit-modal .input-category').val(fetchItem['item']['category']);

        $('#item-edit-modal .modal').removeClass('hidden');
    });

    $('#form-item-edit').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Data akan diubah secara permanen!",
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
                    url: '/smart/items/update',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    success: (data) => {
                        Swal.fire({
                            title: 'Tersimpan!',
                            text: 'Data item sudah diubah.',
                            icon: 'success'
                        }).then(function(){
                            console.log("Done Edit");
                            $('#item-edit-modal .modal').addClass('hidden');
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
        });
    })
}
