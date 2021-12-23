document.addEventListener('DOMContentLoaded', function () {

  const dates = Object.keys(commentLast30Days);
  const values = Object.values(commentLast30Days);

  var options = {
    colors: ['#bd150b'],
    series: [{
      name: "Participations",
      data: values
    }],
    chart: {
      fontFamily: 'Baloo 2',
      foreColor: '#e1e5ea',
      type: 'area',
      height: 420,
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
    tooltip: {
      fillSeriesColor: true,
      style: {
        fontSize: '16px'
      }
    },
    title: {
      text: 'Participations (nb)',
      align: 'left',
      style: {
        fontSize: '20px',
        fontWeight: 'bold',
        fontFamily: 'Baloo 2',
        color: '#e1e5ea'
      }
    },
    subtitle: {
      text: 'Last 30 days',
      align: 'left',
      style: {
        fontSize: '14px',
        fontFamily: 'Baloo 2',
        color: '#e1e5ea'
      }
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

  var area = new ApexCharts(document.querySelector("#area"), options);
  area.render();

}, false);