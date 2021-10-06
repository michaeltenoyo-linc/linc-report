import Snackbar from 'node-snackbar';
import { RequestResetPassword } from './pages/RequestResetPassword';
import { ResetPassword } from './pages/ResetPassword';

const load= () => {
    $(document).ajaxComplete(async function(event, res, options) {
        Snackbar.show({
            text: res.responseJSON.message,
            actionText: 'Tutup',
            duration: 2000,
            pos: 'bottom-center',
        });
    });

    RequestResetPassword();
    ResetPassword();
};

load();

