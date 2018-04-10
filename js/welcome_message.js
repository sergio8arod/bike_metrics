$( document ).ready(function() { 
    var appliedWelcome = false;
    // Set up our view model 
    var welcomeViewModel = { 
        inputEmail: ko.observable(''),
        inputPassword: ko.observable(''),
        shouldShowAlert: ko.observable(false),
        doLogin:function(){
            //Convert model to JSON
            var data = ko.toJSON(this);
            //POST the data using AJAX
            $.post(site_url('welcome/login'),data,function(response){
                console.log(response)
                if(response.message=='good'){
                    if(response.role==1){
                        //Redirect to app/index controller
                        url = site_url('add/index');
                        window.location.replace(url);
                    }else{
                        url = site_url('userInd/index');
                        window.location.replace(url);
                    }
                } else {
                    welcomeViewModel.shouldShowAlert(true);
                }
            });
        },
        register : function() {
            url = site_url('register/index');
            window.location.replace(url);
            
        }
    };
    //Activate Knockout
    if (!appliedWelcome) {
        ko.applyBindings(welcomeViewModel);
        applied = true;
    }
});