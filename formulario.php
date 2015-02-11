<?php 
    header('Access-Control-Allow-Origin: *');
    ob_start();
    ini_set('display_errors', 'on');
    header('Content-Type: text/html; charset=UTF-8');  
    session_start(); 

    require_once($_SESSION['mysqlConnection']);
	mysql_set_charset('utf8');

	function calcularTotal($array){
    	$promo1 = 280;
    	$promo2 = 260;
    	$promo3 = 250;
    	$promoSkyn1 = 667;
    	$promoSkyn2 = 625;
    	$total = 0;
    	$qtySkyn = 0;
    	$qtyNormal = 0;
    	foreach ($array as $key => $value) {    		
    		if ($key == "13")
    			$qtySkyn += $value;
    		else
    			$qtyNormal += $value;
    	}
    	#Skyn products
		if ($qtySkyn < 15)
			$total += $qtySkyn*700;
		elseif ($qtySkyn >= 15 && $qtySkyn < 24)
			$total += $qtySkyn*$promoSkyn1;
		elseif ($qtySkyn >= 24)
			$total += $qtySkyn*$promoSkyn2;

		// Normal products
		if ($qtyNormal < 25)
			$total += $qtyNormal*300;
		elseif ($qtyNormal >= 25 && $qtyNormal < 50)
			$total += $qtyNormal*$promo1;
		elseif ($qtyNormal >= 50 && $qtyNormal < 100)
			$total += $qtyNormal*$promo2;
		elseif($qtyNormal >= 100)
			$total += $qtyNormal*$promo3;
		
		return $total;
    }

	$id_dsc = rand (1, 99999);
    $array = array();                 

	$cliente = $_GET['nombre'];
	$telefono = $_GET['telefono'];
	$lugar = $_GET['lugar'];
	$fecha = $_GET['fecha'];
	$comentarios = $_GET['comentarios'];	
	if ($comentarios == "") {
		$comentarios = "--";
	}

	echo $fecha;

	//por cada elemento a vender, se llenan las tablas descripccion_venta
	foreach ($_GET['values'] as $index => $val) {
		$cantidad = intval($_GET['option'][$index]);
		$idProducto = $val; //id del producto
		
		if($idProducto != ""){
			$array[$idProducto] = $cantidad;
    //         //update de las cantidades
    //         $actualizarcantidades = "UPDATE productos SET reservado=reservado+".$cantidad." WHERE id=".$idProducto;
    //         $result2= @mysql_query($actualizarcantidades);
    //         if ($result2 == FALSE) { 
    //         	$_SESSION['error'] = @mysql_error();
				// header('Location: crearventa.php');
				// exit();
    //         }
		}
	} 
	$total = calcularTotal($array);

	//insert de la venta
	$sqlSyntax= "INSERT INTO ventas (cliente, telefono, lugar, fecha, comentarios, totalventa, vendido) VALUES('$cliente','$telefono','$lugar','$fecha', '$comentarios', '$total', 1)";
    $result= @mysql_query($sqlSyntax);
    if ($result == FALSE) { die(@mysql_error()); }

    // Obtener id venta recienmente creada
    // $idVentas = mysql_insert_id($result);
    $selecID= 'SELECT id_ventas FROM ventas ORDER BY id_ventas DESC LIMIT 1';
    $result= @mysql_query($selecID);
    if ($result == FALSE) { die(@mysql_error()); }
    $row = mysql_fetch_array($result);
    $idVentas = intval($row['id_ventas']);

	foreach ($_GET['values'] as $index => $val) {
		$cantidad = intval($_GET['option'][$index]);
		$idProducto = $val; //id del producto
		if($idProducto != ""){
			$crearDescVenta= "INSERT INTO desc_venta (id_dsc, id_venta, id_producto, cantidad) VALUES ('$id_dsc', '$idVentas', '$idProducto', '$cantidad')";
            $result= @mysql_query($crearDescVenta);
            if ($result == FALSE) { die(@mysql_error()); }
		}
	}
?>