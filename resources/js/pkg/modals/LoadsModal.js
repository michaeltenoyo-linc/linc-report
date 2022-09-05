import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const LoadsModal = () => {
    console.log("loading LoadsModal PKG JS");

    const getLoadList = async () => {
        $(document).on('click','#btn-detail-loads', async function(e){
            let posto = $(this).val();
            
            //Refresh Value
            $('#ticket-loads-modal .posto').html(posto);

            //Reset Table
            $('#ticket-loads-modal .container-table').empty();

            let table = "";
            table += '<table id="yajra-datatable-load-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-load-list">';
            table += '<thead>';
            table += '<tr>';
            table += '<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">';
            table += 'Load ID';
            table += '</th>';
            table += '<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">';
            table += 'DO';
            table += '</th>';
            table += '<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">';
            table += 'Booking Code';
            table += '</th>';
            table += '<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">';
            table += 'Pickup';
            table += '</th>';
            table += '<th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">';
            table += 'Action';
            table += '</th>';
            table += '</tr>';
            table += '</thead>';
            table += '<tbody>';
            table += '</tbody>';
            table += '</table>';

            $('#ticket-loads-modal .container-table').append(table);

            //Init Table
            $('#yajra-datatable-load-list').DataTable({
                processing: true,
                serverSide: false,
                ajax: "/pkg/ticket/read-loads/"+posto,
                columns: [
                  {data: 'load_id', name: 'load_id'},
                  {data: 'no_do', name: 'no_do'},
                  {data: 'booking_code', name: 'booking_code'},
                  {data: 'pickup', name: 'pickup'},
                  {data: 'action', name: 'action'},
                ],
            });

            //Show Modal
            $('#ticket-loads-modal .modal').removeClass('hidden');
        });
    }

    const onDeleteLoad = async () => {
        $(document).on('submit','#btn-load-delete', async function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Data load akan dihapus secara permanen!",
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
                        url: '/pkg/ticket/delete-load',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data Load sudah dihapus.',
                                icon: 'success'
                            }).then(function(){
                                var table = $('#yajra-datatable-load-list').DataTable();
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
    }

    getLoadList();
    onDeleteLoad();
};
