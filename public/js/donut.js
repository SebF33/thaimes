document.addEventListener('DOMContentLoaded', function () {

  const categories = Object.keys(themesCounts);
  const values = Object.values(themesCounts);

  var options = {
    colors: ['#bd150b', '#084bb1', '#0a8558', '#e4d52e'],
    series: values,
    chart: {
      fontFamily: 'Baloo 2',
      foreColor: '#e1e5ea',
      width: 520,
      type: 'donut',
      dropShadow: {
        enabled: true,
        color: '#111',
        top: -1,
        left: 3,
        blur: 3,
        opacity: 0.2
      }
    },
    stroke: {
      width: 0,
    },
    plotOptions: {
      pie: {
        donut: {
          labels: {
            show: true,
            total: {
              showAlways: true,
              show: true
            }
          }
        }
      }
    },
    labels: categories,
    dataLabels: {
      style: {
        fontSize: '14px',
        fontFamily: 'Baloo 2',
        fontWeight: 500,
      },
      dropShadow: {
        blur: 3,
        opacity: 0.8
      }
    },
    fill: {
      type: 'pattern',
      opacity: 1,
      pattern: {
        enabled: true,
        style: ['verticalLines', 'squares', 'horizontalLines', 'circles', 'slantedLines'],
      }
    },
    legend: {
      fontSize: '14px',
      fontFamily: 'Baloo 2',
      fontWeight: 500,
      labels: {
        colors: '#e1e5ea'
      }
    },
    states: {
      hover: {
        filter: 'none'
      }
    },
    theme: {
      palette: 'palette2'
    },
    title: {
      text: "Themes (%)",
      style: {
        fontSize: '20px',
        fontWeight: 'bold',
        fontFamily: 'Baloo 2',
        color: '#e1e5ea'
      }
    },
    subtitle: {
      text: 'By tag',
      style: {
        fontSize: '14px',
        fontFamily: 'Baloo 2',
        color: '#e1e5ea'
      }
    },
    responsive: [{
      breakpoint: 400,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  };

  var donut = new ApexCharts(document.querySelector("#donut"), options);
  donut.render();

}, false);