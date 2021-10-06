export const Modal= () => {
    $('.modal .modal-overlay').on('click', function() {
        $('.modal').addClass('hidden');
    });

    $('.modal .modal-close-button').on('click', function() {
        $('.modal').addClass('hidden');
    });
};
