$( document ).ready(function() { 
    // Set up our view model 
    var userViewModel = { 
        inputEmail: ko.observable(''),
        inputPassword: ko.observable(''),
        inputName: ko.observable(''),
        inputIdentification: ko.observable(''),
        inputAddress: ko.observable(''),
        inputGender: ko.observable(''),
        inputBirthdate: ko.observable(''),
        inputCellphone: ko.observable(''),
        inputClientID: ko.observable(''),
        inputVinculation: ko.observable(''),
        divFaculty: ko.observable(false),
        inputFaculty: ko.observable(''),
        inputMantFrec: ko.observable(''),
        inputDrBici: ko.observable(''),
        inputClientLat: ko.observable(''),
        inputClientLng: ko.observable(''),
        inputDistance: ko.observable(''),
        divMap: ko.observable(false),
        shouldShowAlert: ko.observable(false),
        saveUser: function(){
            if(userViewModel.inputDistance()=='')
            {
                userViewModel.inputDistance(getDistanceFromLatLonInKm(userViewModel.inputClientLat(),userViewModel.inputClientLng(),marker.getPosition().lat(),marker.getPosition().lng()));
            }
            console.log(userViewModel.inputDistance());
            
            //Convert model to JSON
            var data = ko.toJSON(this);
            //POST the data using AJAX
            $.post(site_url('userModify/save'),data,function(message){
                console.log(message);
                if(message=='Success'){
                    //Redirect to welcome/index controller
                    url = site_url('userInd/index');
                    window.location.replace(url);
                } else {
                    var divError = document.getElementById('errorMessage');
                    divError.innerHTML = message;
                    userViewModel.shouldShowAlert(true);
                }
            });
        },
        chgAddres : function() {
            userViewModel.divMap(true);
            
            initMap();
            var Clientlatlng = {lat: userViewModel.inputClientLat(), lng: userViewModel.inputClientLng()};
            recenterMap(Clientlatlng);
            userViewModel.inputDistance('');
        }
    };
    //Activate Knockout
    ko.applyBindings(userViewModel);
    
    data=0;
    $.post(site_url('userModify/fetch'),data,function(response){
        console.log(response);
        if(response.message==='university'){
            loadlist(inputVinculation,response.vinculations,"id","name");
            userViewModel.divFaculty(true);
            loadlist(inputFaculty,response.faculties,"id","name");
            userViewModel.inputClientLat(Number(response.lat));
            userViewModel.inputClientLng(Number(response.lng));
        }else if(response.message==='company'){
            loadlist(inputVinculation,response.vinculations,"id","name");
            userViewModel.divFaculty(false);               
            userViewModel.inputClientLat(Number(response.lat));
            userViewModel.inputClientLng(Number(response.lng));
        }else{
            userViewModel.divFaculty(false);
            //alert('El cliente seleccionado es invalido');
        }
        
        user = response.user;
        userViewModel.inputEmail(user.email);
        userViewModel.inputName(user.full_name);
        userViewModel.inputIdentification(user.identification);
        userViewModel.inputAddress(user.address);
        userViewModel.inputGender(user.gender);
        userViewModel.inputBirthdate(user.birthdate);
        userViewModel.inputCellphone(user.cellphone);
        userViewModel.inputClientID(user.client_id);
        userViewModel.inputVinculation(user.vinculation);
        userViewModel.inputFaculty(user.faculty);
        userViewModel.inputMantFrec(user.mant_frecuency);
        userViewModel.inputDrBici(user.drbici);
        userViewModel.inputClientLat(response.lat);
        userViewModel.inputClientLng(response.lng);
        userViewModel.inputDistance(user.d_home);
    });
    
});

function initMap() {
        var bogota = {lat: 4.648926, lng: -74.078412};
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 13,
		center: bogota
	});
	
	marker = new google.maps.Marker( {
		map     : map,
		draggable: true,
		animation: google.maps.Animation.DROP,
		position: bogota
	});
	
	
	//map.setCenter(clientlatlng);
	marker.addListener('click', toggleBounce);
	marker.addListener('dragend', markerPosition);
}

function toggleBounce() {
	if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	} else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}
      
function markerPosition() {
	var lat=marker.getPosition().lat();
        //alert(getDistanceFromLatLonInKm(4.648926,-74.078412,marker.getPosition().lat(),marker.getPosition().lng()));
	return marker;
}
function recenterMap(latlng) {
	//alert("lat: "+clientlatlng.lat()+", lng: "+clientlatlng.lng());
	map.setCenter( latlng );
	marker.setPosition(latlng);
	return;
}

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  if(d<0.5) {
      d=0;
  } else if(d>=0.5 && d<1) {
      d=1;
  } else if(d>1 && d<3) {
      d=Math.floor(d);
  } else {
      d=Math.floor(d)+2;
  }
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

function loadlist(selobj,data,idattr,nameattr)
{
    //Clear the selected object
    $(selobj).empty();
    //append the values
    $(selobj).append('<option value="" selected disabled>- Selecciona tu cargo/vinculación -</option>')
    console.log(data);
    $.each(data, function(i,obj)
    {
        $(selobj).append(
            $('<option></option>')
                    .val(obj[idattr])
                    .html(obj[nameattr])
        );
    });
}