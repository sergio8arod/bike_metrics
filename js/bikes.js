$(document).ready(function(){
   //Fetch data via AJAX
   $.getJSON(site_url('bikes/fetch'),function(bikes){
       $('#bikes').DataTable({
           "language": {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
           responsive: true,
           data: bikes,
           columns: [
               {
                    data: 'user_id',
                    title: 'Usuario',
                    responsivePriority: 1,
                   render: function(data){
                       return getName(data);
                   }
               },       
               {
                   data: 'EPC',
                   title: 'Etiqueta',
                   responsivePriority: 1
               },
               {
                   data: 'bike_type',
                   title: 'Tipo bici',
                   responsivePriority: 5
               },
               {
                   data: 'brand',
                   title: 'Marca',
                   responsivePriority: 10
               },
               {
                   data:'id',
                   title:'Editar',
                   orderable: false,
                   searchable: false,
                   responsivePriority: 1,
                   render: function(data,type,full,meta){
                       return '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#editModal" data-id="' + data + '" aria-label="Edit"><span class="glyphicon">&#x270f;</span></span></button>';
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