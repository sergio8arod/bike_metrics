<img src="<?php echo base_url('images/ajax-loader.gif')?>" id="loading" style="position:absolute; top:50%; right:50%;"/>
<div class="panel panel-default">
    <div class="panel-heading"><h1>Ingresos por Fecha</h1></div>
    <div class="panel-body">
        <form data-bind="submit:filterChart" class="form-inline">
            <div class="form-group">
                <label for="from">From</label>
                <input data-bind="value:from" type="date" class="form-control" id="from">
            </div>
            <div class="form-group">
                <label for="to">To</label>
                <input data-bind="value:to" type="date" class="form-control" id="to">
            </div>
            <button type="submit" class="btn btn-default">Filtrar</button>
        </form>
        <div id="TotalAccess" style="height: 10px; text-align: right; display: block; margin-bottom: 10px;"></div>
        <div id="myfirstchart" style="height: 250px;"></div>
    </div>
</div>