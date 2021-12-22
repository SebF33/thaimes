document.addEventListener('DOMContentLoaded', function () {

  const dates = Object.keys(commentLast30Days);
  const values = Object.values(commentLast30Days);

  var options = {
    series: [{
      name: "Participation(s)",
      data: values
    }],
    chart: {
      type: 'area',
      height: 350,
      zoom: {
        enabled: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight'
    },

    title: {
      text: 'Chart',
      align: 'left'
    },
    subtitle: {
      text: 'Participation(s) last 30 days',
      align: 'left'
    },
    labels: dates,
    xaxis: {
      type: 'datetime',
    },
    yaxis: {
      opposite: true
    },
    legend: {
      horizontalAlign: 'left'
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();

}, false);