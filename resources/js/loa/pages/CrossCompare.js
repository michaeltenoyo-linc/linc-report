import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const CrossCompareLoa = () => {
    console.log("loading CrossCompareLoa JS");

    const dynamicInputField = async () => {
        $('#form-cross-compare .input-customer').on('focusout', async function(e) {
            let customer = $(this).val();

            let fetchLocal = await $.get('/loa/action/transport/local-info/'+customer+'/all/all/');
            
            //Reset Value
            $('#form-cross-compare .input-route-start').empty();
            $('#form-cross-compare .input-route-end').empty();
            $('#form-cross-compare .input-unit').empty();

            $('#form-cross-compare .input-route-start').append('<option value="-1">==Semua==</option>');
            $('#form-cross-compare .input-route-end').append('<option value="-1">==Semua==</option>');
            $('#form-cross-compare .input-unit').append('<option value="-1">==Semua==</option>');

            fetchLocal['route_start'].forEach(e => {
                $('#form-cross-compare .input-route-start').append('<option value="'+e+'">'+e+'</option>');
            });
        });

        $('#form-cross-compare .input-route-start').on('change', async function(e) {
            let route_start = $(this).val();

            let fetchLocal = await $.get('/loa/action/transport/local-info/'+$('#form-cross-compare .input-customer').val()+'/'+route_start+'/'+'all/');
            
            //Reset Value
            $('#form-cross-compare .input-route-end').empty();
            $('#form-cross-compare .input-unit').empty();

            $('#form-cross-compare .input-route-end').append('<option value="-1">==Semua==</option>');
            $('#form-cross-compare .input-unit').append('<option value="-1">==Semua==</option>');

            fetchLocal['route_end'].forEach(e => {
                $('#form-cross-compare .input-route-end').append('<option value="'+e+'">'+e+'</option>');
            });
        });

        $('#form-cross-compare .input-route-end').on('change', async function(e) {
            let route_end = $(this).val();

            let fetchLocal = await $.get('/loa/action/transport/local-info/'+$('#form-cross-compare .input-customer').val()+'/'+$('#form-cross-compare .input-route-start').val()+'/'+route_end+'/');
            
            //Reset Value
            $('#form-cross-compare .input-unit').empty();

            $('#form-cross-compare .input-unit').append('<option value="-1">==Semua==</option>');

            fetchLocal['unit'].forEach(e => {
                $('#form-cross-compare .input-unit').append('<option value="'+e+'">'+e+'</option>');
            });
        });
    }

    const findAndCompare = async () => {
        $('#form-cross-compare').on('submit', async function(e){
            e.preventDefault();
            console.log(e);

            let formInput = new FormData($('#form-cross-compare')[0]);

            $.ajax({
                url: '/loa/action/blujay/compare',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: formInput,
                success: (data) => {
                    console.log(data);

                    $('#content-crossfixing-diff').empty();

                    //Appending Values
                    for (let i = 0; i < data['warning_blujay'].length; i++) {
                        const blujay = data['warning_blujay'][i];
                        const local = data['warning_local'][i];

                        const row1 = '<td class="p-2 whitespace-nowrap text-left">'+blujay['id']+'</td>';
                        const row2 = '<td class="p-2 whitespace-nowrap text-left">'+blujay['origin_location']+'</td>';
                        const row3 = '<td class="p-2 whitespace-nowrap text-left">'+blujay['destination_location']+'</td>';
                        const row4 = '<td class="p-2 whitespace-nowrap text-left">'+blujay['sku']+'</td>';
                        const row5 = '<td class="p-2 whitespace-nowrap text-left">'+blujay['rate']+' / '+local['rate']+'</td>';
                        const row6 = '<td class="p-2 whitespace-nowrap text-left"><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Detail</button></td>';
                        $('#content-crossfixing-diff').append('<tr>'+row1+row2+row3+row4+row5+row6+'</tr>');                        
                    }
                },
                error : function(request, status, error){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: (JSON.parse(request.responseText)).message,
                    })
                },
            });
        });
    }

    dynamicInputField();
    findAndCompare();
};
