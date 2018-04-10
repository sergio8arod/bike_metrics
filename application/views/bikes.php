<img src="<?php echo base_url('images/ajax-loader.gif')?>" id="loading" style="position:absolute; top:50%; right:50%;"/>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Actualizar bici</h4>
      </div>
      <div class="modal-body">
        <form data-bind="submit: saveBike">
            <div class="form-group">
                <label for="user">Usuario</label>
                <select data-bind="value: user_id" class="form-control">
                    <option value="0">- Selecciona un usuario -</option>
                    <?php if(isset($users)):?>
                    <?php foreach($users as $user):?>
                        <option value="<?php echo $user->id;?>">
                            <?php echo $user->full_name;?>
                        </option>
                    <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <div class="form-group">
                <label for="EPC">Etiqueta</label>
                <input data-bind="textInput: EPC" type="input" class="form-control" id="EPC"/>
            </div>
            <div class="form-group">
                <label for="bike_type">Tipo de bici</label>
                <select data-bind="value: bike_type" class="form-control">
                    <option value="">- Selecciona el tipo de bici -</option>
                    <option value="Urbana">Urbana</option>
                    <option value="Montaña">Montaña</option>
                    <option value="Ruta">Ruta</option>
                    <option value="Plegable">Plegable</option>
                    <option value="Fija">Fija</option>
                    <option value="Single speed">Single speed</option>
                    <option value="Eléctrica">Eléctrica</option>
                    <option value="BMX">BMX</option>
                    <option value="Fat bike">Fat bike</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="brand">Marca</label>
                <input data-bind="textInput: brand" type="input" class="form-control" id="brand" />
            </div>
            <button type="submit" class="btn btn-default">Guardar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1>Bicis</h1>
<table id="bikes" class="table"></table>
<script>
    function getName(id) {
        switch (id) {
            <?php foreach($users as $user): ?>
            case '<?php echo $user->id; ?>':
            return '<?php echo $user->full_name; ?>';
            break;
            <?php endforeach; ?>
            default:
            return null;
        }
    }
</script>