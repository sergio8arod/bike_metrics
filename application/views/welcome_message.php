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
    <link href="<?php echo base_url('css/signin.css');?>" rel="stylesheet"

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-light bg-faded" style="background-color: #ededed; border-bottom: 5px solid #50B848; margin-bottom: 10px;">
        <a class="navbar-brand" href="#">
            <img src="<?php echo base_url('images/logo.png');?>" height="50" class="d-inline-block align-center" alt="">
            Métricas bicis particulares
        </a>
    </nav>
    <div class="container">

        <form data-bind="submit: doLogin" class="form-signin">
        <h2 class="form-signin-heading">Ingreso</h2>
        <div data-bind="visible: shouldShowAlert" class="alert alert-danger" style="display:none;" role="alert">Email o contraseña incorrectos</div>
        <label for="inputEmail" class="sr-only">Email</label>
        <input data-bind="textInput: inputEmail" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input data-bind="textInput: inputPassword" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <!--<div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
        <button data-bind="click: register" class="btn btn-lg btn-primary btn-block" type="button" id="register">Registrarse</button>
      </form>

    </div> <!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 
    <script src="<?php echo base_url('js/welcome_message.js');?>"></script>
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