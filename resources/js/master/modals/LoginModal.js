import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

export const LoginModal = () => {
    console.log("loading LoginModalJS");

    const onClickLogin = () => {
        $('#nav-login a').click(function(e){
            e.preventDefault();

            $('#master-login-modal .modal').removeClass('hidden');
        });
    }

    onClickLogin();
}


