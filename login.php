<?php
  session_start();

  if(isset($_SESSION['username'])){
	  $user = $_SESSION['username'];	  
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximun-scale=1">
    <link rel="stylesheet" href="tema/css/estilos.css">
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="tema/js/scripts.js"></script>
	<!-- Bootstrap 
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
	
	<input name="myusername" type="text" id="correo" placeholder="ej: usuario@algo.cl">
	
	
	
	<input name="mypassword" type="password" id="contrasena" placeholder="ej: 123456">
	-->
  </head>
  <body>
    <div id="log"><img src="tema/img/login.png" alt="">
      <form id="" method="post" action="checklogin.php" class="login">
        <label for="correo">Ingresa tu correo</label>
        <input name="myusername" type="text" id="myusername" placeholder="ej: usuario@algo.cl">
        <label for="contrasena">Ingresa tu contraseña</label>
        <input name="mypassword" type="password" id="mypassword" placeholder="ej: 123456">
        <input type="submit" id="submit" value="Entrar">			
		<a href="#">¿olvidaste tu contraseña?</a>
		<div id="message"></div>
      </form>
    </div>
	<script src="//code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="js/login.js"></script>
  </body>
</html>