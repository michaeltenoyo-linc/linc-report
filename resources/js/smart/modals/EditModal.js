import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

export const EditModal = () => {
    $(document).on('click', '#btn-sj-edit', function(e){
        e.preventDefault();
        console.log("Open Modal");

        //GET SO DATA BY ID

        $('#sj-edit-modal .modal').removeClass('hidden');
    });
}
