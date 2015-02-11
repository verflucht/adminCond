<?php
	header('Access-Control-Allow-Origin: *');
	ob_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 'off');
	header('Content-Type: text/html; charset=UTF-8');
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin - Ventas</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" type="image/x-icon" href="img/ico.png" />
		<!-- Latest compiled and minified CSS -->
		

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/nav.css">
		<link rel="stylesheet" href="css/crearventa.css">
		<link rel="stylesheet" href="css/modal.css">
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/crearventa.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	</head>
	<body>		 
		<div id="wrap" class="text-center">
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
			<div class="" style="">
				<div id="ventas" ></div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="container" style="margin-top:60px;">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="well">
							<h1>Crear nueva venta !</h1>
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
																<input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off">
															</div>
														</div>
														<div class="form-group">
															<label for="description" class="col-sm-3 control-label">Lugar</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="lugar" name="lugar">
															</div>
														</div>
														<div class="form-group">
															<label for="amount" class="col-sm-3 control-label">Fecha</label>
															<div class="col-sm-9">
																<!-- <input type="date" class="form-control" id="fecha" name="fecha"> -->
																<div class="input-append date form_datetime">
																	<input size="16" type="text" class="form-control" name="fecha" autocomplete="off"><span class="add-on"><i class="icon-th"></i></span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label for="tel" class="col-sm-3 control-label">Telefono</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="telefono" name="telefono" autocomplete="off"> 
															</div>
														</div>
														<div class="form-group">
															<label for="date" class="col-sm-3 control-label">Comentarios</label>
															<div class="col-sm-9">
																<textarea class="form-control" rows="3" id="comentarios" name="comentarios" autocomplete="off"></textarea>
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
															<?php
																require_once($_SESSION['mysqlConnection']); //Archivo para realizar las conexiones.
																mysql_set_charset('utf8');
																$sqlSyntax= 'SELECT id, marca, nombre, disponible FROM productos ORDER BY nombre ASC';
																$result= @mysql_query($sqlSyntax);
																$count = 0;
																if ($result == FALSE) { die(@mysql_error()); }
																	if (mysql_num_rows($result) > 0) {
																		while($row = mysql_fetch_array($result)){
																		$count = $count + 1;
																		echo '<option value="'.$row['id'].'">'.$row['marca'].' '.$row['nombre'].' (',$row['disponible'].')</option>';
																	}
																}
																else
																	break;
															?>
														</select>
														<span class="input-group-addon input-group-addon-remove">
															<span class="glyphicon glyphicon-remove"></span>
														</span>
														<span class="input-value">
															<input type="text" style="width: 60px;" name="option[]" class="form-control" maxlength="3">
														</span>
													</div>
												</div>
												<input class="btn btn-success btn-lg btn-crearventa" value="Crear Venta">
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
		
		<div class="modal-editarventa"></div>
	</body>
</html>