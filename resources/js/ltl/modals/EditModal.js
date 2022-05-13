import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';

export const EditModal = () => {
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
            url: '/lautanluas/data/get-sj-byid/'+id_so,
            type: 'GET',
            success: (data) => {
                $('#sj-edit-modal .container-id-so').html(data['data']['sj']['id_so']+" - "+data['data']['sj']['no_do']);
                $('#sj-edit-modal .id-so').val(data['data']['sj']['id_so']);
                
                $('#sj-edit-modal .input-load-id').val(data['data']['sj']['load_id']);
                $('#sj-edit-modal .input-customer').val(data['data']['sj']['customer_name']);
                $('#sj-edit-modal .input-lokasi').val(data['data']['sj']['lokasi_pengiriman']);
                $('#sj-edit-modal .input-tgl').val(data['data']['sj']['delivery_date']);
                $('#sj-edit-modal .input-note').val(data['data']['sj']['note']);
                $('#sj-edit-modal .input-weight').val(data['data']['sj']['total_weightSO']);
                $('#sj-edit-modal .input-bongkar').val(data['data']['sj']['biaya_bongkar']);
                $('#sj-edit-modal .input-multidrop').val(data['data']['sj']['biaya_multidrop']);
                               
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
                    url: '/lautanluas/suratjalan/update',
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
                            $('#sj-edit-modal .modal').addClass('hidden');
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
