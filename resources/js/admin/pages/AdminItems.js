import Swal from 'sweetalert2';

export const AdminItems = () => {
    console.log("loading adminProduct JS");

    const getItems = () => {
        /*
        $('#admin-master-account').ready(function () {
            console.log("Taking Data...");
            var table = $('#admin-master-account .yajra-datatable ').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/user/action/get_list_customer",
                columns: [
                  {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
            console.log(table);
        });
        */

        $('#yajra-datatable-items-list').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/data/get-items",
            columns: [
              {data: 'material_code', name: 'material_code'},
              {data: 'description', name: 'description'},
              {data: 'gross_weight', name: 'gross_weight'},
              {data: 'nett_weight', name: 'nett_weight'},
              {data: 'category', name: 'category'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    }

    const autocompleteItems = () => {
        $('#sj-items-modal .input-item-code').typeahead({
            source: function (query, process) {
                return $.get('/data/autocomplete-items', {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });

        console.log("loading typeahead done.");
    }

    autocompleteItems();
    getItems();
};
