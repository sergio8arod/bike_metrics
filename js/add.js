function getToday(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0
    var yyyy = today.getFullYear();
    if(dd<10){
        dd = '0' + dd;
    }
    if(mm<10){
        mm = '0' + mm;
    }
    return yyyy + '-' + mm + '-' + dd;
}

$( document ).ready(function() {
    var addViewModel = { 
        user_id: ko.observable(),
        EPC: ko.observable(),
        bike_type: ko.observable(),
        brand: ko.observable(),
        saveBike:function(){
            //alert('Prueba');
            var data = ko.toJSON(addViewModel);
            //alert(data);
            $.post(site_url('add/save'),data,function(message){
                if(message==='Success'){
                    addViewModel.user_id('');
                    addViewModel.EPC('');
                    addViewModel.bike_type('');
                    addViewModel.brand('');
                }else{
                    //alert(message);
                }
            });
        }
    };
    //Activate Knockout
    ko.applyBindings(addViewModel);
    
});