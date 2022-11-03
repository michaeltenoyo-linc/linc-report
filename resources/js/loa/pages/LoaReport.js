import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const LoaReport = () => {

    const inputValue = async () => {
        console.log("loading LoaReport JS");
        let division = $('#input-division').val();
        let showArchive = $('#archive-checkbox').is(":checked");

        const data = await $.get('/loa/data/getLoaCustomer/' + division + '/' + showArchive);

        $('#input-customer').empty();
        $('#input-customer').append('<option value="all">==Semua==</option>');
        data['customer'].forEach(customer => {
            $('#input-customer').append('<option value="' + customer['reference'] + '">' + customer['name'] + '</option>');
        });
    }

    const onChangeFilter = () => {
        $('#input-division').on('change', async function (e) {
            e.preventDefault();
            inputValue();
        });

        $('#archive-checkbox').on('change', async function (e) {
            e.preventDefault();
            inputValue();
        });
    }

    inputValue();
    onChangeFilter();
};