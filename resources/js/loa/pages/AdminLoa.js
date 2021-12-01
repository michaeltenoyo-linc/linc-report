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

    const onDeleteOtherRate = () => {
        $(document).on('click', '#btn-delete-other-rate', function(e){
            e.preventDefault();

            let idOtherRate = $(this).val();
            $('#form-loa-new .input-other-'+idOtherRate).remove();
        });
    }

    const saveLoa = () =>{
        $('#form-loa-new').on('submit', function(e){
            e.preventDefault();
            console.log("Saving new LOA...");

            let division = $('#form-loa-new .input-division').val();

            if(division == "warehouse"){
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

    getLoaWarehouse();
    onDeleteOtherRate();
    onAddOtherRateLoa();
    onChangeLoaDivision();
    saveLoa();
};
