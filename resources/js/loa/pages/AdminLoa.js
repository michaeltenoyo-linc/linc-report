import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const inputLoa = () => {
        $('#form-loa-new').on('submit', function (e) {
            e.preventDefault();
            console.log("Saving new LOA...");

            //AJAX Save
            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan data sudah benar semua!",
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
                        url: '/loa/data/insert',
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: new FormData($('#form-loa-new')[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data surat jalan sudah disimpan.',
                                icon: 'success'
                            }).then(function () {
                                location.reload();
                            });
                        },
                        error: function (request, status, error) {
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

    const inputOtherRate = () => {
        //ADD OTHER RATE
        $('.btn-add-rate').on('click', async function (e) {
            e.preventDefault();
            let counter = parseInt($('#counter-rates').val());
            counter += 1;

            let rowCost = '';
            rowCost += '<div class="loa-other-rate-' + counter + '">';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Cost Name</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="rate_name[' + counter + ']"';
            rowCost += 'class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-3/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Rate</label>';
            rowCost += '<input type="number"';
            rowCost += 'name="rate[' + counter + ']"';
            rowCost += 'class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="0"';
            rowCost += 'required/>';
            rowCost += '</div> / ';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">QTY</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="qty[' + counter + ']"';
            rowCost += 'class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="PP"';
            rowCost += 'required/>';
            rowCost += '</div> / ';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Duration</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="duration[' + counter + ']"';
            rowCost += 'class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="Month"';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += '<div class="inline-block relative ml-2 w-1/12">';
            rowCost += '<button class="btn-delete-rate text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="' + counter + '">';
            rowCost += '<i class="fas fa-trash"></i>';
            rowCost += '</button>';
            rowCost += '</div>';
            rowCost += '</div>';

            $('#container-loa-rates').append(rowCost);
            $('#counter-rates').val(counter);
        });

        //DELETE OTHER RATE
        $(document).on('click', '.btn-delete-rate', async function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            $('.loa-other-rate-' + id).remove();
        });
    }

    const getLoa = () => {
        let type = $('#loa_type_raw').val();
        console.log(type);
        $('#yajra-datatable-loa-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/loa/data/read/' + type,
            columns: [
                { data: 'reference', name: 'reference' },
                { data: 'name', name: 'name' },
                { data: 'last_period', name: 'last_period' },
                { data: 'count', name: 'count' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    }

    inputLoa();
    inputOtherRate();
    getLoa();
};
