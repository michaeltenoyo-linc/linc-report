import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const blujay = async () => {
    console.log("loading blujay JS");

    const onInjectSql = async () => {
        $(document).on('submit','#form-refresh-blujay', async function(e){
            e.preventDefault();
            console.log("INJECT SQL!");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'JSON',
            });

            Swal.fire({
                title: 'Are you sure?',
                text: "This will replace the last database raw data.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, lanjut!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $('#progress-percentage').html('30');
                    $('#progress-description').html('Crawling attachment data from gmail to server...');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                    });
                    $.ajax({
                        url: '/third-party/blujay/injectSql',
                        type: 'POST',
                        data: new FormData($('#form-refresh-blujay')[0]),
                        success: (data) => {
                            $('#inject-sql-button').attr('disabled', true);
                            $('#inject-sql-button').html('Done');
                            $('#inject-sql-button').removeClass('bg-teal-200 hover:bg-teal-300');
                            $('#inject-sql-button').addClass('bg-teal-300');
                            $('#progress-percentage').html('40');
                            $('#progress-description').html('Start injecting data to Database...');
                            $('#progress-blujay-injecting').removeClass('hidden');
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

    const onSeedingSql = async () => {
        $('#btn-blujay-seeder').on('click', async function(e){
            e.preventDefault();
            console.log("Seeding data to MYSQL");
        })
    }

    onInjectSql();
    onSeedingSql();
}
