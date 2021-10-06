import { disableElement } from '../../utilities/helpers';

export const RequestResetPassword= () => {
    disableElement('#request-reset-password-form button[type="submit"]', true);

    $('#request-reset-password-form input').on('input', function() {
        let isEmpty= true;

        $('#request-reset-password-form input').each(function() {
            isEmpty= $(this).val() === '';
        });

        if (isEmpty) {
            disableElement('#request-reset-password-form button[type="submit"]', true);
        } else {
            disableElement('#request-reset-password-form button[type="submit"]', false);
        }
    });
    $('#request-reset-password-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/auth/reset-password/request',
            type: 'POST',
            data: new FormData($(this)[0]),
            success: () => {
                $(this).trigger('reset');
            }
        });
    });
};
