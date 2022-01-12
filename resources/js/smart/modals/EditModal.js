import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

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
            url: '/smart/data/get-sj-byid/'+id_so,
            type: 'GET',
            success: (data) => {
                $('#sj-edit-modal .container-id-so').html(data['data']['sj']['id_so']);
                $('#sj-edit-modal .id_so').val(data['data']['sj']['id_so']);
                $('#sj-edit-modal .input-load-id').val(data['data']['sj']['load_id']);
                $('#sj-edit-modal .input-penerima').val(data['data']['sj']['penerima']);
                $('#sj-edit-modal .input-customer-type').val(data['data']['sj']['customer_type']);
                $('#sj-edit-modal .input-note').val(data['data']['sj']['note']);
                               
                //ADDCOST   
                $('#sj-edit-modal .blujay-bongkar').html(data['data']['bongkar']);
            }
        });

        $('#sj-edit-modal .modal').removeClass('hidden');
    });
}
