<?php 
  session_start();
  $RAIZ = getcwd(); 
  $_SESSION['mysqlConnection'] = $RAIZ.'/conexion/mysqlConnection.php';
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Stock Condones</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="img/ico.png" />
    <!-- Latest compiled and minified CSS -->
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/nav.css">

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
    <div class="container side-collapse-container">
      <div class="row">
        
      </div>
    </div>


</body>
</html>