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
    <?php if(isset($styles)):?>
        <?php foreach($styles as $style):?>
            <script src="<?php if(isset($styles));?>"></script>
        <?php endforeach;?>
    <?php endif;?>    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
      <nav class="navbar navbar-light bg-faded" style="background-color: #ededed; height: 50">
    </nav>
      <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #00854A; margin-bottom: 10px;">
          <a class="navbar-brand" href="<?php echo site_url('add/index'); ?>">
            <img src="<?php echo base_url('images/logo_white.PNG');?>" height="50" class="d-inline-block align-center" alt="">
          </a>
          <!-- <div class="container-fluid"> -->
              <!-- Brand and toggle get grouped for better mobile display -->
              <!-- <div class="navbar-header"> -->
                  <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#bikeMetricsNav" aria-controls="bikeMetricsNav" aria-expanded="false" aria-label="Toggle navigation"> 
                      <span class="navbar-toggler-icon"></span>
                  </button> 
                  
              <!-- </div> -->
              <!-- Collect the nav links, forms, and other content for toggling --> 
              <div class="navbar-collapse collapse" id="bikeMetricsNav"> 
                  <ul class="navbar-nav mr-auto"> 
                      <?php if(isset($modules)):?>
                        <?php foreach($modules as $module):?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url($module['href']);?>"><?php echo $module['name'];?></a>
                            </li>
                        <?php endforeach;?>
                      <?php endif;?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="dropdown_reports" data-toggle="dropdown" aria-hashpopup="true" aria-expanded="false">
                                    Reportes
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown_reports">
                                    <a class="dropdown-item" href="<?php echo site_url('reports_users/index'); ?>">Usuarios</a>
                                    <a class="dropdown-item" href="<?php echo site_url('reports_dates/index'); ?>">Fechas</a>
                                    <a class="dropdown-item" href="<?php echo site_url('reports_ind/index'); ?>">Indicadores</a>
                                    <a class="dropdown-item" href="<?php echo site_url('userind_admin/index'); ?>">Ingresos usuario</a>
                                </div>
                            </li>
                  </ul>
                  <ul class="navbar-nav navbar-right">
                      <li><a class="nav-link" href="<?php echo site_url('welcome/logout'); ?>">Salir</a></li> 
                  </ul> 
              </div> 
          <!-- </div> -->
      </nav>

      <div class="container">
          