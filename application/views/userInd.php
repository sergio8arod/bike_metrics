<img src="<?php echo base_url('images/ajax-loader.gif')?>" id="loading" style="position:absolute; top:50%; right:50%;"/>
<div class="panel panel-default">
    <div class="panel-heading"><h1>Ingresos por Mes</h1></div>
    <div class="panel-body">
        <form data-bind="submit:filterChart" class="form-inline" <?php if(!isset($users)):?>style="display: none"<?php endif;?>>
            <div class="form-group">
                <label for="from">Usuario</label>
                <select data-bind="value: user_id" class="form-control">
                    <?php if(isset($users)):?>
                        <?php foreach($users as $user):?>
                            <option value="<?php echo $user->id;?>">
                                <?php echo $user->full_name;?>
                            </option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Filtrar</button>
        </form>
        <div id="TotalAccess" style="height: 10px; text-align: right; display: block; margin-bottom: 10px;"></div>
        <div id="invalid" class="alert alert-danger" role="alert">Las fechas ingresadas son invalidas</div>
        <div id="myfirstchart" style="height: 250px;"></div>
        <div id="distance" style="height: 10px; text-align: left; display: block; margin: 60px 0 10px 0;"></div>
        <div id="topUser" style="height: 10px; text-align: left; display: block; margin-bottom: 10px;"></div>
    </div>
</div>