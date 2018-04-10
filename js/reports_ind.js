$(document).ready(function(){
    $.getJSON(site_url('reports_ind/fetch'), function (data) {
        console.log(data);
        var divV1 = document.getElementById('viaje2');
        divV1.innerHTML = data.totalTravel;
        var divV2 = document.getElementById('viaje1');
        divV2.innerHTML = data.monthTravel;
        var divK1 = document.getElementById('km2');
        divK1.innerHTML = data.totalDistance;
        var divK2 = document.getElementById('km1');
        divK2.innerHTML = data.monthDistance;
        var div = document.getElementById('co2');
        div.innerHTML = Math.floor(data.totalDistance*0.14*100)/100;
        var div = document.getElementById('co1');
        div.innerHTML = Math.floor(data.monthDistance*0.14*100)/100;
        var div = document.getElementById('tiempo2');
        div.innerHTML = Math.floor(data.totalDistance*2.5/(60*24)*100)/100;
        var div = document.getElementById('tiempo1');
        div.innerHTML = Math.floor(data.monthDistance*2.5/(60*24)*100)/100;
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
            $.post(site_url('reports_ind/fetchd'), json, function (data) {
                console.log(data);
                var divV2 = document.getElementById('viaje1');
                divV2.innerHTML = data.monthTravel;
                var divK2 = document.getElementById('km1');
                divK2.innerHTML = data.monthDistance;
                var div = document.getElementById('co1');
                div.innerHTML = Math.floor(data.monthDistance*0.14*100)/100;
                var div = document.getElementById('tiempo1');
                div.innerHTML = Math.floor(data.monthDistance*2.5/(60*24)*100)/100;
                $('#loading').hide();
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