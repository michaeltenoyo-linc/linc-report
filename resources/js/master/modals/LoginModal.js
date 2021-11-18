import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';

export const LoginModal = () => {
    console.log("loading LoginModalJS");

    const onClickLogin = () => {
        $('#nav-login a').click(function(e){
            e.preventDefault();

            $('#master-login-modal .modal').removeClass('hidden');
        });

        $('#loginModal .form-master-login').on('submit', function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'JSON',
            });
            $.ajax({
                url: '/user/authenticate',
                type: 'POST',
                data: new FormData($(this)[0]),
                success: (data) => {
                    location.reload();
                },
                error : function(request, status, error){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login!',
                        text: "Mohon cek kembali data login.",
                    })
                },
            });
        });
    }

    onClickLogin();
}


