<?php 
	ob_start();
    header('Content-Type: text/html; charset=UTF-8'); 
    error_reporting(E_ALL); 
    ini_set('display_errors', 'Off');
    session_start();

    require_once($_SESSION['mysqlConnection']);
    mysql_query("SET NAMES 'utf8'");

    $id = $_POST['id'];
    $productos = 'SELECT *
                        FROM desc_venta
                        INNER JOIN ventas ON desc_venta.id_venta = ventas.id_ventas
                        INNER JOIN productos ON desc_venta.id_producto = productos.id
                        WHERE ventas.id_ventas='.$id;    
    $result= @mysql_query($productos);
    if ($result == FALSE) { die(@mysql_error()); }

    while($row = mysql_fetch_array($result)){ 
    	$sqlSyntax1 = 'UPDATE productos SET vendido=vendido+'.$row['cantidad'].', reservado=reservado-'.$row['cantidad'].' WHERE id='.$row['id_producto'];
        $result1 = @mysql_query($sqlSyntax1);
        if ($result1 == FALSE) { die(@mysql_error()); }
    }              

    //se actuzliza la tabla ventas a VENDIDA
	$sqlSyntax2 = 'UPDATE ventas SET vendido=1 WHERE id_ventas ='.$id;
    $result2= @mysql_query($sqlSyntax2);
    if ($result2 == FALSE) { die(@mysql_error()); }

    // //se borran todos los ventas descr
    // $sqlSyntax3 = 'DELETE FROM desc_venta WHERE id_venta ='.$id;
    // $result3= @mysql_query($sqlSyntax3);
    // if ($result3 == FALSE) { die(@mysql_error()); }
 ?>