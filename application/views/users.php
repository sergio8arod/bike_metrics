<img src="<?php echo base_url('images/ajax-loader.gif')?>" id="loading" style="position:absolute; top:50%; right:50%;"/>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Actualizar usuario</h4>
      </div>
      <div class="modal-body">
        <form data-bind="submit: saveUser">
            <div class="form-group">
                <label for="client">Cliente</label>
                <select data-bind="value: client_id" class="form-control">
                    <option value="0">- Selecciona un cliente -</option>
                    <?php if(isset($clients)):?>
                    <?php foreach($clients as $client):?>
                        <option value="<?php echo $client->id;?>">
                            <?php echo $client->name;?>
                        </option>
                    <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <div class="form-group">
                <label for="full_name">Nombre completo</label>
                <input data-bind="textInput: full_name" type="input" class="form-control" id="full_name"/>
            </div>
            <div class="form-group">
                <label for="identification">Identificacion</label>
                <input data-bind="textInput: identification" type="input" class="form-control" id="identification"/>
            </div>
            <div class="form-group">
                <label for="gender">Genero</label>
                <select data-bind="value: gender" class="form-control">
                    <option value="">- Selecciona el Genero -</option>
                    <option value="male">Masculino</option>
                    <option value="female">Femenimo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input data-bind="textInput: email" type="input" class="form-control" id="email" />
            </div>
            <button type="submit" class="btn btn-default">Guardar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1>Usuarios</h1>
<table id="users" class="table"></table>
<script>
    function getName(id) {
        switch (id) {
            <?php foreach($clients as $client): ?>
            case '<?php echo $client->id; ?>':
            return '<?php echo $client->name; ?>';
            break;
            <?php endforeach; ?>
            default:
            return null;
        }
    }
</script>