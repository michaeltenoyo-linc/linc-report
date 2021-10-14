import Swal from 'sweetalert2';

export const AdminReport = () => {
    console.log("loading adminReport JS");

    const onUploadBluejay = () => {
        $('#form-report-generate .input-bluejay').on('input', function(e){
            e.preventDefault();

            let bluejayFile = $(this).val();
            console.log(bluejayFile);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'JSON',
            });
            $.ajax({
                url: '/load/check-bluejay',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: new FormData($('#form-report-generate')[0]),
                success: (data) => {
                    console.log(data);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Silahkan cek kembali isi file Bluejay pada tabel.',
                        icon: 'success'
                    })
                    $('#form-report-generate .input-bluejay').prop('disabled',true);
                    $('#form-report-generate .report-btn-preview').prop('disabled',false);
                    //Update Yajra Datatable
                    $('#yajra-datatable-loads-list').DataTable({
                        processing: true,
                        serverSide: false,
                        ajax: {
                            url: '/load/bluejay-table',
                            type: 'POST',
                                'headers' : {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                'enctype' : 'multipart/form-data',
                                'data' : new FormData($('#form-report-generate')[0])
                        },
                        columns: [
                            {data: 'TMS ID', name: 'TMS ID'},
                            {data: 'Created Date', name: 'Created Date'},
                            {data: 'Last Drop Location City', name: 'Last Drop Location City'},
                            {data: 'Billable Total Rate', name: 'Billable Total Rate'},
                            {data: 'Load Status', name: 'Load Status'},
                        ]
                    });

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

    const previewReportSmart1 = () => {
        $('#yajra-datatable-report-preview-smart-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/report/get-preview',
            columns: [
                {data: 'No', name: 'TMS ID'},
                {data: 'Load ID', name: 'Closed Data'},
                {data: 'Tgl Muat', name: 'Last Drop Location City'},
                {data: 'No SJ', name: 'Billable Total Rate'},
                {data: 'Penerima', name: 'Load Status'},
                {data: 'Kota Tujuan', name: 'Load Status'},
                {data: 'Kuantitas', name: 'Load Status'},
                {data: 'Berat', name: 'Load Status'},
                {data: 'Utilitas', name: 'Load Status'},
                {data: 'Nopol', name: 'Load Status'},
                {data: 'Tipe Kendaraan', name: 'Load Status'},
                {data: 'Kontainer', name: 'Load Status'},
                {data: 'Biaya Kirim', name: 'Load Status'},
                {data: 'Biaya Bongkar', name: 'Load Status'},
                {data: 'Overnight Charge', name: 'Load Status'},
                {data: 'Multidrop', name: 'Load Status'},
                {data: 'Total', name: 'Load Status'},
            ]
        })
    }

    const previewWarningSmart1 = () => {
        $('#yajra-datatable-warning-preview-smart-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/report/get-warning',
            columns: [
                {data: 'Load ID', name: 'Load ID'},
                {data: 'Suggestion', name: 'Suggestion'},
            ]
        })
    }

    const previewReportSmart2 = () => {
        $('#yajra-datatable-report-preview-smart-2').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/report/get-preview',
            columns: [
                {data: 'No', name: 'TMS ID'},
                {data: 'Tanggal', name: 'Closed Data'},
                {data: 'Customer', name: 'Last Drop Location City'},
                {data: 'Billable Method', name: 'Billable Total Rate'},
                {data: 'Customer Type', name: 'Load Status'},
                {data: 'Prodyct ID', name: 'Load Status'},
                {data: 'Origin', name: 'Load Status'},
                {data: 'Destination', name: 'Load Status'},
                {data: 'Penerima Barang', name: 'Load Status'},
                {data: 'Equipment Required', name: 'Load Status'},
                {data: 'No Order ID', name: 'Load Status'},
                {data: 'Carrier', name: 'Load Status'},
                {data: 'Nopol', name: 'Load Status'},
                {data: 'Driver', name: 'Load Status'},
                {data: 'NMK', name: 'Load Status'},
                {data: 'Load ID', name: 'Load Status'},
                {data: 'No. DO', name: 'Load Status'},
                {data: 'KODE SKU', name: 'Load Status'},
                {data: 'Description', name: 'Load Status'},
                {data: 'QTY', name: 'Load Status'},
                {data: 'Weight', name: 'Load Status'},
                {data: 'Tanggal SJ Balik', name: 'Load Status'},
                {data: 'Tanggal POD', name: 'Load Status'},
                {data: 'Note Retur', name: 'Load Status'},
                {data: 'Pengembalian Retur', name: 'Load Status'},
            ]
        })
    }

    const previewWarningSmart2 = () => {
        $('#yajra-datatable-warning-preview-smart-2').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/report/get-warning',
            columns: [
                {data: 'Load ID', name: 'Load ID'},
                {data: 'Suggestion', name: 'Suggestion'},
            ]
        })
    }

    const onChangeReportType = () => {
        $('#form-report-generate .input-report-type').change( function(e){
            e.preventDefault();

            var type = $(this).val();
            
            if(type == "smart_1"){
                $('#form-report-generate .requirement-reportSmart1').removeClass('hidden');
                $('#form-report-generate .preview-reportSmart1').removeClass('hidden');
                $('#form-report-generate .requirement-reportSmart2').addClass('hidden');
                $('#form-report-generate .preview-reportSmart2').addClass('hidden');
            }else if(type == "smart_2"){
                $('#form-report-generate .requirement-reportSmart1').addClass('hidden');
                $('#form-report-generate .preview-reportSmart1').addClass('hidden');
                $('#form-report-generate .requirement-reportSmart2').removeClass('hidden');
                $('#form-report-generate .preview-reportSmart2').removeClass('hidden');
            }

            return false;
        })
    }

    onChangeReportType();
    previewReportSmart1();
    previewReportSmart2();
    previewWarningSmart1();
    previewWarningSmart2();
    onUploadBluejay();
};
