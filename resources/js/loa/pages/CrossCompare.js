import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const CrossCompareLoa = () => {
    console.log("loading CrossCompareLoa JS");

    const dynamicInputField = () => {
        $('#form-cross-compare .customer').on('focusout', function(e) {
            console.log($(this).val());
        });

        $('form-cross-compare .unit').on('select', function(e) {
            console.log($(this).val());
        })

        $('#form-cross-compare .route_start').on('select', function(e) {
            console.log($(this).val());
        })
    }

    dynamicInputField();
};
