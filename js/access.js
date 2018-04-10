$(document).ready(function(){
   //Fetch data via AJAX
   $.getJSON(site_url('access/fetch'),function(access){
       $('#access').DataTable({
           "language": {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
           responsive: true,
           data: access,
           columns: [
               {
                    data: 'access_time',
                    title: 'Fecha Ingreso',
                    responsivePriority: 1
               },       
               {
                   data: 'full_name',
                   title: 'Usuario',
                   responsivePriority: 1
               },
               {
                   data: 'brand',
                   title: 'Marca bici',
                   responsivePriority: 2
               },
               {
                   data: 'address',
                   title: 'Ubicacion',
                   responsivePriority: 3
               },
               {
                   data:'id',
                   title:'Editar',
                   orderable: false,
                   searchable: false,
                   visible: false,
                   responsivePriority: 1,
                   render: function(data,type,full,meta){
                       return '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#editModal" data-id="' + data + '" aria-label="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
                   }
               }
           ],
           order:[[0,"desc"]]
       });
       $("#loading").hide();
   });   
});