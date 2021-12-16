import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

export const TransportModal = () => {
    $(document).on('click', '#transport-open-detail', function(e){
        e.preventDefault();

        console.log("Open Modal");

        //Update Content
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            dataType: 'JSON',
        });
        $.ajax({
            url: '/loa/action/transport/dloa/'+$(this).val(),
            type: 'GET',
            enctype: 'multipart/form-data',
            success: (data) => {
                console.log(data['data']);
                let info = data['data'];
                let loa = data['loa'];
                //Update table content
                $('#loa-transport-modal .content-transport-detail').empty();
                
                if(info['rate'] != 0){
                    $('#loa-transport-modal .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">Rate</td><td class="p-2 whitespace-nowrap text-left">'+info['rate']+'</td></tr>');
                }
                if(info['loading'] != 0){
                    $('#loa-transport-modal .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">Loading</td><td class="p-2 whitespace-nowrap text-left">'+info['loading']+'</td></tr>');
                }
                if(info['multidrop'] != 0){
                    $('#loa-transport-modal .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">Multidrop</td><td class="p-2 whitespace-nowrap text-left">'+info['multidrop']+'</td></tr>');
                }

                let otherName = info['otherName'].toString().split(";");
                let otherRate = info['otherRate'].toString().split(";");

                for (let i = 0; i < otherName.length; i++) {
                    const name = otherName[i];
                    const rate = otherRate[i];

                    if(name != ""){
                        $('#loa-transport-modal .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">'+name+'</td><td class="p-2 whitespace-nowrap text-left">'+rate+'</td></tr>');
                    }                  
                }

                //Button HREF
                $('#loa-transport-modal .btn-goto-loa').attr('href',"/loa/action/transport/detail/"+loa['id']);
            },
            error : function(request, status, error){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: (JSON.parse(request.responseText)).message,
                })
            },
        });

        $('#loa-transport-modal .modal').removeClass('hidden');
    });
}
