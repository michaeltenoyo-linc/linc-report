import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const Landing = () => {
    console.log("loading LandingJs");

    const onLoad = () => {
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
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Warehouse',
                    data: [1,5,4,6,2,8,3,5,9,13,5,8],
                    borderColor: 'rgb(10, 23, 79)',
                    backgroundColor: 'rgb(10, 23, 79, 0.5)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                },
                {
                    label: 'Transport',
                    data: [5,4,1,12,8,7,9,10,2,8,12,15],
                    borderColor: 'rgb(227, 9, 9)',
                    backgroundColor: 'rgb(227, 9, 9, 0.5)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                },
                {
                    label: 'EXIM',
                    data: [6,17,15,16,5,8,6,1,9,10,11,6],
                    borderColor: 'rgb(25, 166, 60)',
                    backgroundColor: 'rgb(25, 166, 60, 0.5)',
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                },
                {
                    label: 'Bulk',
                    data: [7,6,3,8,5,3,4,9,1,7,4,9],
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
                    }
                },
                y: {
                    display: true,
                    title: {
                    display: true,
                    text: 'Gross Profit'
                    },
                    suggestedMin: 0,
                    suggestedMax: 15
                }
                }
            },
        };

        const chartRevenueYearly = new Chart(contYearlyRevenue, configYearlyRevenue);

        //Chart Landing Monthly BP
        
        //Dummy Data
        const labels2 = [
            'Bahana Prestasi - Yay',
            'Bahana Prestasi - Nay',
            'Transport - Yay',
            'Transport - Nay',
            'EXIM - Yay',
            'EXIM - Nay',
            'Bulk - Yay',
            'Bulk - Nay',
        ];

        const data2 = {
            labels: labels2,
            datasets: [
                {
                    backgroundColor: ['#AAA', '#777'],
                    data: [503, 1094]
                },
                {
                    backgroundColor: ['hsl(0, 100%, 60%)', 'hsl(0, 100%, 35%)'],
                    data: [33, 67]
                },
                {
                    backgroundColor: ['hsl(100, 100%, 60%)', 'hsl(100, 100%, 35%)'],
                    data: [20, 80]
                },
                {
                    backgroundColor: ['hsl(180, 100%, 60%)', 'hsl(180, 100%, 35%)'],
                    data: [10, 90]
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
                    text: 'Monthly Budget By Division (Million.)'
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

        //Chart Landing Yearly Revenue
        
        //Dummy Data
        const labels3 = [
            'Warehouse - Yay',
            'Warehouse - Nay'
        ];

        const data3 = {
            labels: labels3,
            datasets: [
                {
                    data: [1054,2056],
                    backgroundColor: ['rgb(25,180,25)','rgb(25,180,125)'],
                },
            ]
        };

        const contMonthlyCml = $('#chartCmlMonthly');
        const configMonthlyCml = {
            type: 'pie',
            data: data3,
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'top',
                },
                title: {
                  display: true,
                  text: 'Monthly Warehouse Budget'
                }
              }
            },
          };

        const chartMonthlyCml = new Chart(contMonthlyCml, configMonthlyCml);
    }

    onLoad();
}
