$( document ).ready(function() { 
    var applied = false;
      
    //Set up our view model 
    var settingsViewModel = { 
        favorite: ko.observable(),
        saveSettings:function(){
            //Convert model to JSON
            var data = ko.toJSON(this);
            //POST the data using AJAX
            $.post(site_url('settings/savesettings'),data,function(message){
                alert(message);
            });
        }
    };
    //Activate Knockout
    if (!applied) {
        ko.applyBindings(settingsViewModel);
        applied = true;
    }
    
    //Fetch current settings from database
    $.getJSON(site_url('settings/getsettings'),function(settings){
        //alert(settings.favorite);
        settingsViewModel.favorite(settings.favorite);
        
    });
});