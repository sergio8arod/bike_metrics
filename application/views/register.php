<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
          
    <title>Bike metrics</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url('css/ie10-viewport-bug-workaround.css');?>" rel="stylesheet"

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('css/register.css');?>" rel="stylesheet"

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-light bg-faded" style="background-color: #ededed; border-bottom: 5px solid #50B848; margin-bottom: 10px;">
        <a class="navbar-brand" href="<?php echo site_url('welcome/index'); ?>">
            <img src="<?php echo base_url('images/logo.PNG');?>" height="50" class="d-inline-block align-center" alt="">
            Métricas bicis particulares
        </a>
    </nav>
    <div class="container">
        <form data-bind="submit: saveNewUser">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input data-bind="textInput: inputEmail" type="email" class="form-control" id="inputEmail" placeholder="Email" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword">Contraseña</label>
                    <input data-bind="textInput: inputPassword" type="password" class="form-control" id="inputPassword" placeholder="Contraseña" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Nombre completo</label>
                    <input data-bind="textInput: inputName" type="text" class="form-control" id="inputName" placeholder="Nombre completo" required data-error-msg="Must enter your name?">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputIdentification">Identificación</label>
                    <input data-bind="textInput: inputIdentification" type="text" class="form-control" id="inputIdentification" placeholder="1030266xxx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="inputAddress">Dirección</label>
                    <input data-bind="textInput: inputAddress" type="text" class="form-control" id="inputAddress" placeholder="Cl. 71 # 17 - 39" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputGender">Genero</label>
                    <select data-bind="value: inputGender" id="inputGender" class="form-control" style="height: 40px" required>
                        <option value="" selected disabled>Selecciona tu genero</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputBirthdate">Fecha de nacimiento</label>
                    <input data-bind="textInput: inputBirthdate" type="date" class="form-control" id="inputBirthdate" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputCellphone">Celular</label>
                    <input data-bind="textInput: inputCellphone" type="text" maxlength="10" class="form-control" id="inputCellphone" placeholder="30012345xx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputEntity">Entidad</label>
                    <select data-bind="value: inputClientID, event: {change: clientDefined}" class="form-control" id="inputEntity" style="height: 40px" required>
                        <option value="" selected disabled>- Selecciona tu empresa/universidad -</option>
                        <?php if(isset($clients)):?>
                            <?php foreach($clients as $client):?>
                                <option value="<?php echo $client->id;?>">
                                    <?php echo $client->name;?>
                                </option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputVinculation">Vicepresidencia/Vinculación</label>
                    <select data-bind="value: inputVinculation" class="form-control" id="inputVinculation" style="height: 40px">
                        <option value="" selected disabled>- Selecciona tu cargo/vinculación -</option>
                        <?php if(isset($vinculations)):?>
                            <?php foreach($vinculations as $vinculation):?>
                                <option value="<?php echo $vinculation->id;?>">
                                    <?php echo $vinculation->name;?>
                                </option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div data-bind="visible: divFaculty" class="form-group col-md-4">
                    <label for="inputFaculty">Facultad</label>
                    <select data-bind="value: inputFaculty" class="form-control" id="inputFaculty" style="height: 40px">
                        <option value="" selected disabled>- Selecciona tu facultad -</option>
                        <?php if(isset($faculties)):?>
                            <?php foreach($faculties as $faculty):?>
                                <option value="<?php echo $faculty->id;?>">
                                    <?php echo $faculty->name;?>
                                </option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="inputMantFrec">Frecuencia de mantenimiento</label>
                    <select data-bind="value: inputMantFrec" id="inputMantFrec" class="form-control" style="height: 40px" required>
                        <option value="" selected disabled>¿Con qué frecuencia haces mantenimiento a tu bici?</option>
                        <option value="0">3 meses</option>
                        <option value="1">6 meses</option>
                        <option value="2">1 año</option>
                        <option value="3">Cuando algo se daña</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="inputDrBici">Dr. bici</label>
                    <select data-bind="value: inputDrBici" id="inputDrBici" class="form-control" style="height: 40px" required>
                        <option value="" selected disabled>¿Traerias tu bici a mantenimiento en la oficina?</option>
                        <option value="0">Si</option>
                        <option value="1">No</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="map">Arrastra el marcador a tu lugar de residencia</label>
                <div id="map"></div>
                <input data-bind="textInput: inputDistance" type="hidden">
                <input data-bind="textInput: inputClientLat" type="hidden">
                <input data-bind="textInput: inputClientLng" type="hidden">
                <input data-bind="textInput: ipTerms" type="hidden">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input data-bind="checked: inputTerms" class="form-check-input" type="checkbox" id="inputTerms" required> Acepto los <a href="" target="_blank">terminos y condiciones </a
                    </label>
                </div>
            </div>
            <div id="errorMessage" data-bind="visible: shouldShowAlert" class="alert alert-danger" style="display:none;" role="alert">Alguno de los datos no es valido</div>
            <button type="submit" class="btn btn-primary">Registrarme</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK9CZMnZ8J2MYIu-00ob3fHGi8-EXRnP0&callback=initMap" type="text/javascript"></script>
    <script src="<?php echo base_url('js/register.js');?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url('js/ie10-viewport-bug-workaround.js');?>" rel="stylesheet"
          
    <!-- PHP-driven JavaScript Utility Functions --> 
    <script> 
        function base_url(params) { 
            return '<?php echo base_url(); ?>' + params;
        }
        function site_url(params) {
            return '<?php echo site_url(); ?>' + '/' + params;
        }
    </script>

    </body>
</html>