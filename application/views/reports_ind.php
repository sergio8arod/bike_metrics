<img src="<?php echo base_url('images/ajax-loader.gif')?>" id="loading" style="position:absolute; top:50%; right:50%;"/>
<div class="panel panel-default">
    <div class="panel-heading"><h1>Indicadores</h1></div>
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
        <div style="margin-top: 10px; text-align: center;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;">Indicador</th>
                        <th scope="col" style="text-align: center;">Último mes</th>
                        <th scope="col" style="text-align: center;">Acumulado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="7">*Al filtrar, los valores salen en la columna de último mes</td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th scope="row"><img src="<?php echo base_url('images/ind_viajes.png');?>" alt="Número de viajes" height="80" style="display: block; margin: auto;"></th>
                        <td data-title="Último mes"><div id="viaje1"></div></td>
                        <td data-title="Acumulado"><div id="viaje2"></div></td>
                    </tr>
                    <tr>
                        <th scope="row"><img src="<?php echo base_url('images/ind_km.png');?>" alt="Distancia" height="80" style="display: block; margin: auto;"></th>
                        <td data-title="Último mes"><div id="km1"></div></td>
                        <td data-title="Acumulado"><div id="km2"></div></td>
                    </tr>
                    <tr>
                        <th scope="row"><img src="<?php echo base_url('images/ind_co2.png');?>" alt="CO2" height="80" style="display: block; margin: auto;"></th>
                        <td data-title="Último mes"><div id="co1"></div></td>
                        <td data-title="Acumulado"><div id="co2"></div></td>
                    </tr>
                    <tr>
                        <th scope="row"><img src="<?php echo base_url('images/ind_tiempo.png');?>" alt="Tiempo" height="80" style="display: block; margin: auto;"></th>
                        <td data-title="Último mes"><div id="tiempo1"></div></td>
                        <td data-title="Acumulado"><div id="tiempo2"></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>