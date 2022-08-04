import { toArray, toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

Array.prototype.sortBy = function(p, order) {
  return this.slice(0).sort(function(a,b) {
    if(order == 'asc'){
      return (a[p] > b[p]) ? 1 : (a[p] < b[p]) ? -1 : 0;
    }else{
      return (a[p] < b[p]) ? 1 : (a[p] > b[p]) ? -1 : 0;
    }
    
  });
}

export const loadStaticChart = async () => {

  //Chart Landing Yearly Revenue All

  //Dummy Data
  
  const revenueDataFetch = await $.get('/sales/data/get-yearly-revenue/all');
  const labels = revenueDataFetch['labels'];
  var contYearlyRevenue =  document.getElementById('chartRevenueYearly').getContext('2d'), gradient = contYearlyRevenue.createLinearGradient(0, 0, 0, 450);

  gradient.addColorStop(0, 'rgba(8, 73, 252, 1)');
  gradient.addColorStop(0.5, 'rgba(8, 73, 252, 0.25)');
  gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');



  const data = {
      labels: labels,
      datasets: [
          {
              label: 'Surabaya',
              data: revenueDataFetch['overall'],
              borderColor: '#032ea3',
              backgroundColor: gradient,
              pointBackgroundColor: 'white',
              fill: true,
              cubicInterpolationMode: 'monotone',
              tension: 0.4,
              order: 0
          },
          {
            label: 'Websettle',
            data: revenueDataFetch['websettle'],
            borderColor: 'rgb(21, 255, 0)',
            borderWidth: 1,
            backgroundColor: 'rgba(21, 255, 0, 0.2)',
            order: 1,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'POD',
            data: revenueDataFetch['pod'],
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            order: 2,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'Ongoing',
            data: revenueDataFetch['ongoing'],
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            order: 3,
            type: 'bar',
            stack: 'stack progress',
          },
          
      ]
  };

  const configYearlyRevenue = {
      type: 'line',
      data: data,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: true,
                  text: 'Yearly Revenue Surabaya 2022'
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
                text: 'Revenue (Bill.)'
              },
              suggestedMin: 0,
              suggestedMax: 3
          }
          }
      },
  };

  const chartRevenueYearly = new Chart(contYearlyRevenue, configYearlyRevenue);


  //Each Division Detail
  const transportYearlyDetail = await $.get('/sales/data/get-yearly-detail/transport');
  $('#transport-yearly-revenue').html('IDR. '+transportYearlyDetail['revenue']);
  $('#transport-yearly-ongoing').html(transportYearlyDetail['ongoing']);
  $('#transport-yearly-pod').html(transportYearlyDetail['pod']);
  $('#transport-yearly-websettle').html(transportYearlyDetail['websettle']);

  const eximYearlyDetail = await $.get('/sales/data/get-yearly-detail/exim');
  $('#exim-yearly-revenue').html('IDR. '+eximYearlyDetail['revenue']);
  $('#exim-yearly-ongoing').html(eximYearlyDetail['ongoing']);
  $('#exim-yearly-pod').html(eximYearlyDetail['pod']);
  $('#exim-yearly-websettle').html(eximYearlyDetail['websettle']);

  const bulkYearlyDetail = await $.get('/sales/data/get-yearly-detail/bulk');
  $('#bulk-yearly-revenue').html('IDR. '+bulkYearlyDetail['revenue']);
  $('#bulk-yearly-ongoing').html(bulkYearlyDetail['ongoing']);
  $('#bulk-yearly-pod').html(bulkYearlyDetail['pod']);
  $('#bulk-yearly-websettle').html(bulkYearlyDetail['websettle']);

  const warehouseYearlyDetail = await $.get('/sales/data/get-yearly-detail/warehouse');
  $('#warehouse-yearly-revenue').html('IDR. '+warehouseYearlyDetail['revenue']);
  $('#warehouse-yearly-ongoing').html(warehouseYearlyDetail['ongoing']);
  $('#warehouse-yearly-pod').html(warehouseYearlyDetail['pod']);
  $('#warehouse-yearly-websettle').html(warehouseYearlyDetail['websettle']);

  //Yearly Revenue Transport
  //Dummy Data
  const labelsTransport = [
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
  const revenueDataFetchTransport = await $.get('/sales/data/get-yearly-revenue/transport');
  var contYearlyRevenueTransport =  document.getElementById('chartRevenueYearlyTransport').getContext('2d'), gradientTransport = contYearlyRevenueTransport.createLinearGradient(0, 0, 0, 200);

  gradientTransport.addColorStop(0, 'rgba(214, 2, 2, 1)');
  gradientTransport.addColorStop(0.5, 'rgba(214, 2, 2, 0.5)');
  gradientTransport.addColorStop(1, 'rgba(255, 255, 255, 0)');



  const dataTransport = {
      labels: labelsTransport,
      datasets: [
          {
              label: 'Transport',
              data: revenueDataFetchTransport['overall'],
              borderColor: '#8a0000',
              backgroundColor: gradientTransport,
              pointBackgroundColor: 'white',
              fill: true,
              cubicInterpolationMode: 'monotone',
              tension: 0.4,
              order: 0,
          },
          {
            label: 'Websettle',
            data: revenueDataFetchTransport['websettle'],
            borderColor: 'rgb(21, 255, 0)',
            borderWidth: 1,
            backgroundColor: 'rgba(21, 255, 0, 0.2)',
            order: 1,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'POD',
            data: revenueDataFetchTransport['pod'],
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            order: 2,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'Ongoing',
            data: revenueDataFetchTransport['ongoing'],
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            order: 3,
            type: 'bar',
            stack: 'stack progress',
          },
      ]
  };

  const configYearlyRevenueTransport = {
      type: 'line',
      data: dataTransport,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: false,
                  text: 'Yearly Revenue Surabaya Transport 2022'
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
                text: 'Revenue (Bill.)'
              },
              suggestedMin: 0,
          }
          }
      },
  };

  const chartRevenueYearlyTransport = new Chart(contYearlyRevenueTransport, configYearlyRevenueTransport);

  //Yearly Revenue Exim
  //Dummy Data
  const labelsExim = [
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
  const revenueDataFetchExim = await $.get('/sales/data/get-yearly-revenue/exim');
  var contYearlyRevenueExim =  document.getElementById('chartRevenueYearlyExim').getContext('2d'), gradientExim = contYearlyRevenueExim.createLinearGradient(0, 0, 0, 200);

  gradientExim.addColorStop(0, 'rgba(2, 173, 30, 1)');
  gradientExim.addColorStop(0.5, 'rgba(2, 173, 30, 0.5)');
  gradientExim.addColorStop(1, 'rgba(255, 255, 255, 0)');



  const dataExim = {
      labels: labelsExim,
      datasets: [
          {
              label: 'Exim',
              data: revenueDataFetchExim['overall'],
              borderColor: '#004a0c',
              backgroundColor: gradientExim,
              pointBackgroundColor: 'white',
              fill: true,
              cubicInterpolationMode: 'monotone',
              tension: 0.4,
              order: 0,
          },
          {
            label: 'Websettle',
            data: revenueDataFetchExim['websettle'],
            borderColor: 'rgb(21, 255, 0)',
            borderWidth: 1,
            backgroundColor: 'rgba(21, 255, 0, 0.2)',
            order: 1,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'POD',
            data: revenueDataFetchExim['pod'],
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            order: 2,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'Ongoing',
            data: revenueDataFetchExim['ongoing'],
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            order: 3,
            type: 'bar',
            stack: 'stack progress',
          },
      ]
  };

  const configYearlyRevenueExim = {
      type: 'line',
      data: dataExim,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: false,
                  text: 'Yearly Revenue Surabaya Exim 2022'
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
                text: 'Revenue (Bill.)'
              },
              suggestedMin: 0,
          }
          }
      },
  };

  const chartRevenueYearlyExim = new Chart(contYearlyRevenueExim, configYearlyRevenueExim);

  //Yearly Revenue Bulk
  //Dummy Data
  const labelsBulk = [
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
  const revenueDataFetchBulk = await $.get('/sales/data/get-yearly-revenue/bulk');
  var contYearlyRevenueBulk =  document.getElementById('chartRevenueYearlyBulk').getContext('2d'), gradientBulk = contYearlyRevenueBulk.createLinearGradient(0, 0, 0, 200);

  gradientBulk.addColorStop(0, 'rgba(65, 218, 232, 1)');
  gradientBulk.addColorStop(0.5, 'rgba(65, 218, 232, 0.5)');
  gradientBulk.addColorStop(1, 'rgba(255, 255, 255, 0)');



  const dataBulk = {
      labels: labelsBulk,
      datasets: [
          {
              label: 'Bulk',
              data: revenueDataFetchBulk['overall'],
              borderColor: '#2e99a3',
              backgroundColor: gradientBulk,
              pointBackgroundColor: 'white',
              fill: true,
              cubicInterpolationMode: 'monotone',
              tension: 0.4,
              order: 0,
          },
          {
            label: 'Websettle',
            data: revenueDataFetchBulk['websettle'],
            borderColor: 'rgb(21, 255, 0)',
            borderWidth: 1,
            backgroundColor: 'rgba(21, 255, 0, 0.2)',
            order: 1,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'POD',
            data: revenueDataFetchBulk['pod'],
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            order: 2,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'Ongoing',
            data: revenueDataFetchBulk['ongoing'],
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            order: 3,
            type: 'bar',
            stack: 'stack progress',
          },
      ]
  };

  const configYearlyRevenueBulk = {
      type: 'line',
      data: dataBulk,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: false,
                  text: 'Yearly Revenue Surabaya Bulk 2022'
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
                text: 'Revenue (Bill.)'
              },
              suggestedMin: 0,
          }
          }
      },
  };

  const chartRevenueYearlyBulk = new Chart(contYearlyRevenueBulk, configYearlyRevenueBulk);

  //Yearly Revenue Warehouse
  //Dummy Data
  const labelsWarehouse = [
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
  const revenueDataFetchWarehouse = await $.get('/sales/data/get-yearly-revenue/warehouse');
  var contYearlyRevenueWarehouse =  document.getElementById('chartRevenueYearlyWarehouse').getContext('2d'), gradientWarehouse = contYearlyRevenueWarehouse.createLinearGradient(0, 0, 0, 200);

  gradientWarehouse.addColorStop(0, 'rgba(74, 74, 74, 1)');
  gradientWarehouse.addColorStop(0.5, 'rgba(74, 74, 74, 0.5)');
  gradientWarehouse.addColorStop(1, 'rgba(255, 255, 255, 0)');



  const dataWarehouse = {
      labels: labelsWarehouse,
      datasets: [
          {
              label: 'Warehouse',
              data: revenueDataFetchWarehouse['overall'],
              borderColor: '#2e2e2e',
              backgroundColor: gradientWarehouse,
              pointBackgroundColor: 'white',
              fill: true,
              cubicInterpolationMode: 'monotone',
              tension: 0.4,
              order: 0,
          },
          {
            label: 'Websettle',
            data: revenueDataFetchWarehouse['websettle'],
            borderColor: 'rgb(21, 255, 0)',
            borderWidth: 1,
            backgroundColor: 'rgba(21, 255, 0, 0.2)',
            order: 1,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'POD',
            data: revenueDataFetchWarehouse['pod'],
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            order: 2,
            type: 'bar',
            stack: 'stack progress',
          },
          {
            label: 'Ongoing',
            data: revenueDataFetchWarehouse['ongoing'],
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            order: 3,
            type: 'bar',
            stack: 'stack progress',
          },
      ]
  };

  const configYearlyRevenueWarehouse = {
      type: 'line',
      data: dataWarehouse,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: false,
                  text: 'Yearly Revenue Surabaya Warehouse 2022'
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
                text: 'Revenue (Bill.)'
              },
              suggestedMin: 0,
          }
          }
      },
  };

  const chartRevenueYearlyWarehouse = new Chart(contYearlyRevenueWarehouse, configYearlyRevenueWarehouse);
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
  /*
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
  */
}

async function refreshDailyHeadline() {
  $('#container-news-update').empty();

  //Fetch Data
  const DailyData = await $.get('sales/data/get-daily-update/marquee/1');
  console.log(DailyData);

  //SETUP DAY NAME UPDATE
  $('#news-update-dayname').html(DailyData['dayName']);
  $('#news-update-dayname-before').html(DailyData['dayNameBefore']);

  //Daily Headline
  DailyData['yesterday'].forEach(row => {
    let statusRow = "";

    if(row['margin_percentage'] > 0 || row['margin_percentage'] == "100+"){
      statusRow += '<div class="text-3xl text-green-500">';
      statusRow += '<i class="fas fa-chevron-circle-up"></i> '+row['margin_percentage']+'%';
      statusRow += '</div>';
    }else if(row['margin_percentage'] == 0){
      statusRow += '<div class="text-3xl text-yellow-500">';
      statusRow += '<i class="fas fa-minus-circle"></i> '+row['margin_percentage']+'%';
      statusRow += '</div>';
    }else if(row['margin_percentage'] < 0 || row['margin_percentage'] == "100-"){
      statusRow += '<div class="text-3xl text-red-500">';
      statusRow += '<i class="fas fa-chevron-circle-down"></i> '+row['margin_percentage']+'%';
      statusRow += '</div>';
    }else{
      statusRow += '<div class="text-3xl text-gray-500">';
      statusRow += '<i class="fas fa-question-circle"></i> -';
      statusRow += '</div>';
    }

    let divRow = '';
    divRow += '<div class="text-white font-mono text-2xl inline-block mr-20">';
    divRow += row['customer_name']+' <br>';
    divRow += '<span class="text-sm grid grid-cols-2 gap-4">';
    divRow += '<div>';
    divRow += '<i class="fas fa-shipping-fast text-sm mr-3 w-3"></i><span class="text-sm"></span>'+row['revenue_format']+' ( '+row['totalLoads']+' <i class="text-md fas fa-boxes"></i> )<br>';
    divRow += '<i class="fas fa-truck-moving text-sm mr-3 w-3"></i> <span class="text-sm">'+row['totalVehicle']+' Depart</span> <br>';
    divRow += '</div>';
    divRow += '<div class="text-left">';
    divRow += statusRow;
    divRow += '</div>';
    divRow += '</span>';
    divRow += '</div>';

    $('#container-news-update').append(divRow);
  });
}

async function refreshDailyPod(step){
  //Daily POD Progress
  $('#container-headline-pod').empty();

  //Fetch Data
  const DailyData = await $.get('sales/data/get-daily-update/pod/'+step);
  console.log(DailyData);

  let ctr = 1;
  toArray(DailyData['pod']).sortBy('totalPod','desc').forEach(row => {
    let divRow = "";
    let percentageColor = "text-red-500";
    if(row['margin_percentage'] > 75){
      percentageColor = "text-green-500";
    }else if(row['margin_percentage'] > 50){
      percentageColor = "text-yellow-500";
    }else if(row['margin_percentage'] > 25){
      percentageColor = "text-orange-500";
    }

    divRow += '<div class="w-full flex p-2">';
    divRow += '<div class="w-2/12 h-auto p-2">';
    divRow += '<img class="h-12 w-full object-contain" src="/assets/icons/customers/'+row['customer_reference']+'.png" alt="">';
    divRow += '</div>';
    divRow += '<div class="w-4/12 truncate ...">';
    divRow += '<p class="p-2">';
    divRow += '<span class="font-bold text-lg">'+row['customer_reference']+'</span>';
    divRow += '<br>';
    divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['customer_name']+'</span>';
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-6/12 px-4 flex inline-block align-middle justify-center">';
    divRow += '<p class="py-2 text-center">';
    divRow += '<span class="'+percentageColor+' font-bold text-xl">'+row['margin_percentage']+'%</span>';
    divRow += '<br>';
    divRow += '<i class="fas fa-clipboard-check w-3 mr-2"></i>'+row['totalPod']+'/'+row['totalAccepted'];
    divRow += '</p>';
    divRow += '</div>';
    divRow += '</div>';

    $('#container-headline-pod').append(divRow);
    
    ctr++;
  });

  //ZERO POD
  toArray(DailyData['accepted']).sortBy('totalAccepted','desc').forEach(row => {
    if(row['hasPod'] == 0){
      let divRow = "";
      let percentageColor = "text-red-500";

      divRow += '<div class="w-full flex p-2">';
      divRow += '<div class="w-2/12 h-auto p-2">';
      divRow += '<img class="h-12 w-full object-contain" src="/assets/icons/customers/'+row['customer_reference']+'.png" alt="">';
      divRow += '</div>';
      divRow += '<div class="w-4/12 truncate ...">';
      divRow += '<p class="p-2">';
      divRow += '<span class="font-bold text-lg">'+row['customer_reference']+'</span>';
      divRow += '<br>';
      divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['customer_name']+'</span>';
      divRow += '</p>';
      divRow += '</div>';
      divRow += '<div class="w-6/12 px-4 flex inline-block align-middle justify-center">';
      divRow += '<p class="py-2 text-center">';
      divRow += '<span class="'+percentageColor+' font-bold text-xl">0%</span>';
      divRow += '<br>';
      divRow += '<i class="fas fa-clipboard-check w-3 mr-2"></i>0/'+row['totalAccepted'];
      divRow += '</p>';
      divRow += '</div>';
      divRow += '</div>';

      $('#container-headline-pod').append(divRow);
    }
  });
}

async function refreshDailyWebsettle(step){
  //Daily Websettle Progress
  $('#container-headline-websettle').empty();

  //Fetch Data
  const DailyData = await $.get('sales/data/get-daily-update/websettle/'+step);
  console.log(DailyData);

  let ctr = 1;
  toArray(DailyData['websettle']).sortBy('totalWebsettle','desc').forEach(row => {
    let divRow = "";
    let percentageColor = "text-red-500";
    if(row['margin_percentage'] > 75){
      percentageColor = "text-green-500";
    }else if(row['margin_percentage'] > 50){
      percentageColor = "text-yellow-500";
    }else if(row['margin_percentage'] > 25){
      percentageColor = "text-orange-500";
    }

    divRow += '<div class="w-full flex p-2">';
    divRow += '<div class="w-2/12 h-auto p-2">';
    divRow += '<img class="h-12 w-full object-contain" src="/assets/icons/customers/'+row['customer_reference']+'.png" alt="">';
    divRow += '</div>';
    divRow += '<div class="w-4/12 truncate ...">';
    divRow += '<p class="p-2">';
    divRow += '<span class="font-bold text-lg">'+row['customer_reference']+'</span>';
    divRow += '<br>';
    divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['customer_name']+'</span>';
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-6/12 px-4 flex inline-block align-middle justify-center">';
    divRow += '<p class="py-2 text-center">';
    divRow += '<span class="'+percentageColor+' font-bold text-xl">'+row['margin_percentage']+'%</span>';
    divRow += '<br>';
    divRow += '<i class="fas fa-coins w-3 mr-2"></i>'+row['totalWebsettle']+'/'+row['totalPod'];
    divRow += '</p>';
    divRow += '</div>';
    divRow += '</div>';

    $('#container-headline-websettle').append(divRow);
  });

  //ZERO WEBSETTLE
  toArray(DailyData['pod']).sortBy('totalPod','desc').forEach(row => {
    if(row['hasWebsettle'] == 0){
      let divRow = "";
      let percentageColor = "text-red-500";

      divRow += '<div class="w-full flex p-2">';
      divRow += '<div class="w-2/12 h-auto p-2">';
      divRow += '<img class="h-12 w-full object-contain" src="/assets/icons/customers/'+row['customer_reference']+'.png" alt="">';
      divRow += '</div>';
      divRow += '<div class="w-4/12 truncate ...">';
      divRow += '<p class="p-2">';
      divRow += '<span class="font-bold text-lg">'+row['customer_reference']+'</span>';
      divRow += '<br>';
      divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['customer_name']+'</span>';
      divRow += '</p>';
      divRow += '</div>';
      divRow += '<div class="w-6/12 px-4 flex inline-block align-middle justify-center">';
      divRow += '<p class="py-2 text-center">';
      divRow += '<span class="'+percentageColor+' font-bold text-xl">0%</span>';
      divRow += '<br>';
      divRow += '<i class="fas fa-coins w-3 mr-2"></i>0/'+row['totalPod'];
      divRow += '</p>';
      divRow += '</div>';
      divRow += '</div>';

      $('#container-headline-websettle').append(divRow);
    }
  });
}

async function refreshDailyProfit(step){
  //Daily Top Gainer
  $('#container-headline-gainer').empty();

  //Fetch Data
  const DailyData = await $.get('sales/data/get-daily-update/profit/'+step);
  console.log(DailyData);

  let ctr = 1;
  toArray(DailyData['gainer']).sortBy('profit','desc').forEach(row => {
    let divRow = "";
    let percentageColor = "text-red-500";
    if(row['margin_percentage'] > 75){
      percentageColor = "text-green-500";
    }else if(row['margin_percentage'] > 50){
      percentageColor = "text-yellow-500";
    }else if(row['margin_percentage'] > 25){
      percentageColor = "text-orange-500";
    }

    divRow += '<div class="w-full flex p-2">';
    divRow += '<div class="w-2/12 h-auto p-2">';
    divRow += '<img class="h-12 w-full object-contain" src="/assets/icons/customers/'+row['customer_reference']+'.png" alt="">';
    divRow += '</div>';
    divRow += '<div class="w-4/12 truncate ...">';
    divRow += '<p class="p-2">';
    divRow += '<span class="font-bold text-lg">'+row['customer_reference']+'</span>';
    divRow += '<br>';
    divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['customer_name']+'</span>';
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-6/12 px-4 flex inline-block align-middle justify-center">';
    divRow += '<p class="py-2 text-center">';
    divRow += '<span class="'+percentageColor+' font-bold text-xl">'+row['margin_percentage']+'%</span>';
    divRow += '<br>';
    divRow += '<i class="fas fa-balance-scale-right w-3 mr-2"></i> '+row['profit_format'];
    divRow += '</p>';
    divRow += '</div>';
    divRow += '</div>';

    $('#container-headline-gainer').append(divRow);
    
    ctr++;
  });
  
}

async function refreshDailyUtility(step) {
  //Daily Utility Status
  $('#container-headline-utility').empty();

  //Fetch Data
  const DailyData = await $.get('sales/data/get-daily-update/utility/1');
  console.log(DailyData);

  toArray(DailyData['utility']).sortBy('latest','asc').forEach(row => {
    let divRow = "";
    let status = '<span class="font-bold text-yellow-500 text-xl">UNKNOWN</span>';

    if(row['load']['load_status'] == "Completed"){
      status = '<span class="font-bold text-red-500 text-xl">IDLE</span>';
    }else if(row['load']['load_status'] == "Accepted"){
      status = '<span class="font-bold text-blue-500 text-xl">ONGOING</span>';
    }

    divRow += '<div class="w-full flex p-2">';
    divRow += '<div class="w-3/12 truncate ...">';
    divRow += '<p class="p-2">';
    divRow += '<span class="font-bold text-lg">'+row['vehicle_number']+'</span>';
    divRow += '<br>';
    divRow += '<span class="underline">( '+row['vehicle']['own']+' ) '+row['vehicle']['type']+'</span>';
    divRow += '<br>';
    divRow += '<span class="w-full text-gray-500 text-xs truncate">'+row['vehicle']['driver']+'</span>';
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-4/12 px-4 inline-block align-middle text-center">';
    divRow += '<p class="p-2">';
    divRow += '<span class="font-bold">'+row['latest_id']+'</span>';
    divRow += '<br>';
    divRow += '<i class="fas fa-shipping-fast w-5 mr-2"></i>'+row['latest'];
    divRow += '<br>';
    divRow += '<span class="text-sm">( '+row['range']+'d ago )</span>';
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-4/12 px-4 inline-block align-middle text-center">';
    divRow += '<p class="p-2">';
    divRow += status;
    divRow += '</p>';
    divRow += '</div>';
    divRow += '<div class="w-1/12 flex justify-center p-4">';
    divRow += '<a class="flex align-middle justify-center text-center bg-blue-300 rounded w-full hover:bg-blue-400" href="/sales/load-detail/'+row['latest_id']+'" target="_blank"><button id="'+row['latest_id']+'""><i class="fas fa-dolly"></i></button></a>';
    divRow += '</div>';
    divRow += '</div>';

    $('#container-headline-utility').append(divRow);
  });
}

const loadLandingNews = async () => {
  refreshDailyHeadline();
  refreshDailyPod(1);
  refreshDailyWebsettle(1);
  refreshDailyProfit(1);
  refreshDailyUtility();
}

const filterDailyHeadline = async () => {
  $(document).on('click','.landing-headline-inactive', async function(e){
    e.preventDefault();

    let id = $(this).attr('id').split('-');
    let section = id[0];
    let step = id[1];

    let filterClass = '';

    switch (section) {
      case 'pod':
        refreshDailyPod(step);
        break;
      case 'websettle':
        refreshDailyWebsettle(step);
        break;
      case 'profit':
        refreshDailyProfit(step);
        break;
    }

    //ACTIVATED FILTER HEADLINE
    $('.headline-'+section).removeClass('landing-headline-active');
    $('.headline-'+section).removeClass('landing-headline-inactive');
    $('.headline-'+section).addClass('landing-headline-inactive');
    $(this).addClass('landing-headline-active');

  });
}

export const Landing = async () => {
    console.log("loading LandingJs");

    await loadLandingNews();
    filterDailyHeadline();
    
    await loadStaticChart();
    await loadDynamicChart();
}
