import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';

export const Auth = () => {
    console.log("loading AuthJS");

    const onLogout = () => {
        $('.logout-btn').on('click', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Anda akan logout dari user ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, logout!'
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
                        url: '/user/logout',
                        type: 'POST',
                        success: (data) => {
                            location.reload();
                        },
                        error : function(request, status, error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Logout!',
                                text: "Kemungkinan anda sudah logout, coba refresh halaman ini.",
                            })
                        },
                    });
                }
            })


        });
    }

    onLogout();
}
