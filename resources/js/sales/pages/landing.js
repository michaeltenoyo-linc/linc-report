import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const loadStaticChart = async () => {

  //Chart Landing Yearly Revenue

    //Dummy Data
    const labels = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December'
  ];
  const revenueDataFetch = await $.get('/sales/data/get-yearly-revenue');
  //console.log(revenueDataFetch);
  const data = {
      labels: labels,
      datasets: [
          {
              label: 'Warehouse',
              data: revenueDataFetch['warehouse'],
              borderColor: 'rgb(10, 23, 79)',
              backgroundColor: 'rgb(10, 23, 79, 0.5)',
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.4
          },
          {
              label: 'Transport',
              data: revenueDataFetch['transport'],
              borderColor: 'rgb(227, 9, 9)',
              backgroundColor: 'rgb(227, 9, 9, 0.5)',
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.4
          },
          {
              label: 'EXIM',
              data: revenueDataFetch['exim'],
              borderColor: 'rgb(25, 166, 60)',
              backgroundColor: 'rgb(25, 166, 60, 0.5)',
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.4
          },
          {
              label: 'Bulk',
              data: revenueDataFetch['bulk'],
              borderColor: 'rgb(25, 23, 150)',
              backgroundColor: 'rgb(25, 23, 150, 0.5)',
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.4
          },
      ]
  };

  const contYearlyRevenue = $('#chartRevenueYearly');
  const configYearlyRevenue = {
      type: 'line',
      data: data,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: true,
                  text: 'Yearly Revenue 2022'
              },
          },
          interaction: {
              intersect: false,
          },
          scales: {
          x: {
              display: true,
              title: {
                display: true
              },
          },
          y: {
              display: true,
              title: {
                display: true,
                text: 'Revenue (Mill.)'
              },
              suggestedMin: 0,
              suggestedMax: 15
          }
          }
      },
  };

  const chartRevenueYearly = new Chart(contYearlyRevenue, configYearlyRevenue);
}

export const loadDynamicChart = async () => {
  /*
  //Sales Revenue This Month
  const AditRevenue = await $.get('/sales/data/get-sales-overview/adit');
  const EdwinRevenue = await $.get('/sales/data/get-sales-overview/edwin');
  const WillemRevenue = await $.get('/sales/data/get-sales-overview/willem');

  $('#revenue-adit').html(AditRevenue['revenue_1m']);
  $('#revenue-edwin').html(EdwinRevenue['revenue_1m']);
  $('#revenue-willem').html(WillemRevenue['revenue_1m']);
  */

  //Chart Landing Monthly BP

  //Dummy Data
  const labels2 = [
      'Transport - Yay',
      'Transport - Nay',
      'EXIM - Yay',
      'EXIM - Nay',
      'Bulk - Yay',
      'Bulk - Nay',
  ];

  const fetchDivisionMonthlyPie = await $.get('/sales/data/get-division-pie');

  const data2 = {
      labels: labels2,
      datasets: [
          {
              backgroundColor: ['hsl(0, 100%, 60%)', 'hsl(0, 100%, 35%)'],
              data: fetchDivisionMonthlyPie['transport'],
          },
          {
              backgroundColor: ['hsl(100, 100%, 60%)', 'hsl(100, 100%, 35%)'],
              data: fetchDivisionMonthlyPie['exim'],
          },
          {
              backgroundColor: ['hsl(180, 100%, 60%)', 'hsl(180, 100%, 35%)'],
              data: fetchDivisionMonthlyPie['bulk'],
          },
      ]
  };

  const contMonthlyBahana = $('#chartBahanaMonthly');
  const configMonthlyBahana = {
      type: 'pie',
      data: data2,
      options: {
        responsive: true,
        plugins: {
          title: {
              display: true,
              text: 'This Month Achievement by Division Unit'
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
  

  const chartMonthlyBahana = new Chart(contMonthlyBahana, configMonthlyBahana);

  //Chart Monthly Achievement Transport

  //Dummy Data
  const monthlyAchivementDataFetch = await $.get('/sales/data/get-monthly-achievement');
  //console.log(monthlyAchivementDataFetch);
  const dataDailyTransport = {
    labels: monthlyAchivementDataFetch['labelTransport'],
    datasets: [
        {
          label: 'Blujay (Transport)',
          fill: true,
          backgroundColor: 'rgb(4, 1, 138)',
          borderColor: 'rgb(2, 0, 74)',
          data: monthlyAchivementDataFetch['dataTransport'],
        },
    ]
  };

  const contDailyTransport = $('#chartTransportDaily');
  const configDailyTransport = {
    type: 'line',
    data: dataDailyTransport,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'This Month Daily Revenue'
        },
      },
      interaction: {
        mode: 'index',
        intersect: false
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: 'Days'
          },
          ticks: {
            display: false,
          }
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Revenue'
          },
          ticks: {
            display: false,
          }
        }
      }
    },
  };

  const chartDailyTransport = new Chart(contDailyTransport, configDailyTransport);

  //Chart Monthly Achievement EXIM
  const dataDailyExim = {
    labels: monthlyAchivementDataFetch['labelExim'],
    datasets: [
        {
          label: 'Blujay (EXIM)',
          fill: true,
          backgroundColor: 'rgb(4, 1, 138)',
          borderColor: 'rgb(2, 0, 74)',
          data: monthlyAchivementDataFetch['dataExim'],
        },
    ]
  };

  const contDailyExim = $('#chartEximDaily');
  const configDailyExim = {
    type: 'line',
    data: dataDailyExim,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: false,
          text: 'This Month Achievement'
        },
      },
      interaction: {
        mode: 'index',
        intersect: false
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: 'Days'
          },
          ticks: {
            display: false,
          }
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Revenue'
          },
          ticks: {
            display: false,
          }
        }
      }
    },
  };

  const chartDailyExim = new Chart(contDailyExim, configDailyExim);

  //Chart Monthly Achievement Bulk
  const dataDailyBulk = {
      labels: monthlyAchivementDataFetch['labelBulk'],
      datasets: [
          {
            label: 'Blujay (BULK)',
            fill: true,
            backgroundColor: 'rgb(4, 1, 138)',
            borderColor: 'rgb(2, 0, 74)',
            data: monthlyAchivementDataFetch['dataBulk'],
          },
      ]
    };

    const contDailyBulk = $('#chartBulkDaily');
    const configDailyBulk = {
      type: 'line',
      data: dataDailyBulk,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: false,
            text: 'This Month Achievement'
          },
        },
        interaction: {
          mode: 'index',
          intersect: false
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Days'
            },
            ticks: {
              display: false,
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Revenue'
            },
            ticks: {
              display: false,
            }
          }
        }
      },
    };

    const chartDailyBulk = new Chart(contDailyBulk, configDailyBulk);


  //Progressbar completed Loads
  $('#landing-completed-loads').html(monthlyAchivementDataFetch['completedLoads']);
  $('#landing-incompleted-loads').html(monthlyAchivementDataFetch['incompleteLoads']);

  //Chart Landing Monthly Transport
  const transportSalesMonthlyAchievement = await $.get('/sales/data/get-division-pie/transport');

  const labels4 = [
    'Adit',
    'Edwin',
    'Willem',
  ];
  const data4 = {
      labels: labels4,
      datasets: [
          {
              label: 'Actual',
              data: [transportSalesMonthlyAchievement['adit'][0], transportSalesMonthlyAchievement['edwin'][0], transportSalesMonthlyAchievement['willem'][0]],
              backgroundColor: 'rgb(25,150,60)',
          },
          {
            label: 'Budget Remains',
            data: [transportSalesMonthlyAchievement['adit'][1], transportSalesMonthlyAchievement['edwin'][1], transportSalesMonthlyAchievement['willem'][1]],
            backgroundColor: 'rgb(40,235,15)',
          },
      ]
  };

  const contMonthlyTransport = $('#chartTransportMonthly');
  const configMonthlyTransport = {
    type: 'bar',
    data: data4,
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Monthly Transport by Sales'
        },
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    }
  };

  const chartMonthlyTransport = new Chart(contMonthlyTransport, configMonthlyTransport);

  //Chart Landing Monthly Exim
  const eximSalesMonthlyAchievement = await $.get('/sales/data/get-division-pie/exim');

  const labels5 = [
    'Adit',
    'Edwin',
    'Willem',
  ];
  const data5 = {
      labels: labels5,
      datasets: [
          {
              label: 'Actual',
              data: [eximSalesMonthlyAchievement['adit'][0], eximSalesMonthlyAchievement['edwin'][0], eximSalesMonthlyAchievement['willem'][0]],
              backgroundColor: 'rgb(25,150,60)',
          },
          {
            label: 'Budget Remains',
            data: [eximSalesMonthlyAchievement['adit'][1], eximSalesMonthlyAchievement['edwin'][1], eximSalesMonthlyAchievement['willem'][1]],
            backgroundColor: 'rgb(40,235,15)',
          },
      ]
  };

  const contMonthlyExim = $('#chartEximMonthly');
  const configMonthlyExim = {
    type: 'bar',
    data: data5,
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Monthly Exim by Sales'
        },
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    }
  };

  const chartMonthlyExim = new Chart(contMonthlyExim, configMonthlyExim);

  //Chart Landing Monthly Bulk
  const bulkSalesMonthlyAchievement = await $.get('/sales/data/get-division-pie/bulk');

  const labels6 = [
    'Adit',
    'Edwin',
    'Willem',
  ];
  const data6 = {
      labels: labels6,
      datasets: [
          {
              label: 'Actual',
              data: [bulkSalesMonthlyAchievement['adit'][0], bulkSalesMonthlyAchievement['edwin'][0], bulkSalesMonthlyAchievement['willem'][0]],
              backgroundColor: 'rgb(25,150,60)',
          },
          {
            label: 'Budget Remains',
            data: [bulkSalesMonthlyAchievement['adit'][1], bulkSalesMonthlyAchievement['edwin'][1], bulkSalesMonthlyAchievement['willem'][1]],
            backgroundColor: 'rgb(40,235,15)',
          },
      ]
  };

  const contMonthlyBulk = $('#chartBulkMonthly');
  const configMonthlyBulk = {
    type: 'bar',
    data: data6,
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Monthly Bulk by Sales'
        },
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    }
  };

  const chartMonthlyBulk = new Chart(contMonthlyBulk, configMonthlyBulk);
}

export const Landing = async () => {
    console.log("loading LandingJs");

    await loadStaticChart();
    await loadDynamicChart();
}
