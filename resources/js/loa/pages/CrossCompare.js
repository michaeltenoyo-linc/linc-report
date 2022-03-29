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
