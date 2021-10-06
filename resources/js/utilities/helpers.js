export const disableElement= (elementSelector, isDisable) => {
    if (isDisable) {
        $(elementSelector)
            .addClass('bg-opacity-75 cursor-default')
            .attr('disabled', true);
    } else {
        $(elementSelector)
            .removeClass('bg-opacity-75 cursor-default')
            .attr('disabled', false);
    }
};
