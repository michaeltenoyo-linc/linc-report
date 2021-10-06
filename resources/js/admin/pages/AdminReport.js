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
                            {data: 'Closed Date', name: 'Closed Data'},
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

    const previewReport = () => {
        $('#yajra-datatable-report-preview').DataTable({
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

    const previewWarning = () => {
        $('#yajra-datatable-warning-preview').DataTable({
            processing: true,
            serverSide: false,
            ajax: '/report/get-warning',
            columns: [
                {data: 'Load ID', name: 'Load ID'},
                {data: 'Suggestion', name: 'Suggestion'},
            ]
        })
    }

    previewReport();
    previewWarning();
    onUploadBluejay();
};
