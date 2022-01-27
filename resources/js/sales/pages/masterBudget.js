import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const masterBudget = () => {
    console.log("loading MasterBudgetJS");

    const getBudget = () => {
      var table = $('#yajra-datatable-monitoring-budget').DataTable({
          processing: true,
          serverSide: false,
          ajax: "/sales/data/get-budget-actual",
          autoWidth: false,
          columns: [
            {data: 'sales', name: 'id_so'},
            {data: 'division', name: 'load_id'},
            {data: 'customer_name', name: 'nopol'},
            {data: 'customer_status', name: 'penerima'},
            {data: 'period_mon', name: 'total_weightSO'},
            {data: 'achievement_1m', name: 'utilitas'},
            {data: 'achievement_ytd', name: 'utilitas'},
            {data: 'graph', name: 'utilitas', orderable: false, searchable: false},
          ],
      });

      //Drawing graph each row
      

      return false;
    }

    getBudget();
}

