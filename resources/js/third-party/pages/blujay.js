import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const blujay = async () => {
    console.log("loading blujay JS");

    const onRefresh = async () => {
        $('#btn-blujay-refresh').on('click', async function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This process will take a while.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Database Refreshed!',
                        'Blujay DB has been updated',
                        'success'
                    )
                }
            });
        })
    }

    onRefresh();
}
