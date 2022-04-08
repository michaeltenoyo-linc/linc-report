import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';

export const TransportModal = () => {
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on('click', '#transport-local-detail', function(e){
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
            url: '/loa/action/transport/dloa-local/'+$(this).val(),
            type: 'GET',
            enctype: 'multipart/form-data',
            success: (data) => {
                console.log(data);
                let info = data['data'];
                let loa = data['loa'];
                
                //Location Information
                $('#loa-transport-modal-local .origin').html(loa['rute_start']);
                $('#loa-transport-modal-local .destination').html(loa['rute_end']);

                switch (loa['rute_start_cross_relation']) {
                    case "province":
                        $('#loa-transport-modal-local .origin_type').html('Prov.');
                        $('#loa-transport-modal-local .origin_type').addClass('bg-blue-700');
                        break;
                    case "regency":
                        $('#loa-transport-modal-local .origin_type').html('Kota');
                        $('#loa-transport-modal-local .origin_type').addClass('bg-green-700');
                        break;
                    case "district":
                        $('#loa-transport-modal-local .origin_type').html('Kec.');
                        $('#loa-transport-modal-local .origin_type').addClass('bg-orange-700');
                        break;
                    case "urban":
                        $('#loa-transport-modal-local .origin_type').html('Kel.');
                        $('#loa-transport-modal-local .origin_type').addClass('bg-red-700');
                        break;
                    default:
                        break;
                }

                switch (loa['rute_end_cross_relation']) {
                    case "province":
                        $('#loa-transport-modal-local .destination_type').html('Prov.');
                        $('#loa-transport-modal-local .destination_type').addClass('bg-blue-700');
                        break;
                    case "regency":
                        $('#loa-transport-modal-local .destination_type').html('Kota');
                        $('#loa-transport-modal-local .destination_type').addClass('bg-green-700');                        
                        break;
                    case "district":
                        $('#loa-transport-modal-local .destination_type').html('Kec.');
                        $('#loa-transport-modal-local .destination_type').addClass('bg-orange-700');
                        break;
                    case "urban":
                        $('#loa-transport-modal-local .destination_type').html('Kel.');
                        $('#loa-transport-modal-local .destination_type').addClass('bg-red-700');
                        break;
                    default:
                        break;
                }

                $('#loa-transport-modal-local .content-transport-detail').empty();
                $('#loa-transport-modal-local .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">Base Rate</td><td class="p-2 whitespace-nowrap text-left">Rp. '+loa['rate']+'</td></tr>');

                //Update table content
                /*
                $('#loa-transport-modal .content-transport-detail').empty();
                
                if(info['rate'] != 0){
                    $('#loa-transport-modal .content-transport-detail').append('<tr><td class="font-bold p-2 whitespace-nowrap text-left">Rate</td><td class="p-2 whitespace-nowrap text-left">'+info['rate']+'</td></tr>');
                }
                */

                /*
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
                */

                //Button HREF
                $('#loa-transport-modal-local .btn-goto-loa').attr('href',"/loa/action/transport/detail/"+loa['id']);
            },
            error : function(request, status, error){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: (JSON.parse(request.responseText)).message,
                })
            },
        });

        $('#loa-transport-modal-local .modal').removeClass('hidden');
    });
}
