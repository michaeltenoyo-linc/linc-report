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
                url: '/greenfields/load/check-bluejay',
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
                            url: '/greenfields/load/bluejay-table',
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
                            {data: 'Customer ID', name: 'Customer ID'},
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

    const previewReportGreenfields1 = () => {
        $('#yajra-datatable-report-preview-greenfields-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/greenfields/report/get-preview',
            columns: [
                {data: 'No', name: 'TMS ID'},
                {data: 'Order Date', name: 'Closed Data'},
                {data: 'No Order', name: 'Last Drop Location City'},
                {data: 'Area', name: 'Billable Total Rate'},
                {data: 'Quantity', name: 'Load Status'},
                {data: 'Pol. No', name: 'Load Status'},
                {data: 'Truck Type', name: 'Load Status'},
                {data: 'Destination', name: 'Load Status'},
                {data: 'Rate', name: 'Load Status'},
                {data: 'Other', name: 'Load Status'},
                {data: 'Multi Drop', name: 'Load Status'},
                {data: 'Un-Loading', name: 'Load Status'},
                {data: 'Total Invoices', name: 'Load Status'},
                {data: 'REMARKS', name: 'Load Status'},
            ]
        })
    }

    const previewWarningGreenfields1 = () => {
        $('#yajra-datatable-warning-preview-greenfields-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/greenfields/report/get-warning',
            columns: [
                {data: 'Load ID', name: 'Load ID'},
                {data: 'Customer Pick Location', name: 'Customer Pick Location'},
                {data: 'Suggestion', name: 'Suggestion'},
            ]
        })
    }

    
    previewReportGreenfields1();
    previewWarningGreenfields1();
    onUploadBluejay();
};
