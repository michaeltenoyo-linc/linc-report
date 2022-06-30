import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const LoaModal = () => {
    console.log("loading LoaModal JS");

    function hideTimelineNumber(){
        $('.timeline-number').addClass("hidden");
    }

    const CreateContract = () => {
        $(document).on('click', '.btn-add-file', function (e){
            e.preventDefault();
            let customer = $('#customer_reference').html();
            let selectedGroup = $('#selected-timeline').val();
            let selectedLoa = $('#selected-loa-id').val();

            console.log(customer);
            console.log(selectedGroup);
            console.log(selectedLoa);

            hideTimelineNumber();
            $('#loa-add-file .modal').removeClass('hidden');
        });
    }

    CreateContract();
};
