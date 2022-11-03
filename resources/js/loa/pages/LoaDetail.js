import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';
import { split } from 'lodash';
import { data } from 'jquery';

const userPriviledge = $('#user-priviledge').val();

export const refreshTimeline = async () => {
    $('#timeline-list').empty();
    $('.viewer-container').addClass('hidden');
    //Reset Files
    $('#file-container').empty();
    $('#file-group-name').html("<< Choose a Context >>");
    const group = $('#selected-timeline').val();
    const customer = $('#customer_reference').html();
    const type = $('#loa_type_short').val();
    const showArchive = $('#loa-archive-checkbox').prop('checked');

    let timelines;

    if (group == 'Favorite') {
        timelines = await $.get('/loa/data/getPinnedGroup/' + type + '/' + customer);
    } else {
        timelines = await $.get('/loa/data/getTimelineByGroup/' + type + '/' + customer + '/' + group);
    }

    let ctr = 1;
    timelines['timeline'].forEach(row => {
        let activeColor = "bg-green-500 hover:bg-green-700";
        let activeIcon = "<i class='fas fa-check'></i>";

        let iconFavorite = '<i class="far fa-star"></i>';

        if (row['is_archived'] == 1) {
            activeColor = "bg-gray-500 hover:bg-gray-700";
            activeIcon = "<i class='fas fa-archive'></i>";
        }

        if (row['is_pinned'] == 1) {
            iconFavorite = '<i class="fas fa-star"></i>';
        }

        let rowDiv = '<div class="mb-12 flex justify-between items-center w-full">';
        rowDiv += '<div class="w-3/12 text-right">';
        rowDiv += '<b>' + row['effective'] + '</b>'
        rowDiv += '</div>';
        rowDiv += '<div class="timeline-number z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">';
        rowDiv += '<h1 class="mx-auto font-semibold text-lg text-white">' + ctr + '</h1>';
        rowDiv += '</div>';
        rowDiv += '<div id="' + row['id'] + '" name="' + row['name'] + '" class="timeline flex cursor-pointer order-1 bg-gray-400 hover:bg-gray-300 rounded-lg shadow-xl w-8/12 px-6 py-4">';
        rowDiv += '<div class="w-8/12">'
        rowDiv += '<h3 class="mb-3 font-bold text-gray-800 text-xl">' + row['name'] + '</h3>';
        rowDiv += '<p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">';
        rowDiv += '<div class="bg-red-600 text-white p-2 rounded-md w-1/2 text-sm">' + '<b class="text-white">Expired :</b> ' + row['expired'] + '</div>';
        rowDiv += '</p>';
        rowDiv += '</div>';
        rowDiv += '<div class="w-4/12 ml-5 grid grid-cols-2 gap-4">';
        rowDiv += '<div>' + '<button id="' + row['id'] + '" class="btn-archive-loa py-3 w-full rounded-full ' + activeColor + ' text-white">' + activeIcon + '</button>' + '</div>';
        rowDiv += '<div>' + '<button id="' + row['id'] + '" class="btn-pin-loa py-3 w-full rounded-full bg-orange-600 hover:bg-orange-700 text-white">' + iconFavorite + '</button>' + '</div>';
        if (userPriviledge == 'true') {
            rowDiv += '<div>' + '<button id="' + row['id'] + '" class="btn-edit-loa py-3 w-full rounded-full bg-yellow-500 hover:bg-yellow-700 text-white"><i class="far fa-edit"></i></button>' + '</div>';
            rowDiv += '<div>' + '<button id="' + row['id'] + '" class="btn-delete-loa py-3 w-full rounded-full bg-red-500 hover:bg-red-700 text-white"><i class="far fa-trash-alt"></i></button>' + '</div>';
        }
        rowDiv += '</div>';
        rowDiv += '</div>';
        rowDiv += '</div>';

        if (showArchive) {
            $('#timeline-list').append(rowDiv);
            ctr++;
        } else {
            if (row['is_archived'] == 0) {
                $('#timeline-list').append(rowDiv);
                ctr++;
            }
        }

    });
    $('.btn-delete-all-file').addClass('hidden');
    $('.btn-add-file').addClass('hidden');
    //Reset Tab Class
    $.each($('.tab-active'), function (index, e) {
        $(e).removeClass('tab-active');
        $(e).addClass('tab-inactive');
    });

    $.each($('.tab-inactive'), function (index, e) {
        if ($(e).html() == group) {
            $(e).removeClass('tab-inactive');
            $(e).addClass('tab-active');
        }
    });
}

export const refreshLoaRates = async () => {
    let loaId = $('#selected-loa-id').val();
    let type = $('#loa-type').val();
    const rates = await $.get('/loa/data/getRatesByLoa/' + loaId + '/' + type);

    if (type == 'cml') {
        $('.table-loa-rates-values').empty();

        rates['rates'].forEach(rate => {
            let rowId = rate['name'].replace(' ', '-');

            let row = '';
            row += '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
            row += '<input type="hidden" name="id_loa" id="id-loa" class="row-name-' + rowId + '" value="' + rate['id_loa'] + '">';
            row += '<th scope="row" id="name" class="row-name-' + rowId + ' py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
            row += rate['name'];
            row += '</th>';
            row += '<td contenteditable="false" id="cost" class="row-rate-' + rowId + ' py-4 px-6">';
            row += rate['cost'];
            row += '</td>';
            row += '<td contenteditable="false" id="qty" class="row-rate-' + rowId + ' py-4 px-6">';
            row += '' + rate['qty'];
            row += '</td>';
            row += '<td contenteditable="false" id="duration" class="row-rate-' + rowId + ' py-4 px-6">';
            row += '' + rate['duration'];
            row += '</td>';
            row += '<td>';
            if (userPriviledge == 'true') {
                row += '<button onEdit="false" id="' + rowId + '" class="btn-rate-edit bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">';
                row += '<i class="far fa-edit"></i>';
                row += '</button>';
                row += ' <button id="' + rowId + '" class="btn-rate-delete bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">';
                row += '<i class="fas fa-trash"></i>';
                row += '</button>';
            }
            row += '</td>';
            row += '</tr>';

            $('.table-loa-rates-values').append(row);
        });

        $('.table-loa-rates').removeClass('hidden');
    } else if (type == 'bp') {
        //RESET VALUE
        $('.content-rental').empty();
        $('.content-excess').empty();
        $('.content-routes').empty();

        var rentalCount = 0;
        var excessCount = 0;
        var routesCount = 0;

        //INPUT VALUE
        rates['rates'].forEach(rate => {
            let rateName = rate['name'].split('|');
            let rateType = rateName[0];
            if (rateType == 'rental') {
                rentalCount++;
            } else if (rateType == 'excess') {
                excessCount++;
            } else if (rateType == 'routes') {
                routesCount++;
            }
        });

        //VALIDATING DETAILS
        //FIXED RENTAL
        if (rentalCount == 0) {
            let row = '<div class="w-full text-center text-red-500 font-bold"> LOA ini tidak memiliki services fixed rental</div>';
            $('.content-rental').append(row);
        } else {
            let row = '<table id="yajra-datatable-bp-rental" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-rental"> <thead> <tr> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Site </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Vehicle Type </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Rental Charge </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> UoM </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Action </th> </tr> </thead> <tbody> </tbody> </table>';
            $('.content-rental').append(row);

            //SETUP DATATABLE
            $('#yajra-datatable-bp-rental').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: false,
                ajax: "/loa/data/get-bp-detail/rental/" + loaId,
                columns: [
                    { data: 'nameDetail', name: 'nameDetail' },
                    { data: 'type', name: 'type' },
                    { data: 'cost', name: 'cost' },
                    { data: 'uom', name: 'uom' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
            });
        }
        //EXCESS
        if (excessCount == 0) {
            let row = '<div class="w-full text-center text-red-500 font-bold"> LOA ini tidak memiliki services excess/variables</div>';
            $('.content-excess').append(row);
        } else {
            let row = '<table id="yajra-datatable-bp-excess" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-excess"> <thead> <tr> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Charges Name </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Vehicle Type </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Rate </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> UoM </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Action </th> </tr> </thead> <tbody> </tbody> </table>';
            $('.content-excess').append(row);

            //SETUP DATATABLE
            $('#yajra-datatable-bp-excess').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: false,
                ajax: "/loa/data/get-bp-detail/excess/" + loaId,
                columns: [
                    { data: 'nameDetail', name: 'nameDetail' },
                    { data: 'type', name: 'type' },
                    { data: 'cost', name: 'cost' },
                    { data: 'uom', name: 'uom' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
            });
        }
        //ON CALL
        if (routesCount == 0) {
            let row = '<div class="w-full text-center text-red-500 font-bold"> LOA ini tidak memiliki services on call routes</div>';
            $('.content-routes').append(row);
        } else {
            let row = '<table id="yajra-datatable-bp-routes" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-routes"> <thead> <tr> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Vehicle Type </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Routes </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Rate </th> <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"> Action </th> </tr> </thead> <tbody> </tbody> </table>';
            $('.content-routes').append(row);
            //SETUP DATATABLE
            $('#yajra-datatable-bp-routes').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: false,
                ajax: "/loa/data/get-bp-detail/routes/" + loaId,
                columns: [
                    { data: 'type', name: 'type' },
                    { data: 'nameDetail', name: 'nameDetail' },
                    { data: 'cost', name: 'cost' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
            });
        }

        $('.services-bp-tab').removeClass('hidden');
    }
}

export const refreshFileList = async () => {
    let loaId = $('#selected-loa-id').val();
    const files = await $.get('/loa/data/getFileByGroup/' + loaId);


    //reset
    $('.viewer-container').addClass('hidden');
    $('#file-container').empty();
    $('#file-period').html();
    //Set files div
    files.forEach(row => {
        let typeColor = "";
        switch (row['extension']) {
            case '.pdf':
                typeColor = 'bg-red-700 type-pdf';
                break;
            case '.xlsx':
                typeColor = 'bg-lime-700 type-xlsx';
                break;
            case '.docx':
                typeColor = 'bg-blue-700 type-docx';
                break;
            case '.jpg':
                typeColor = 'bg-orange-700 type-jpg';
                break;
            case '.msg':
                typeColor = 'bg-yellow-500 type-msg';
                break;
        }

        let filename = row['filename'].split('$');

        let rowDiv = '<li id="' + row['id'] + '" class="file-items flex cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">'
            + '<div class="w-full">' + '<button id="' + row['id'] + '" type="button" class="p-1 btn-delete-file bg-red-400 text-white hover:bg-red-500 rounded-full"><i class="far fa-trash-alt" style="font-size:15px"></i></button> ' + filename[2] + '<span class="text-xs ' + typeColor + ' text-white rounded p-1 ml-3">' + row['extension'].toUpperCase() + '</span></div>'
            + '</li>'


        $('.btn-delete-all-file').removeClass('hidden');
        $('.btn-add-file').removeClass('hidden');
        $('#file-container').append(rowDiv);
    });
}

export const LoaDetail = () => {
    console.log("loading LoaDetail JS");

    const init = async () => {
        const customer = $('#customer_reference').html();
        const type = $('#loa_type_short').val();

        //Group Tab
        $('#tab-container').empty();
        $('#file-container').empty();
        $('.btn-add-file').addClass('hidden');
        $('.btn-delete-all-file').addClass('hidden');
        const CustomerGroups = await $.get('/loa/data/getGroupByCustomer/' + type + '/' + customer);
        console.log(CustomerGroups);

        let firstGroup = true;
        CustomerGroups['groups'].forEach(row => {
            let status = "tab-inactive";
            if (firstGroup) {
                status = "tab-active";
                firstGroup = false;
                $('#selected-timeline').val(row);
            }

            let pinIcon = "";
            if (row == "Favorite") {
                pinIcon = "<i class='fas fa-map-pin font-2xl mr-2'></i>";
            }

            let rowDiv = "<li class='mr-2 tab-content'>"
                + pinIcon + " <a class='" + status + "'>" + row
                + "</a></li>";

            $('#tab-container').append(rowDiv);
        });

        //Timeline
        refreshTimeline();
    }

    const onChangeGroup = () => {
        $(document).on('click', '.tab-inactive', function (e) {
            e.preventDefault();
            const group = $(this).html();

            //Refresh Timeline
            $('#selected-timeline').val(group);
            refreshTimeline();
            //Reset Files
            $('#file-container').empty();
            $('#file-group-name').html("<< Choose a Context >>");
        });
    }

    const onClickContext = () => {
        $(document).on('click', '.timeline', async function (e) {
            e.preventDefault();
            const groupId = $(this).attr('id');
            $('#selected-loa-id').val(groupId);
            const groupName = $(this).attr('name');
            $('#file-group-name').html(groupName);

            refreshFileList();
            refreshLoaRates();
        });
    }

    const onClickFile = async () => {
        $(document).on('click', '.file-items', async function (e) {
            let id = $(this).attr('id');

            const fileData = await $.get('/loa/data/getFileById/' + id);

            $('.viewer-container').addClass('hidden');

            if (fileData['extension'] == '.pdf') {
                $('#pdf').removeClass('hidden');
                PDFObject.embed("/show-pdf/" + fileData['filename'] + '/' + fileData['content_path']['type'], "#pdf-viewer");
            } else if (fileData['extension'] == ".jpg") {
                $('#image').removeClass('hidden');
                $('#img-viewer').attr('src', "/show-png/" + fileData['filename'] + '/' + fileData['content_path']['type']);
            } else if (fileData['extension'] == ".xlsx") {
                $('#excel').removeClass('hidden');
                $('#excel').empty();

                const excel_content = await $.get("/show-excel-pages/" + fileData['filename'] + '/' + fileData['content_path']['type']);
                let ctrExcel = 1;
                excel_content['name'].forEach(row => {
                    console.log(row);
                    var left = (screen.width / 2) - (800 / 2);
                    let divRow = '<a id="open-excel" onclick="window.open(' + "'" + "/show-excel/" + fileData['filename'] + '/' + fileData['content_path']['type'] + "/" + (ctrExcel - 1) + "'" + ',' + "'" + "popup" + "'" + ',' + "'" + "width=800,height=800,top=20,left=" + left + "" + "'" + ')"><button class="mx-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"><span class="text-xs">Sheet ' + ctrExcel + '</span><br>' + row + '</button></a>';
                    $('#excel').append(divRow);
                    ctrExcel++;
                });
            } else if (fileData['extension'] == ".msg") {
                $('#msg').removeClass('hidden');
                $('#msg').empty();
                const filenameFormat = split(fileData['filename'], '$')[2];
                var left = (screen.width / 2) - (800 / 2);
                let divRow = '<a id="open-excel" onclick="window.open(' + "'" + "/show-msg/" + fileData['filename'] + '/' + fileData['content_path']['type'] + "'" + ',' + "'" + "popup" + "'" + ',' + "'" + "width=800,height=800,top=20,left=" + left + "" + "'" + ')"><button class="mx-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"><span class="text-xs">' + filenameFormat + '</span></button></a>';
                $('#msg').append(divRow);
            }

        })
    }

    const onClickDeleteLoa = async () => {
        $(document).on('click', '.btn-delete-loa', async function (e) {
            let id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Semua data beserta file akan dihapus!",
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
                        url: '/loa/data/deleteById/' + id,
                        type: 'GET',
                        enctype: 'multipart/form-data',
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data LOA berhasil dihapus.',
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
            });
        })
    }

    const onDeleteFile = async () => {
        $(document).on('click', '.btn-delete-file', async function (e) {
            let id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "File akan dihapus permanen!",
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
                        url: '/loa/data/deleteFileById/' + id,
                        type: 'GET',
                        enctype: 'multipart/form-data',
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'File berhasil dihapus.',
                                icon: 'success'
                            }).then(function () {
                                $('.viewer-container').addClass('hidden');
                                refreshFileList();
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
            });
        });
    }

    const onClickLoaActivation = async () => {
        $(document).on('click', '.btn-archive-loa', async function (e) {
            let id = $(this).attr('id');
            let fetch = await $.get('/loa/data/read/byId/' + id);
            let loa = fetch['loa'];

            if (loa['is_archived'] == 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan dinonaktifkan menjadi arsip.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Arsip!'
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
                            url: '/loa/data/activationById/' + id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Terarsip!',
                                    text: 'File berhasil diarsip.',
                                    icon: 'success'
                                }).then(function () {
                                    refreshTimeline();
                                    //Reset Files
                                    $('#file-container').empty();
                                    $('#file-group-name').html("<< Choose a Context >>");
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
                });
            } else if (loa['is_archived'] == 1) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan diaktifkan dari arsip.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Aktifkan!'
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
                            url: '/loa/data/activationById/' + id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Terarsip!',
                                    text: 'File berhasil diaktifkan.',
                                    icon: 'success'
                                }).then(function () {
                                    refreshTimeline();
                                    //Reset Files
                                    $('#file-container').empty();
                                    $('#file-group-name').html("<< Choose a Context >>");
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
                });
            }
        });
    }

    const onClickPin = async () => {
        $(document).on('click', '.btn-pin-loa', async function (e) {
            e.preventDefault();
            const id = $(this).attr('id');
            let fetch = await $.get('/loa/data/read/byId/' + id);
            let loa = fetch['loa'];

            if (loa['is_pinned'] == 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan diklasifikasikan sebagai LOA favorit.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Pin!'
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
                            url: '/loa/data/pinById/' + id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Pinned!',
                                    text: 'File berhasil dipin.',
                                    icon: 'success'
                                }).then(function () {
                                    init();
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
                });
            } else if (loa['is_pinned'] == 1) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan dikeluarkan dari LOA favorit.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Unpin!'
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
                            url: '/loa/data/pinById/' + id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Unpinned!',
                                    text: 'File berhasil diunpin.',
                                    icon: 'success'
                                }).then(function () {
                                    init();
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
                });
            }
        });
    }

    const onClickShowArchive = async () => {
        $(document).on('click', '#loa-archive-checkbox', async function (e) {
            refreshTimeline();
        })
    }

    const onEditRate = async () => {
        $(document).on('click', '.btn-rate-edit', async function (e) {
            e.preventDefault();

            let button = $(this);
            let onEdit = $(this).attr('onEdit');

            if (onEdit == 'false') {
                console.log("On Edit");
                //OnEdit
                $(this).attr('onEdit', true);
                //Row Editable
                let rowId = $(this).attr('id');
                console.log(rowId);
                $('.row-rate-' + rowId).attr('contenteditable', 'true');

                //Change Button Icon
                $(this).empty();
                $(this).append('<i class="fas fa-clipboard-check"></i>');
                $(this).removeClass('bg-yellow-500');
                $(this).removeClass('hover:bg-yellow-700');
                $(this).addClass('bg-green-500');
                $(this).addClass('hover:bg-green-700');
            } else {
                console.log("On Show");
                //OnShow
                //Row Not Editable
                let rowId = $(this).attr('id');


                //Save Edit Value
                let name = $('.row-name-' + rowId + '#name').html();
                let id = $('.row-name-' + rowId + '#id-loa').val();
                let cost = $('.row-rate-' + rowId + '#cost').html();
                let qty = $('.row-rate-' + rowId + '#qty').html();
                let duration = $('.row-rate-' + rowId + '#duration').html();

                const data = new FormData();
                data.append('name', name);
                data.append('cost', cost);
                data.append('qty', qty);
                data.append('duration', duration);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Data rate cost ini akan diubah!",
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
                            url: '/loa/data/editDetailByLoa/' + id,
                            type: 'POST',
                            data: data,
                            success: (data) => {
                                Swal.fire({
                                    title: 'Tersimpan!',
                                    text: 'Data Rate berhasil diubah.',
                                    icon: 'success'
                                }).then(function () {
                                    button.attr('onEdit', false);
                                    $('.row-rate-' + rowId).attr('contenteditable', 'false');
                                    //Change Button Icon
                                    button.empty();
                                    button.append('<i class="far fa-edit"></i>');
                                    button.removeClass('bg-green-500');
                                    button.removeClass('hover:bg-green-700');
                                    button.addClass('bg-yellow-500');
                                    button.addClass('hover:bg-yellow-700');
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
                });
            }
        });
    }

    const onDeleteRate = async () => {
        $(document).on('click', '.btn-rate-delete', async function (e) {
            e.preventDefault();
            let rowId = $(this).attr('id');


            //Save Edit Value
            let name = $('.row-name-' + rowId + '#name').html();
            let id = $('.row-name-' + rowId + '#id-loa').val();
            const data = new FormData();
            data.append('name', name);

            Swal.fire({
                title: 'Are you sure?',
                text: "Data rate cost ini akan dihapus!",
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
                        url: '/loa/data/deleteDetailByLoa/' + id,
                        type: 'POST',
                        data: data,
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data Rate berhasil diubah.',
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
                            });
                        },
                    });
                }
            });
        });
    }

    const onShowAddRate = async () => {
        $(document).on('click', '#btn-show-rate-form', async function (e) {
            e.preventDefault();

            let onAdd = $(this).attr('onAdd');
            console.log(onAdd);
            let button = $(this);
            let type = $('#loa-type').val();

            if (onAdd == 'true') {
                button.attr('onAdd', 'false');
                button.empty();
                button.append('Add Rate Cost');
                button.removeClass('bg-red-500');
                button.removeClass('hover:bg-red-700');
                button.addClass('bg-blue-500');
                button.addClass('hover:bg-blue-700');

                type == 'cml' ? $('#form-rate-detail').addClass('hidden') : $('#form-rate-bp').addClass('hidden');
            } else {
                button.attr('onAdd', 'true');
                button.empty();
                button.append('Cancel Add Rate');
                button.removeClass('bg-blue-500');
                button.removeClass('hover:bg-blue-700');
                button.addClass('bg-red-500');
                button.addClass('hover:bg-red-700');

                type == 'cml' ? $('#form-rate-detail').removeClass('hidden') : $('#form-rate-bp').removeClass('hidden');
            }
        });
    }

    const onAddRate = async () => {
        $('#form-rate-detail').on('submit', function (e) {
            e.preventDefault();
            console.log("Saving new Rate...");
            let loaId = $('#selected-loa-id').val();
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
                        url: '/loa/data/insertDetailByLoa/' + loaId,
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: new FormData($('#form-rate-detail')[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data rate sudah disimpan.',
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

    const saveRatesBp = async () => {
        $('#form-rate-bp').on('submit', async (e) => {
            e.preventDefault();

            console.log("Saving new Rate bp...");
            let loaId = $('#selected-loa-id').val();
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
                        url: '/loa/data/insertDetailByLoaBp/' + loaId,
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: new FormData($('#form-rate-bp')[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Data rate sudah disimpan.',
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
            });
        });
    }

    const onDeleteDetailBp = async () => {
        $(document).on('submit', '#btn-bp-detail-delete', function (e) {
            e.preventDefault();

            //AJAX Save
            Swal.fire({
                title: 'Are you sure?',
                text: "Detail LOA ini akan di hapus dari database!",
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
                        url: '/loa/data/deleteDetailByLoaBp',
                        type: 'POST',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Detail charges sudah di hapus.',
                                icon: 'success'
                            }).then(function () {
                                var table1 = $('#yajra-datatable-bp-rental').DataTable();
                                var table2 = $('#yajra-datatable-bp-excess').DataTable();
                                var table3 = $('#yajra-datatable-bp-routes').DataTable();
                                table1.ajax.reload(null, false);
                                table2.ajax.reload(null, false);
                                table3.ajax.reload(null, false);
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
            });
        });
    }

    init();
    onChangeGroup();
    onClickContext();
    onClickFile();
    onClickDeleteLoa();
    onDeleteFile();
    onClickLoaActivation();
    onClickPin();
    onClickShowArchive();
    onEditRate();
    onDeleteRate();
    onDeleteDetailBp();
    onShowAddRate();
    onAddRate();
    saveRatesBp();
};
