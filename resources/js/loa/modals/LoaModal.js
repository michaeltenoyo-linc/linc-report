import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';
import { refreshFileList } from '../pages/LoaDetail';

export const LoaModal = () => {
    console.log("loading LoaModal JS");

    function hideTimelineNumber() {
        $('.timeline-number').addClass("hidden");
    }

    function showTimelineNumber() {
        $('.timeline-number').removeClass("hidden");
    }

    const CreateContract = () => {
        $(document).on('click', '.btn-add-file', function (e) {
            e.preventDefault();
            let customerReference = $('#customer_reference').html();
            let customerName = $('#customer_name').html();
            let groupName = $('#selected-timeline').val();
            let LoaName = $('#file-group-name').html();

            let selectedLoa = $('#selected-loa-id').val();

            $('#loa-add-file .customer-reference').html(customerReference);
            $('#loa-add-file .customer-name').html(customerName);
            $('#loa-add-file .selected-timeline').html(groupName);
            $('#loa-add-file .selected-loa').html(LoaName);
            $('#loa-add-file .selected-id-loa').val(selectedLoa);



            hideTimelineNumber();
            $('#loa-add-file .modal').removeClass('hidden');
        });

        $('#form-loa-file').on('submit', async function (e) {
            e.preventDefault();

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
                        url: '/loa/data/insertFile',
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: new FormData($(this)[0]),
                        success: (data) => {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'File LOA sudah disimpan.',
                                icon: 'success'
                            }).then(function () {
                                $('#form-loa-file input').val("");

                                refreshFileList();
                                showTimelineNumber();
                                $('#loa-add-file .modal').addClass('hidden');
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

    const AddFixedRental = () => {
        $('#btn-add-rental').on('click', (e) => {
            e.preventDefault();
            $('#loa-fixed-rental .modal').removeClass('hidden');
        });
    }

    CreateContract();
    AddFixedRental();
};
