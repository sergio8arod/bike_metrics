$(document).ready(function(){
    $('#invalid').hide();
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
    user_session = 0;
    $.getJSON(site_url('userInd/fetch'), function (data) {
        console.log(data);
        user_session = data.user_id;
        if(data.chart!='problem'){
            chart.setData(data.chart);            
        }
        var divTotal = document.getElementById('TotalAccess');
        divTotal.innerHTML = 'Total=' + data.total;
        var divDistance = document.getElementById('distance');
        divDistance.innerHTML = 'Has recorrido <b>' + data.distance + ' km</b> desde que se inicio el programa.';
        var divUser = document.getElementById('topUser');
        divUser.innerHTML = '<b>' + data.user + '</b>, es el usuario con más viajes (<b>' + data.userAccess + '</b>) del mes.';
        $('#loading').hide();
    });
    
    // Set up view model
    var myViewModel = {
        user_id: ko.observable(user_session),
        filterChart: function (formElement) {
            // Show the spinner
            $('#loading').show();
            
            // Get json of the data
            json = ko.toJSON(myViewModel);
            // Post json to controller
            $.post(site_url('userInd_admin/fetchd'), json, function (data) {
                console.log(data);
                $('#loading').hide();
                if (data !== 'problem') {
                    chart.setData(data.chart);
                    var divTotal = document.getElementById('TotalAccess');
                    divTotal.innerHTML = 'Total=' + data.total;
                    var divDistance = document.getElementById('distance');
                    divDistance.innerHTML = 'Has recorrido ' + data.distance + 'km, durante las fechas seleccionadas.';
                    $('#invalid').hide();
                } else {
                    $('#invalid').show();
                }
            });
        }
    };
    // Activate Knockout
    ko.applyBindings(myViewModel);
});