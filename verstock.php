<?php 

    header('Access-Control-Allow-Origin: *');
    ob_start();
    error_reporting(E_ALL); 
    ini_set('display_errors', 'on');
    header('Content-Type: text/html; charset=UTF-8');  
    session_start(); 
    
    require_once($_SESSION['mysqlConnection']); //Archivo para realizar las conexiones.    
    
    mysql_query("SET NAMES 'utf8'");
    $sqlSyntax= 'SELECT * FROM productos ORDER BY disponible DESC';
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

    <script type="text/javascript">
    $(document).ready(function(){
      $(".btn-info").on('click', function() {
        //var busqueda = $("td.id").text();
        var id = this.id
        var agregar = $('#id_'+id).val()
        // Returns successful data submission message when the entered information is stored in database.
        if (agregar == ''){
          alert('Debe elegir un monto para agregar');
        }
        else{
          // Codigo AJAX para realizar la busqueda asincronica con la base de datos.
          $.ajax({
          type: "POST",
          url: "agregar.php",
          data: {agregar:agregar,id:id},
          cache: false,
          success: function(result){
            if (result == ''){
              window.location.reload();
            }
            else{
              alert(result);
            }
            //  $("#lista").html(result);
            
          }
        });
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(function() {
    $('.confirm').on('click', function() {
        var id = this.id
        if (window.confirm("¿Estas seguro que deseas eliminarlo?")){
          $.ajax({
          type: "POST",
          url: "eliminar.php",
          data: {id:id},
          cache: false,
          success: function(result){
            if (result == ''){
              window.location.reload();
            }
            else{
              alert(result);
            }
          }
        });
        }
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
    <div class="row col-md-12 custyle">
        <table class="table table-striped custab">
          <thead>
                <tr>
                    <th class="text-center">Marca</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Importado</th>
                    <th class="text-center">Reservado</th>
                    <th class="text-center">Vendido</th>
                    <th class="text-center">Disponible</th>
                    <th class="text-center">Agregar Stock</th>
                    <th class="text-center">Eliminar</th>
                </tr>
          </thead>
          <?php 
              while($row = mysql_fetch_array($result)){
                if ($row['disponible'] == 0)
                  $claseMarcada = "danger";
                elseif ($row['disponible'] < 50 )
                  $claseMarcada = "warning";
                else
                  $claseMarcada = "success";

              echo'<tr class="'.$claseMarcada.'">
                  <td class="text-center">'.strtoupper($row['marca']).'</td>
                  <td class="text-center">'.strtoupper($row['nombre']).'</td>
                  <td class="text-center">'.strtoupper($row['total']).'</td>
                  <td class="text-center">'.strtoupper($row['reservado']).'</td>
                  <td class="text-center">'.strtoupper($row['vendido']).'</td>
                  <td class="text-center">'.strtoupper($row['disponible']).'</td>
                  <td class="id text-center" style="display:none">'.$row['id'].'</td>
                  <td class="text-center">
                    <input type="text" id="id_'.$row['id'].'" class="asdf" style="width: 40px; padding: 0;">
                    <a class="btn btn-info btn-xs" id="'.$row['id'].'">
                      <span class="glyphicon glyphicon-edit"></span> Agregar Stock</a>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-danger btn-xs confirm" id="'.$row['id'].'" >
                      <span class="glyphicon glyphicon-remove"></span> Eliminar Producto</a> 
                  </td>
              </tr>
              ';
            }
            ?>   
        </table>
      </div>
  </div>


</body>
</html> 