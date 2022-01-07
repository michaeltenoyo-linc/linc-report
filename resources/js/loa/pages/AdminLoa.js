import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const AdminLoa = () => {
    console.log("loading adminLoa JS");

    const onAddOtherRateLoa = () => {
        $('#form-loa-new .btn-tambahan').on('click', function(e){
            e.preventDefault();

            let ctrOtherName = parseInt($('#form-loa-new .ctrOtherName').val());
            let ctrOtherRate = parseInt($('#form-loa-new .ctrOtherRate').val());
            let ctrOtherUom = parseInt($('#form-loa-new .ctrOtherUomWarehouse').val());

            let htmlOtherName = '<div class="inline-block w-5/12 lg:w-5/12 px-4 mb-6" >'
                                +'<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"'
                                +'htmlFor="grid-password"> Nama Biaya </label>'
                                +'<input type="text"'
                                +'name="other_name['+ctrOtherName+']"'
                                +'class="input-other-name-'+ctrOtherName+' border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "'
                                +'value=""/>'
                                +'</div>';

            let htmlOtherRate = '<div class="inline-block w-3/12 lg:w-4/12 px-4 mb-6" >'
                                +'<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"'
                                +'htmlFor="grid-password"> Biaya </label>'
                                +'<input type="text"'
                                +'name="other_rate['+ctrOtherRate+']"'
                                +'class="input-other-rate-'+ctrOtherRate+' border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "'
                                +'value=""/>'
                                +'</div>';

            let htmlOtherUom = '<div class="inline-block w-full lg:w-2/12 px-4 mb-6" >'
                                +'<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"'
                                +'htmlFor="grid-password"> UoM </label>'
                                +'<input type="text"'
                                +'name="uom['+ctrOtherUom+']"'
                                +'class="input-other-uom-'+ctrOtherUom+' border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "'
                                +'value="" list="uom"/>'
                                +'</div>';

            let htmlOtherDelete = '<div class="inline-block w-full lg:w-1/12 px-4 mb-6" >'
                                +'<button type="button"'
                                +'id="btn-delete-other-rate" name="other_delete['+ctrOtherName+']"'
                                +'class="input-other-delete-'+ctrOtherName+' bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded full"'
                                +'value='+ctrOtherName+'>X</button>'
                                +'</div>';

            let newInputOther = "<div class='input-other-"+ctrOtherName+"'>"+htmlOtherName+htmlOtherRate+htmlOtherUom+htmlOtherDelete+"</div>"

            ctrOtherName += 1;
            ctrOtherRate += 1;
            ctrOtherUom += 1;

            $('#form-loa-new .ctrOtherName').val(ctrOtherName);
            $('#form-loa-new .ctrOtherRate').val(ctrOtherRate);
            $('#form-loa-new .ctrOtherUomWarehouse').val(ctrOtherUom);

            $('#form-loa-new .other-rate-container').append(newInputOther);
        });
    }

    const onAddOtherRateDloaTransport = () => {
        $('#form-dloa-transport .btn-tambahan').on('click', function(e){
            e.preventDefault();

            let ctrOtherName = parseInt($('#form-dloa-transport .ctrOtherName').val());
            let ctrOtherRate = parseInt($('#form-dloa-transport .ctrOtherRate').val());

            let htmlOtherName = '<div class="inline-block w-5/12 lg:w-5/12 px-4 mb-6" >'
                                +'<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"'
                                +'htmlFor="grid-password"> Nama Biaya </label>'
                                +'<input type="text"'
                                +'name="other_name['+ctrOtherName+']"'
                                +'class="input-other-name-'+ctrOtherName+' border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "'
                                +'value=""/>'
                                +'</div>';

            let htmlOtherRate = '<div class="inline-block w-3/12 lg:w-5/12 px-4 mb-6" >'
                                +'<label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"'
                                +'htmlFor="grid-password"> Biaya </label>'
                                +'<input type="number"'
                                +'name="other_rate['+ctrOtherRate+']"'
                                +'class="input-other-rate-'+ctrOtherRate+' border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "'
                                +'value="0" min="0"/>'
                                +'</div>';

            let htmlOtherDelete = '<div class="inline-block w-full lg:w-1/12 px-4 mb-6" >'
                                +'<button type="button"'
                                +'id="btn-delete-other-rate" name="other_delete['+ctrOtherName+']"'
                                +'class="input-other-delete-'+ctrOtherName+' bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded full"'
                                +'value='+ctrOtherName+'>X</button>'
                                +'</div>';

            let newInputOther = "<div class='input-other-"+ctrOtherName+"'>"+htmlOtherName+htmlOtherRate+htmlOtherDelete+"</div>"

            ctrOtherName += 1;
            ctrOtherRate += 1;

            $('#form-dloa-transport .ctrOtherName').val(ctrOtherName);
            $('#form-dloa-transport .ctrOtherRate').val(ctrOtherRate);

            $('#form-dloa-transport .other-rate-container-transport').append(newInputOther);
        });
    }

    const onDeleteOtherRate = () => {
        $(document).on('click', '#btn-delete-other-rate', function(e){
            e.preventDefault();

            let idOtherRate = $(this).val();
            $('#form-loa-new .input-other-'+idOtherRate).remove();
        });
    }

    const onDeleteOtherRateDloaTransport = () => {
        $(document).on('click', '#btn-delete-other-rate', function(e){
            e.preventDefault();

            let idOtherRate = $(this).val();
            $('#form-dloa-transport .input-other-'+idOtherRate).remove();
        });
    }

    const saveLoa = () =>{
        $('#form-loa-new').on('submit', function(e){
            e.preventDefault();
            console.log("Saving new LOA...");

            let division = $('#form-loa-new .input-division').val();

            if(division == "warehouse"){
                console.log(division);
                let pdf = $('#form-loa-new .input-file-pdf').val();
                console.log(pdf);

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
                            url: '/loa/action/warehouse/insert',
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            data: new FormData($('#form-loa-new')[0]),
                            success: (data) => {
                                Swal.fire({
                                    title: 'Tersimpan!',
                                    text: 'Data surat jalan sudah disimpan.',
                                    icon: 'success'
                                }).then(function(){
                                    location.reload();
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
                  })
            }else if(division == "transport"){
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
                            url: '/loa/action/transport/insert',
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            data: new FormData($('#form-loa-new')[0]),
                            success: (response) => {
                                Swal.fire({
                                    title: 'Tersimpan!',
                                    text: 'Data surat jalan sudah disimpan.',
                                    icon: 'success'
                                }).then(function(){
                                    console.log(response)
                                    location.replace('/loa/action/transport/detail/'+response['id']);
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
                })
            }

        });
    }

    const onChangeLoaDivision = () => {
        $('#form-loa-new .input-divisi').on('change',function(e){
            e.preventDefault();
            var division = $(this).val();

            if(division == "exim" || division == "transport"){
                $('#form-loa-new .transport-exim').removeClass("hidden");
                $('#form-loa-new .warehouse').addClass("hidden");
                $('#form-loa-new .bulk').addClass("hidden");
            }else if(division == "warehouse"){
                $('#form-loa-new .transport-exim').addClass("hidden");
                $('#form-loa-new .warehouse').removeClass("hidden");
                $('#form-loa-new .bulk').addClass("hidden");
            }else if(division == "bulk"){
                $('#form-loa-new .transport-exim').addClass("hidden");
                $('#form-loa-new .warehouse').addClass("hidden");
                $('#form-loa-new .bulk').removeClass("hidden");
            }
        });
    }

    const getLoaWarehouse = () => {
        $('#yajra-datatable-warehouse-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/loa/action/warehouse/read',
            columns: [
                {data: 'no', name: 'TMS ID'},
                {data: 'customer', name: 'Closed Data'},
                {data: 'lokasi', name: 'Last Drop Location City'},
                {data: 'periode', name: 'Billable Total Rate'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        })
    }

    const getLoaTransport = () => {
        $('#yajra-datatable-transport-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/loa/action/transport/read',
            columns: [
                {data: 'no', name: 'TMS ID'},
                {data: 'customer', name: 'Closed Data'},
                {data: 'periode', name: 'Billable Total Rate'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        })
    }

    const getTransportDetail = () => {
        $('#yajra-datatable-dtransport-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/loa/action/transport/get-routes/'+$('#id_loa').val(),
            columns: [
                {data: 'unit', name: 'TMS ID'},
                {data: 'rute_start', name: 'TMS ID'},
                {data: 'rute_end', name: 'Closed Data'},
                {data: 'rate', name: 'Billable Total Rate'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        })
    }

    const filesNavigation = () => {
        $(document).on('click','.btn-nav-files', function(e){
            e.preventDefault();

            console.log("Files navigation clicked!");
            let idFiles = $(this).val();

            $('.files').addClass('hidden');
            $('.files-'+idFiles).removeClass('hidden');
        });
    }

    const searchTransport = () => {
        $('#form-search-transport').on('submit', function(e){
            e.preventDefault();

            console.log("Searching Area...");

            //AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'JSON',
            });
            $.ajax({
                url: '/loa/action/transport/search-routes',
                type: 'POST',
                data: new FormData($(this)[0]),
                success: (data) => {
                    console.log(data);
                    let start = data['start'];
                    let end = data['end'];
                    let startIs = data['startIs'];
                    let endIs = data['endIs'];

                    //START INFORMATION
                    $('#container-route-start').empty();

                    if(startIs == "prov"){
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> <b>"+start[0]+"</b></div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+start[1].length+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+start[2].length+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+start[3].length+"</div>");
                    }else if(startIs == "kota"){
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+start[0]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> <b>"+start[1]+"</b></div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+start[2].length+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+start[3].length+"</div>");
                    }else if(startIs == "kec"){
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+start[0]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+start[1]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> <b>"+start[2]+"</b></div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+start[3].length+"</div>");
                    }else{
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+start[0]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+start[1]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+start[2]+"</div>");
                        $('#container-route-start').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> <b>"+start[3]+"</b></div>");
                    }

                    //END INFORMATION
                    $('#container-route-end').empty();

                    if(endIs == "prov"){
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> <b>"+end[0]+"</b></div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+end[1].length+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+end[2].length+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+end[3].length+"</div>");
                    }else if(endIs == "kota"){
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+end[0]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> <b>"+end[1]+"</b></div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+end[2].length+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+end[3].length+"</div>");
                    }else if(endIs == "kec"){
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+end[0]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+end[1]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> <b>"+end[2]+"</b></div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> "+end[3].length+"</div>");
                    }else{
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-red-600 rounded-md'>Provinsi</span> "+end[0]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-orange-600 rounded-md'>Kota</span> "+end[1]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-green-600 rounded-md'>Kecamatan</span> "+end[2]+"</div>");
                        $('#container-route-end').append("<div class='mb-2'><span class='text-white text-xs p-1 m-1 bg-blue-600 rounded-md'>Kelurahan</span> <b>"+end[3]+"</b></div>");
                    }

                    //SHOW DLOA LIST
                    $('#content-dloa-list').empty();

                    var idListed = [];
                    data['listDloa'].forEach(e => {
                        let notListed = true;
                        idListed.forEach(idl => {
                            if (e['id'] == idl){
                                notListed = false;
                            }
                        });

                        if(notListed){
                            let col1 = "<td class='p-2 whitespace-nowrap text-left'>"+e['id'].toString().toUpperCase()+"</td>";
                            let col1a = "<td class='p-2 whitespace-nowrap text-left'>"+e['customer'].toString().toUpperCase()+"</td>";
                            let col2 = "<td class='p-2 whitespace-nowrap text-left'>"+e['rute_start'].toString().toUpperCase()+"</td>";
                            let col3 = "<td class='p-2 whitespace-nowrap text-left'>"+e['rute_end'].toString().toUpperCase()+"</td>";
                            let col4 = "<td class='p-2 whitespace-nowrap text-left'>"+e['unit'].toString().toUpperCase()+"</td>";
                            let col5 = "<td class='p-2 whitespace-nowrap text-left'>"+"<button value='"+e['id']+"' id='transport-open-detail' class='bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded'>Detail</button>"+"</td>";

                            $('#content-dloa-list').append("<tr>"+col1+col1a+col2+col3+col4+col5+"</tr>");
                            idListed.push(e['id']);
                        }
                    });
                }
            });
        });
    }

    const DependentDropdown = () => {
        function onChangeSelect(url, name) {
            // send ajax request to get the cities of the selected province and append to the select tag
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#' + name).empty();
                    $('#' + name).append('<option>==Pilih Salah Satu==</option>');
    
                    $.each(data, function (key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function () {
            $('#provinsi1').on('change', function () {
                console.log($(this).val());
                onChangeSelect('/cities/'+$(this).val(), 'kota1');
            });
            $('#provinsi2').on('change', function () {
                console.log($(this).val());
                onChangeSelect('/cities/'+$(this).val(), 'kota2');
            });
        });
    }

    getTransportDetail();
    DependentDropdown();
    searchTransport();
    filesNavigation();
    getLoaWarehouse();
    onDeleteOtherRate();
    onDeleteOtherRateDloaTransport();
    onAddOtherRateDloaTransport();
    getLoaTransport();
    onAddOtherRateLoa();
    onChangeLoaDivision();
    saveLoa();
};
