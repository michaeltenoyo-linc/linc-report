import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const masterBudget = async () => {
    console.log("loading MasterBudgetJS");

    const getBudget = async () => {
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
          drawCallback: async function() {
            // Get data, only from the rows displayed on the current page.
            var elements = this.api().rows({page:'current'}).data();

            if (elements.length !== 0){
              for (var i = 0; i < elements.length; i++) {

                  // Find the chart intended for this data
                  var elementId = elements[i].id;
                  var ctx = $("#"+elementId);
                  console.log(ctx);

                  //Draw chart
                  const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

                  const blujayData = await $.get('/sales/data/get-yearly-achievement/'+elementId);

                  const data = {
                    labels: labels,
                    datasets: [
                      {
                        label: 'Actual',
                        data: blujayData['yearly_revenue'],
                        borderColor: 'rgb(31, 48, 156)',
                        backgroundColor: 'rgb(31, 48, 156)',
                        type: 'bar',
                        order: 1,
                      },
                      {
                        label: 'Budget',
                        data: blujayData['yearly_budget'],
                        borderColor: 'rgb(81, 214, 58)',
                        backgroundColor: 'rgb(81, 214, 58)',
                        type: 'line',
                        order: 0,
                      }
                    ]
                  };

                  const config = {
                    type: 'line',
                    data: data,
                    options: {
                      plugins: {
                        legend: {
                          display: false,
                        },
                        title: {
                          display: false,
                          text: 'Chart.js Stacked Line/Bar Chart'
                        }
                      },
                      scales: {
                        y: {
                          stacked: true,
                          ticks: {
                            display: false,
                          }
                        },
                        x: {
                          ticks: {
                            display: false,
                          }
                        }
                      }
                    },
                  };

                  try {
                    const chartGraph = new Chart(ctx, config);
                  } catch (error) {
                    console.log("Chart already exist");
                  }
              }
            }
          },

          /*
          initComplete: function(settings, json){
            console.log(json);
            //Drawing graph each row
            let containerList = $('.table-container-graph').map(function(){
              //get data by id
              console.log($(this).context.id);

              //Draw chart
              const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

              const data = {
                labels: labels,
                datasets: [
                  {
                    label: 'Actual',
                    data: [4,6,10,7,6,9,5,8,9,10,6,8],
                    borderColor: 'rgb(31, 48, 156)',
                    backgroundColor: 'rgb(31, 48, 156)',
                    stack: 'combined',
                    type: 'bar'
                  },
                  {
                    label: 'Budget',
                    data: [2,6,12,5,4,8,2,6,5,9,10,5],
                    borderColor: 'rgb(81, 214, 58)',
                    backgroundColor: 'rgb(81, 214, 58)',
                    stack: 'combined'
                  }
                ]
              };

              const config = {
                type: 'line',
                data: data,
                options: {
                  plugins: {
                    title: {
                      display: false,
                      text: 'Chart.js Stacked Line/Bar Chart'
                    }
                  },
                  scales: {
                    y: {
                      stacked: true,
                      ticks: {
                        display: false,
                      }
                    },
                    x: {
                      ticks: {
                        display: false,
                      }
                    }
                  }
                },
              };

              const chartGraph = new Chart(this, config);
            });
          }
          */
      });
      

      return false;
    }

    getBudget();
}

