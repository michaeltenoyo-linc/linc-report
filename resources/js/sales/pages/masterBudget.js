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
            {data: 'graph', name: 'utilitas',  width: "20%", orderable: false, searchable: false},
          ],
          initComplete: function() {
            var input = $('.dataTables_filter input').unbind(),
                self = this.api(),
                $searchButton = $('<button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded text-right">')
                          .text('search')
                          .click(function() {
                              self.search(input.val()).draw();
                          }),
                $clearButton = $('<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-right">')
                          .text('clear')
                          .click(function() {
                              input.val('');
                              $searchButton.click(); 
                          }) 
            $('.dataTables_filter').append($searchButton, $clearButton);
          },          
          drawCallback: async function() {
            // Get data, only from the rows displayed on the current page.
            var elements = this.api().rows({page:'current'}).data();

            if (elements.length !== 0){
              for (var i = 0; i < elements.length; i++) {

                  // Find the chart intended for this data
                  var elementId = elements[i].id;
                  var ctx = $("#"+elementId);
                  console.log(ctx);

                  try {
                    const checkChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                            datasets: [{
                                label: '# of Votes',
                                data: [12, 19, 3, 5, 2, 3],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    checkChart.destroy();

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

                    const newChart = new Chart(ctx, config);


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

