<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Azeroth | Login</title>
		<meta charset="utf-8">
		<!-- jquery 3.3.1 -->
		<script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/libs/css/login.css">
	<script src="./assets/libs/js/login.js"></script>
</head>
<body>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
		<section id="login">
	    <div class="container">
	    	<div class="row">
	    	    <div class="col-md-12">
	        	    <img src="./assets/images/logo.png" alt="" id="logo-log">
	                    <form role="form" action="javascript:;" method="post" id="login-form" autocomplete="off">
	                        <div class="form-group">
	                            
	                            <input type="text" name="user" id="user" class="form-control" placeholder="Ingrese usuario">
	                        	<div id="falta-usuario" class="msj-error"><label for="">Ingresa un usuario</label></div>
							</div>
	                        <div class="form-group">
	                            
	                            <input type="password" name="key" id="key" class="form-control" placeholder="Password">
								<div id="incorrecto" class="msj-error"><label for="">Datos incorrectos</label></div>
								<div id="falta-pass" class="msj-error"><label for="">Ingresa una contraseña</label></div>
	                        </div>
	                        <div class="checkbox">
	                            <span class="character-checkbox" id="showPass"></span>
								<span class="label">Show password</span>
	                        </div>
	                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
		                    </form>
		                    <hr>
		        	    
		    		</div> <!-- /.col-xs-12 -->
		    	</div> <!-- /.row -->
		    </div> <!-- /.container -->
		</section>
		</div>
		<div class="col-md-4"></div>
	</div>

	<footer id="footer">
	    <div class="container">
	        <div class="row">
	            <div class="col-md-12">
	                <p>AZEROTH © - 2019</p>
	            </div>
	        </div>
	    </div>
	</footer>

</body>
</html>
