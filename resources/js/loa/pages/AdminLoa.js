import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const inputBpTabs = () => {

    }

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

    const inputExcess = () => {
        //ADD OTHER RATE
        $('.btn-add-excess').on('click', async function (e) {
            e.preventDefault();
            let counter = parseInt($('#counter-excess').val());
            counter += 1;

            let rowCost = '';
            rowCost += '<div class="p-2 bg-blue-100 rounded-lg my-2 loa-other-excess-' + counter + '">';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Charges Name</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="excess_name[' + counter + ']"';
            rowCost += 'class="input-excess-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Vehicle Type</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="excess_type[' + counter + ']"';
            rowCost += 'class="input-excess-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-3/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Rate</label>';
            rowCost += '<input type="number"';
            rowCost += 'name="excess_rate[' + counter + ']"';
            rowCost += 'class="input-excess-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="0"';
            rowCost += 'required/>';
            rowCost += '</div> / ';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">UoM</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="excess_qty[' + counter + ']"';
            rowCost += 'class="input-excess-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="Trip"';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += '<div class="inline-block relative ml-2 w-1/12">';
            rowCost += '<button class="btn-delete-excess text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="' + counter + '">';
            rowCost += '<i class="fas fa-trash"></i>';
            rowCost += '</button>';
            rowCost += '</div>';
            rowCost += '<div class="relative w-11/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Terms & Condition</label>';
            rowCost += '<textarea rows="1" name="excess_terms[' + counter + ']" class="input-excess-terms border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="">Tidak ada</textarea>';
            rowCost += '</div>';
            rowCost += '</div>';

            $('#container-loa-excess').append(rowCost);
            $('#counter-excess').val(counter);
        });

        //DELETE OTHER RATE
        $(document).on('click', '.btn-delete-excess', async function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            $('.loa-other-excess-' + id).remove();
        });
    }

    const inputRental = () => {
        //ADD OTHER RATE
        $('.btn-add-rental').on('click', async function (e) {
            e.preventDefault();
            let counter = parseInt($('#counter-rental').val());
            counter += 1;

            let rowCost = '';
            rowCost += '<div class="p-2 bg-blue-100 rounded-lg my-2 loa-other-rental-' + counter + '">';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Site</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="rental_site[' + counter + ']"';
            rowCost += 'class="input-rental-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Vehicle Type</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="rental_type[' + counter + ']"';
            rowCost += 'class="input-rental-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-3/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Rental Charge</label>';
            rowCost += '<input type="number"';
            rowCost += 'name="rental_rate[' + counter + ']"';
            rowCost += 'class="input-rental-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="0"';
            rowCost += 'required/>';
            rowCost += '</div> / ';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">UoM</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="rental_qty[' + counter + ']"';
            rowCost += 'class="input-rental-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value="Month"';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += '<div class="inline-block relative ml-2 w-1/12">';
            rowCost += '<button class="btn-delete-rental text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="' + counter + '">';
            rowCost += '<i class="fas fa-trash"></i>';
            rowCost += '</button>';
            rowCost += '</div>';
            rowCost += '<div class="relative w-11/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Terms & Condition</label>';
            rowCost += '<textarea rows="1" name="rental_terms[' + counter + ']" class="input-rental-terms border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="">Tidak ada</textarea>';
            rowCost += '</div>';
            rowCost += '</div>';

            $('#container-loa-rental').append(rowCost);
            $('#counter-rental').val(counter);
        });

        //DELETE OTHER RATE
        $(document).on('click', '.btn-delete-rental', async function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            $('.loa-other-rental-' + id).remove();
        });
    }

    const inputRoutes = () => {
        //ADD OTHER RATE
        $('.btn-add-routes').on('click', async function (e) {
            e.preventDefault();
            let counter = parseInt($('#counter-routes').val());
            counter += 1;

            let rowCost = '';
            rowCost += '<div class="p-2 bg-blue-100 rounded-lg my-2 loa-other-routes-' + counter + '">';
            rowCost += '<div class="inline-block relative w-3/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Vehicle Type</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="routes_type[' + counter + ']"';
            rowCost += 'class="input-routes-type border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Origin</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="routes_origin[' + counter + ']"';
            rowCost += 'class="input-routes-origin border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div> - ';
            rowCost += '<div class="inline-block relative w-2/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Destination</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="routes_destination[' + counter + ']"';
            rowCost += 'class="input-routes-destination border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += ' <div class="inline-block relative w-3/12 mb-3">';
            rowCost += '<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"';
            rowCost += 'htmlFor="name">Rate</label>';
            rowCost += '<input type="text"';
            rowCost += 'name="routes_rate[' + counter + ']"';
            rowCost += 'class="input-routes-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"';
            rowCost += 'value=""';
            rowCost += 'required/>';
            rowCost += '</div>';
            rowCost += '<div class="inline-block relative ml-2 w-1/12">';
            rowCost += '<button class="btn-delete-routes text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="' + counter + '">';
            rowCost += '<i class="fas fa-trash"></i>';
            rowCost += '</button>';
            rowCost += '</div>';

            $('#container-loa-routes').append(rowCost);
            $('#counter-routes').val(counter);
        });

        //DELETE OTHER RATE
        $(document).on('click', '.btn-delete-routes', async function (e) {
            e.preventDefault();

            let id = $(this).attr('id');
            $('.loa-other-routes-' + id).remove();
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
    inputExcess();
    inputBpTabs();
    inputRoutes();
    inputRental();
};
