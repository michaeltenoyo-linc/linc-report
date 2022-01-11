import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

export const EditModal = () => {
    $(document).on('#btn-sj-edit','submit', function(e){
        e.preventDefault();
        console.log("Open Modal");
        $('#sj-edit-modal .modal').removeClass('hidden');
    });
}
