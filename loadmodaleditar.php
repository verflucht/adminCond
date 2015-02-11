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

	$id = $_GET['id'];
	
	$productos = 'SELECT *
        	FROM desc_venta
        	INNER JOIN ventas ON desc_venta.id_venta = ventas.id_ventas
        	INNER JOIN productos ON desc_venta.id_producto = productos.id
        	WHERE ventas.id_ventas='.$id.' ORDER BY id_ventas';

        $result= @mysql_query($productos);
        if ($result == FALSE) { die(@mysql_error()); }
        
        if (mysql_num_rows($result) > 0) {
	        while($row = mysql_fetch_array($result)){
	        	echo '
	        		<!-- Modal Editar Venta -->
					<div class="modal fade" id="modalEditarVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="container" style="margin-top:60px;">
							<div class="row">
								<div class="col-sm-12 text-center">
									<div class="well">
										<h1>Editar una venta</h1>
										<hr>
										<input type="hidden" name="count" value="1" />
										<div class="control-group" id="fields">
											<div class="controls" id="profs">
												<div class="row">
													<div class="col-sm-12"></div>
													<form  method="GET" id="formulario" accept-charset="utf-8">
														<!-- panel preview -->
														<div class="col-sm-5">
															<div class="panel panel-default">
																<div class="panel-body form-horizontal payment-form">
																	<div class="form-group">
																		<label for="concept" class="col-sm-3 control-label">Nombre</label>
																		<div class="col-sm-9">
																			<input type="text" class="form-control" id="nombre" name="nombre" value="'.$row['cliente'].'">
																		</div>
																	</div>
																	<div class="form-group">
																		<label for="description" class="col-sm-3 control-label">Lugar</label>
																		<div class="col-sm-9">
																			<input type="text" class="form-control" id="lugar" name="lugar" value="'.$row['lugar'].'">
																		</div>
																	</div>
																	<div class="form-group">
																		<label for="amount" class="col-sm-3 control-label">Fecha</label>
																		<div class="col-sm-9">
																			<!-- <input type="date" class="form-control" id="fecha" name="fecha"> -->
																			<div class="input-append date form_datetime">
																				<input size="16" type="text" class="form-control" name="fecha" value="'.$row['fecha'].'"><span class="add-on"><i class="icon-th"></i></span>
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<label for="tel" class="col-sm-3 control-label">Telefono</label>
																		<div class="col-sm-9">
																			<input type="text" class="form-control" id="telefono" name="telefono" value="'.$row['telefono'].'">
																		</div>
																	</div>
																	<div class="form-group">
																		<label for="date" class="col-sm-3 control-label">Comentarios</label>
																		<div class="col-sm-9">
																			<textarea class="form-control" rows="3" id="comentarios" name="comentarios" value="'.$row['comentarios'].'"></textarea>
																		</div>
																	</div>
																	<div class="form-group">
																		<div class="col-sm-12 text-right"></div>
																	</div>
																</div>
															</div>
														</div> <!-- / panel preview -->
														<div class="col-sm-7">
															<div class="form-group form-group-multiple-selects col-xs-12">
																<div class="input-group input-group-multiple-select col-xs-12">
																	<select class="form-control" name="values[]">
																		<option value="">Selecciona un modelo</option>
																		'.
																			$sqlSyntax2 = "SELECT id, marca, nombre, disponible FROM productos WHERE disponible > 0 ORDER BY nombre ASC";
																			$result2= @mysql_query($sqlSyntax2);
																			$count = 0;
																			if ($result2 == FALSE) { die(@mysql_error()); }
																				if (mysql_num_rows($result2) > 0) {
																					while($row2 = mysql_fetch_array($result2)){
																					$count = $count + 1; 
																		.'
																			<option value="'.$row2['id'].'">'.$row2['marca'].' '.$row2['nombre'].' (',$row2['disponible'].')</option>
																		'.
																		}
																			}
																			else
																				break;
																		.'
																	</select>
																	<span class="input-group-addon input-group-addon-remove">
																		<span class="glyphicon glyphicon-remove"></span>
																	</span>
																	<span class="input-value">
																		<input type="text" style="width: 60px;" name="option[]" class="form-control" maxlength="3">
																	</span>
																</div>
															</div>
															<input class="btn btn-success btn-lg btn-crearventa" value="Actualizar Venta">
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
	        	';
	        }
	    }
 ?>