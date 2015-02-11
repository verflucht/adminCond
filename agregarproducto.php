<?php 

    header('Access-Control-Allow-Origin: *');
    ob_start();
    error_reporting(E_ALL); 
    ini_set('display_errors', 'on');
    header('Content-Type: text/html; charset=UTF-8');  
    session_start(); 


    $sqlSyntax= 'SELECT * FROM productos ORDER BY nombre ASC';

    require_once($_SESSION['mysqlConnection']); //Archivo para realizar las conexiones.    
    mysql_set_charset('utf8');

    $result= @mysql_query($sqlSyntax);
    if ($result == FALSE) { die(@mysql_error()); }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin - Ver Stock</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="img/ico.png" />
    <!-- Latest compiled and minified CSS -->
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/crearventa.css">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {   
            var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });
        });
    </script>
</head>
<body>

<header role="banner" class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-left"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="navbar-inverse side-collapse in">
          <nav role="navigation" class="navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="crearventa.php">Ventas</a></li>
              <li><a href="agregarproducto.php">Agregar Producto</a></li>
              <li><a href="verstock.php">Ver Stock</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

<div class="container">
	<div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal" action="" method="post">
          <fieldset>
            <legend class="text-center">Agregar Producto</legend>
    
            <!-- Marca input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Marca</label>
              <div class="col-md-9">
                <input id="marca" name="marca" type="text" placeholder="Lifestyles, Durex, etc..." class="form-control">
              </div>
            </div>
    
            <!-- Producto input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="producto">Modelo</label>
              <div class="col-md-9">
                <input id="producto" name="producto" type="text" placeholder="Ingresa el modelo..." class="form-control">
              </div>
            </div>
    
            <!-- Descripcion body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="descripcion">Descripción</label>
              <div class="col-md-9">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Este preservativo..." rows="3"></textarea>
              </div>
            </div>

            <!-- Cantidad -->
			<div class="form-group">
              <label class="col-md-3 control-label" for="cantidad">Cantidad</label>
              <div class="col-md-3">
                <input id="cantidad" name="cantidad" type="number" placeholder="" class="form-control">
              </div>
            </div>

           <!-- Imagen -->
			<div class="form-group">
              <label class="col-md-3 control-label" for="imagen">Imagen</label>
              <div class="col-md-9">
                <input id="imagen" name="cantidad" accept="image/png, image/jpeg, image/gif" type="file" class="form-control">
              </div>
            </div> 
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
	</div>
</div>

</body>
</html> 