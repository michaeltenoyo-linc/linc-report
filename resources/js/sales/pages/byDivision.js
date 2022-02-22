import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const RefreshDivisionPie = async () => {
  const getDivisionOverview = async () => {
    const divisionOverviewFetch = await $.get('/sales/data/get-division-overview/'+$('#division-name').val());

    $('#division-revenue-1m').empty().html(divisionOverviewFetch['revenue_1m']);
    $('#division-revenue-ytd').empty().html(divisionOverviewFetch['revenue_ytd']);
    $('#division-transaction-1m').empty().html(divisionOverviewFetch['transaction_1m']);
    $('#division-transaction-ytd').empty().html(divisionOverviewFetch['transaction_ytd']);
    $('#division-achievement-1m').empty().html(divisionOverviewFetch['achievement_1m_text']);
    $('#division-achievement-ytd').empty().html(divisionOverviewFetch['achievement_ytd_text']);
    $('#division-achivementbar-1m').css("width",divisionOverviewFetch['achivement_1m']+"%");
    $('#division-achivementbar-ytd').css("width",divisionOverviewFetch['achivement_ytd']+"%");
  }

  const getDivisionPie = async () => {
    const divisionPieFetch = await $.get('/sales/data/get-division-pie/'+$('#division-name').val());

    //Pie Sales Adit
    const labelsAdit = [
        'Adit - Yay',
        'Adit - Nay',
    ];
    const dataDivisionAdit = {
        labels: labelsAdit,
        datasets: [
            {
                backgroundColor: ['#4ad2ff', '#00abe3'],
                data: divisionPieFetch['adit']
            },
        ]
    };

    const contDivisionAdit = $('#chartDivisionAdit');
    const configDivisionAdit = {
        type: 'pie',
        data: dataDivisionAdit,
        options: {
          responsive: true,
          plugins: {
            title: {
                display: false,
                text: 'Monthly Achievement Adit'
            },
            legend: {
              labels: {
                generateLabels: function(chart) {
                  // Get the default label list
                  const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                  const labelsOriginal = original.call(this, chart);

                  // Build an array of colors used in the datasets of the chart
                  var datasetColors = chart.data.datasets.map(function(e) {
                    return e.backgroundColor;
                  });
                  datasetColors = datasetColors.flat();

                  // Modify the color and hide state of each label
                  labelsOriginal.forEach(label => {
                    // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                    label.datasetIndex = (label.index - label.index % 2) / 2;

                    // The hidden state must match the dataset's hidden state
                    label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                    // Change the color to match the dataset
                    label.fillStyle = datasetColors[label.index];
                  });

                  return labelsOriginal;
                }
              },
              onClick: function(mouseEvent, legendItem, legend) {
                // toggle the visibility of the dataset from what it currently is
                legend.chart.getDatasetMeta(
                  legendItem.datasetIndex
                ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
                legend.chart.update();
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const labelIndex = (context.datasetIndex * 2) + context.dataIndex;
                  return context.chart.data.labels[labelIndex] + ': ' + context.formattedValue;
                }
              }
            }
          }
        },
    };

    const chartDivisionAdit = new Chart(contDivisionAdit, configDivisionAdit);

    //Pie Sales Edwin
    const labelsEdwin = [
      'Edwin - Yay',
      'Edwin - Nay',
    ];
    const dataDivisionEdwin = {
        labels: labelsEdwin,
        datasets: [
            {
                backgroundColor: ['#4ad2ff', '#00abe3'],
                data: divisionPieFetch['edwin']
            },
        ]
    };

    const contDivisionEdwin = $('#chartDivisionEdwin');
    const configDivisionEdwin = {
        type: 'pie',
        data: dataDivisionEdwin,
        options: {
          responsive: true,
          plugins: {
            title: {
                display: false,
                text: 'Monthly Achievement Edwin'
            },
            legend: {
              labels: {
                generateLabels: function(chart) {
                  // Get the default label list
                  const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                  const labelsOriginal = original.call(this, chart);

                  // Build an array of colors used in the datasets of the chart
                  var datasetColors = chart.data.datasets.map(function(e) {
                    return e.backgroundColor;
                  });
                  datasetColors = datasetColors.flat();

                  // Modify the color and hide state of each label
                  labelsOriginal.forEach(label => {
                    // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                    label.datasetIndex = (label.index - label.index % 2) / 2;

                    // The hidden state must match the dataset's hidden state
                    label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                    // Change the color to match the dataset
                    label.fillStyle = datasetColors[label.index];
                  });

                  return labelsOriginal;
                }
              },
              onClick: function(mouseEvent, legendItem, legend) {
                // toggle the visibility of the dataset from what it currently is
                legend.chart.getDatasetMeta(
                  legendItem.datasetIndex
                ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
                legend.chart.update();
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const labelIndex = (context.datasetIndex * 2) + context.dataIndex;
                  return context.chart.data.labels[labelIndex] + ': ' + context.formattedValue;
                }
              }
            }
          }
        },
    };

    const chartDivisionEdwin = new Chart(contDivisionEdwin, configDivisionEdwin);

    //Pie Sales Willem
    const labelsWillem = [
      'Willem - Yay',
      'Willem - Nay',
    ];
    const dataDivisionWillem = {
        labels: labelsWillem,
        datasets: [
            {
                backgroundColor: ['#4ad2ff', '#00abe3'],
                data: divisionPieFetch['willem']
            },
        ]
    };

    const contDivisionWillem = $('#chartDivisionWillem');
    const configDivisionWillem = {
        type: 'pie',
        data: dataDivisionWillem,
        options: {
          responsive: true,
          plugins: {
            title: {
                display: false,
                text: 'Monthly Achievement Willem'
            },
            legend: {
              labels: {
                generateLabels: function(chart) {
                  // Get the default label list
                  const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                  const labelsOriginal = original.call(this, chart);

                  // Build an array of colors used in the datasets of the chart
                  var datasetColors = chart.data.datasets.map(function(e) {
                    return e.backgroundColor;
                  });
                  datasetColors = datasetColors.flat();

                  // Modify the color and hide state of each label
                  labelsOriginal.forEach(label => {
                    // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                    label.datasetIndex = (label.index - label.index % 2) / 2;

                    // The hidden state must match the dataset's hidden state
                    label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                    // Change the color to match the dataset
                    label.fillStyle = datasetColors[label.index];
                  });

                  return labelsOriginal;
                }
              },
              onClick: function(mouseEvent, legendItem, legend) {
                // toggle the visibility of the dataset from what it currently is
                legend.chart.getDatasetMeta(
                  legendItem.datasetIndex
                ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
                legend.chart.update();
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const labelIndex = (context.datasetIndex * 2) + context.dataIndex;
                  return context.chart.data.labels[labelIndex] + ': ' + context.formattedValue;
                }
              }
            }
          }
        },
    };

    const chartDivisionWillem = new Chart(contDivisionWillem, configDivisionWillem);
  }

  getDivisionPie();
  getDivisionOverview();
}

export const ByDivision = async () => {
    console.log("loading BySalesJS");

    const getDivisionPerformance = () => {
      var divisionRaw = $('#division-name').val();
      var divisionSql = "";
      console.log(divisionRaw);
      switch (divisionRaw) {
        case "transport":
          divisionSql = "Pack Trans";
          break;
        case "warehouse":
          divisionSql = "Package Whs";
          break;
        case "exim":
          divisionSql = "Freight Forwarding BP";
          break;
        case "bulk":
          divisionSql = "Bulk Trans";
          break;
        default:
          break;
      }

      console.log(divisionSql);


      var table = $('#yajra-datatable-division-budget').DataTable({
        processing: true,
        serverSide: false,
        ajax: "/sales/data/get-division-performance/"+divisionSql,
        autoWidth: false,
        columns: [
          {data: 'sales', name: 'load_id'},
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
              $searchButton = $('<button class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded text-right">')
                        .text('search')
                        .click(function() {
                            self.search(input.val()).draw();
                        }),
              $clearButton = $('<button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-right">')
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
    }

    getDivisionPerformance();
}
