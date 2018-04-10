$(document).ready(function(){
    // Set up chart
    chart = new Morris.Bar({
        element: 'myfirstchart',
        data: [],
        xkey: 'Fecha',
        ykeys: ['Ingresos'],
        labels: ['Ingresos'],
        barColors: ["#50B848"],
        hideHover: true,
        resize: true
    });
    $.getJSON(site_url('reports_dates/fetch'), function (data) {
        console.log(data);
        if(data.chart!='problem'){
            chart.setData(data.chart);            
        }
        var div = document.getElementById('TotalAccess');
        div.innerHTML = 'Total=' + data.total;
        $('#loading').hide();
    });
    /*$.getJSON(site_url('reports/totalAccess'), function (data) {
        console.log(data);
        
        div.innerHTML = 'Total=' + data
        $('#loading').hide();
    });*/
    // Set up view model
    var myViewModel = {
        from: ko.observable(),
        to: ko.observable(),
        filterChart: function (formElement) {
            // Show the spinner
            $('#loading').show();
            
            // Get json of the data
            json = ko.toJSON(myViewModel);
            // Post json to controller
            $.post(site_url('reports_dates/fetchd'), json, function (data) {
                console.log(data);
                $('#loading').hide();
                if (data !== 'problem') {
                    $('#invalid').hide();
                    chart.setData(data);
                } else {
                    $('#invalid').show();
                }
            });
        }
    };
    // Activate Knockout
    ko.applyBindings(myViewModel);
});

/*new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});*/