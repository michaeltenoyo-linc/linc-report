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
                url: '/lautanluas/load/check-bluejay',
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
                            url: '/lautanluas/load/bluejay-table',
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

    const previewReportLtl1 = () => {
        $('#yajra-datatable-report-preview-ltl-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/lautanluas/report/get-preview',
            columns: [
                {data: 'No', name: 'TMS ID'},
                {data: 'Load ID', name: 'Closed Data'},
                {data: 'No SO', name: 'Last Drop Location City'},
                {data: 'No DO', name: 'Billable Total Rate'},
                {data: 'Delivery Date', name: 'Load Status'},
                {data: 'No Polisi', name: 'Load Status'},
                {data: 'Customer Name', name: 'Load Status'},
                {data: 'Customer Address', name: 'Load Status'},
                {data: 'City', name: 'Load Status'},
                {data: 'Qty', name: 'Load Status'},
                {data: 'Transport Rate', name: 'Load Status'},
                {data: 'Unloading Cost', name: 'Load Status'},
                {data: 'Multidrop', name: 'Load Status'},
                {data: 'Total', name: 'Load Status'},
                {data: 'Rate / Kg', name: 'Load Status'},
                {data: 'Invoice To LTL', name: 'Load Status'},
                {data: 'Remarks', name: 'Load Status'},
            ]
        })
    }

    const previewWarningLtl1 = () => {
        $('#yajra-datatable-warning-preview-ltl-1').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/lautanluas/report/get-warning',
            columns: [
                {data: 'Load ID', name: 'Load ID'},
                {data: 'Customer Pick Location', name: 'Customer Pick Location'},
                {data: 'Suggestion', name: 'Suggestion'},
            ]
        })
    }

    
    previewReportLtl1();
    previewWarningLtl1();
    onUploadBluejay();
};
