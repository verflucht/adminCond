<?php
	header('Access-Control-Allow-Origin: *');
	date_default_timezone_set('Chile/Santiago');
    ob_start();
    error_reporting(E_ALL); 
	ini_set('display_errors', 'on');
    header('Content-Type: text/html; charset=UTF-8');  
    setlocale(LC_ALL,'es_AR');
    session_start(); 

    require_once($_SESSION['mysqlConnection']);    
	mysql_query("SET NAMES 'utf8'");

    $isVendido = $_POST['isVendido'];

    $timestamp = time()-10800;

	if ($isVendido == 0) {
		$tabactive = '
					<br><ul class="nav nav-tabs nav-justified">
		        	<li role="presentation" id="0" class="active btn-ventas"><a href="#">Por Entregar</a></li>
		        	<li role="presentation" id="1" class="btn-ventas"><a href="#">Entregadas</a></li>
		        	<li role="presentation" id="3" class=""><a href="#" data-toggle="modal" data-target="#myModal"><span style="color: red;"><b>+</b> Crear Venta</span></a></li>
			        </ul>';
	}
	else{
		$tabactive = '
					<br><ul class="nav nav-tabs nav-justified">
		        	<li role="presentation" id="0" class="btn-ventas"><a href="#">Por Entregar</a></li>
		          	<li role="presentation" id="1" class="active btn-ventas"><a href="#">Entregadas</a></li>
		        	<li role="presentation" id="3" class=""><a href="#" data-toggle="modal" data-target="#myModal"><span style="color: red;"><b>+</b> Crear Venta</span></a></li>
        			</ul>';
	}
	$output_string = $tabactive.'
						<div style="padding: 30px">
						<br><table class="table table-striped custab">
		                <thead>
		                        <tr>
		                            <th class="text-left">Nombre</th>
		                            <th class="text-left">Fecha</th>
		                            <th class="text-left">Lugar</th>
		                            <th class="text-left">Telefono</th>
		                            <th class="text-left">Comentario</th>
		                            <th class="text-left">Productos</th>
		                            <th class="text-left"></th>
		                        </tr>
		                </thead>';

    //seleccionar todas las ventas del sistema
    $idventas = 'SELECT id_ventas FROM ventas WHERE vendido='.$isVendido.' ORDER BY fecha';

    $result= @mysql_query($idventas);
    if ($result == FALSE) { die(@mysql_error()); }
   
    while($row = mysql_fetch_array($result)){
        $count = 0;
        $array = array();                 
        $productos = 'SELECT *
        	FROM desc_venta
        	INNER JOIN ventas ON desc_venta.id_venta = ventas.id_ventas
        	INNER JOIN productos ON desc_venta.id_producto = productos.id
        	WHERE ventas.id_ventas='.$row['id_ventas'].' ORDER BY id_ventas';

        $result2= @mysql_query($productos);
        if ($result2 == FALSE) { die(@mysql_error()); }
        
        if (mysql_num_rows($result2) > 0) {
	        while($row2 = mysql_fetch_array($result2)){
	            if (strtoupper($row2['marca']) == "LIFESTYLES"){
	                $row2['marca'] = "[LF]";
	            } 
	            
	            $time = strtotime($row2['fecha']);
	            if ($isVendido == 1)
	            	$claseMarcada = "success";
		        elseif ($time < $timestamp) //si es mayor a 1 dia, estamos pasados en la venta y la marcará en rojo
	              $claseMarcada = "danger";
	            elseif ($time - $timestamp <= 18000)
	              $claseMarcada = "success";
	            else
	              $claseMarcada = "";  

	            if ($count == 0){
	                $count = 1;
	                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	                $output_string .= '
	                    <tr class="'.$claseMarcada.'"> 
		                    <td style="text-align: left;" class="col-sm-2">'.strtoupper($row2['cliente']).'</td>
		                    <td style="text-align: center" class="col-sm-2">'.$dias[date('w', $time)].' '.date('d', $time).' de '.$meses[date('n', $time)-1].' <br><span style="color: black;">'.date('G:i', $time).'<span></td>
		                    <td style="text-align: left" class="col-sm-1">'.$row2['lugar'].'</td>
		                    <td style="text-align: left" class="col-sm-1">'.$row2['telefono'].'</td>
		                    <td style="text-align: left" class="col-sm-2">'.$row2['comentarios'].'</td>
		                    <td style="text-align: left" class="col-sm-2"><strong>'.strtoupper($row2['marca']).'</strong> '.strtoupper($row2['nombre']).': <strong>'.$row2['cantidad'].'</strong><br>';
	            }
	            else{
	                $output_string .= '<strong>'.strtoupper($row2['marca']).'</strong> '.strtoupper($row2['nombre']).': <strong>'.$row2['cantidad'].'</strong><br>';
	            }
	        $idventas = $row2['id_ventas'];
	        $total = $row2['totalventa']; 
	        }
	        if ($isVendido == 0)
	        {
	        	$output_string .= 
	        	        	'</td>
	        	          	</td>
	        	                <td style="text-align: left" class="col-sm-1">
	        	                	<a id="'.$idventas.'" class="btn btn-success btn-lg btn-vender col-sm-12">
	        	                        <span class="glyphicon glyphicon-thumbs-up"></span> Vendido</a> 
	        	                    <a id="'.$idventas.'" class="btn btn-info btn-xs btn-loadeditarcol-sm-5">
	        	                        <span class="glyphicon glyphicon-edit"></span> Editar</a>
	        	                    <a id="'.$idventas.'" class="btn btn-danger btn-xs btn-cancelar-venta col-sm-7">
	        	                        <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
	        	                </td></tr>
	        	        ';
			}
	        else
	        	$output_string .= '<td style="text-align: left" class="col-sm-1">
    		                        	<span class="suma">$'.number_format($total, "0", ",", ".").'</span>
	        		                </td></tr>';
           	unset($array);
	    }
	}         
	$output_string .= '</table></div>';	
	echo $output_string;

?>
