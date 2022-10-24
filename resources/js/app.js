require('./bootstrap');
import 'tw-elements';

const sharedModule = require('./shared/index');

sharedModule.load();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    processData: false,
    contentType: false,
    dataType: 'JSON',
});
