export const Modal= () => {
    //Constraint LOA Timeline Number
    function showTimelineNumber(){
        $('.timeline-number').removeClass("hidden");
    }

    $('.modal .modal-overlay').on('click', function() {
        showTimelineNumber();
        $('.modal').addClass('hidden');
    });

    $('.modal .modal-close-button').on('click', function() {        
        
        showTimelineNumber();
        $('.modal').addClass('hidden');
    });
};
