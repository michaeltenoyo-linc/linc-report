import { disableElement } from '../../utilities/helpers';

export const ResetPassword= () => {
    disableElement('#reset-password-form button[type="submit"]', true);

    $('#reset-password-form input[type="password"]').on('input', function() {
        let isEmpty= true;

        $('#reset-password-form input[type="password"]').each(function() {
            isEmpty= $(this).val() === '';
        });

        if (isEmpty) {
            disableElement('#reset-password-form button[type="submit"]', true);
        } else {
            disableElement('#reset-password-form button[type="submit"]', false);
        }
    });
    $('#reset-password-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/auth/reset-password/reset',
            type: 'POST',
            data: new FormData($(this)[0]),
            success: () => {
                $(this).trigger('reset');
                window.location.replace('/');
            }
        });
    });
};
