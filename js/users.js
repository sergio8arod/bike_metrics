$(document).ready(function(){
   //Fetch data via AJAX
   $.getJSON(site_url('users/fetch'),function(bikes){
       $('#users').DataTable({
           "language": {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
           responsive: true,
           data: bikes,
           columns: [
               {
                    data: 'client_id',
                    title: 'Cliente',
                    responsivePriority: 10,
                   render: function(data){
                       return getName(data);
                   }
               },       
               {
                   data: 'full_name',
                   title: 'Nombre completo',
                   responsivePriority: 1
               },
               {
                   data: 'identification',
                   title: 'Identificacion',
                   responsivePriority: 1
               },
               {
                   data: 'email',
                   title: 'email',
                   responsivePriority: 2
               },
               {
                   data: 'birthdate',
                   title: 'Fecha nacimiento',
                   responsivePriority: 4
               },
               {
                   data: 'gender',
                   title: 'Genero',
                   responsivePriority: 5
               },
               {
                   data: 'd_home',
                   title: 'Distancia al trabajo',
                   responsivePriority: 3
               },
               {
                   data: 'mant_frecuency',
                   title: 'Frecuencia mantenimiento',
                   responsivePriority: 6,
                   render: function(data){
                       result = "";
                       switch(parseInt(data))
                       {
                           case 0:
                               result = "3 meses";
                               break;
                           case 1:
                               result = "6 meses";
                               break;
                           case 2:
                               result = "1 año";
                               break;
                           case 3:
                               result = "Cuando algo se daña";
                               break;
                       }
                       return result;
                   }
               },
               {
                   data: 'drbici',
                   title: 'Dr. Bici',
                   responsivePriority: 5,
                   render: function(data){
                      return data==="0" ? "Si":"No";
                   }
               },
               {
                   data:'id',
                   title:'Editar',
                   orderable: false,
                   searchable: false,
                   responsivePriority: 20,
                   visible: false,
                   render: function(data,type,full,meta){
                       return '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#editModal" data-id="' + data + '" aria-label="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
                   }
               }
           ],
           order:[[0,"desc"]]
       });
       $("#loading").hide();
   });   
   var bikeViewModel = { 
        user_id: ko.observable(),
        EPC: ko.observable(),
        bike_type: ko.observable(),
        brand: ko.observable(),
        id: ko.observable(),
        saveBike:function(){
            var data = ko.toJSON(bikeViewModel);
            $.post(site_url('bikes/save'),data,function(message){
                if(message==='Success'){
                    //Load up the table api
                    var table = $('#bikes').DataTable();
                    //Get the row using the id
                    var row = table.row('#id_' + bikeViewModel.id());
                    //Set up the data
                    data = {
                        user_id: bikeViewModel.user_id(),
                        EPC: bikeViewModel.EPC(),
                        bike_type: bikeViewModel.bike_type(),
                        brand: bikeViewModel.brand()
                    };
                    //Set the data from the observables
                    row.data(data);
                    //Redraw the table
                    table.draw();
                    //Toggle the modal
                    $("#editModal").modal('toggle');
                }else{
                    alert(message);
                }
            });
        }
    };
    //Activate Knockout
    ko.applyBindings(bikeViewModel);
    
    $('#editModal').on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);//Button that triggeres the modal
       var id = button.data('id'); //Extract info from data-* attributes
              
       //Load up table api
       var table= $('#bikes').DataTable();
       //Get the row using the id
       var row= table.row('#id_' + id);
       //Get the data (purchase) from the row
       var bike= row.data();
       //Update observables
       bikeViewModel.user_id(bike.user_id);
       bikeViewModel.EPC(bike.EPC);
       bikeViewModel.bike_type(bike.bike_type);
       bikeViewModel.brand(bike.brand);
       bikeViewModel.id(bike.id);
   });
});