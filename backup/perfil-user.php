<?php
  session_start();

  if(!isset($_SESSION['username'])){
    header("location:login.php");
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
    <link rel="stylesheet" href="tema/js/source/jquery.fancybox.css?v=2.1.5">
    <script src="tema/js/source/jquery.fancybox.pack.js?v=2.1.5"></script>
  </head>
  <body>
	
	
	<?php
		
		$conexion=mysqli_connect("localhost","root","123","test") or die("Problemas con la conexión");
		$acentos = $conexion->query("SET NAMES 'utf8'");
		
		$registros=mysqli_query($conexion,"select * from ordenes where visto_bueno = \"no\" AND orden_sap IS NOT NULL AND orden_recepcion IS NOT NULL") or
		die("Problemas en el select:".mysqli_error($conexion));
		
		
		//-------------- INICIO Paginador ------------------
		
		//Limito la busqueda a 10 registros por pagina
		$TAMANO_PAGINA = 10; 
		
		//examino la página a mostrar y el inicio del registro a mostrar 
		@$pagina = $_GET["pagina"]; 
		if (!$pagina) { 
			$inicio = 0; 
			$pagina=1; 
		} 
		else { 
			$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
		}
		
		$num_total_registros = mysqli_num_rows($registros); 
		//calculo el total de páginas 
		$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 
		
		$ssql = "select * from ordenes where visto_bueno = \"no\" AND orden_sap IS NOT NULL AND orden_recepcion IS NOT NULL limit " . $inicio . "," . $TAMANO_PAGINA; 
		$rs = mysqli_query($conexion,$ssql); 
		
		//-------------- FIN Paginador ------------------
		
	?>
	
	
    <header class="grupo">
      <div class="caja base-50 no-padding">
        <h1> <a href="#" class="logo"> <img src="tema/img/logo.jpg" alt="POC"></a></h1>
      </div>
      <div class="caja base-50 no-padding">
        <a class="logout" href="logout.php" >Logout</a>
        <nav>
          <ul>
            <li> </li>
            <li> </li>
          </ul>
        </nav>
        <div class=""></div>
      </div>
      <div class="caja base-100 no-padding">
        <h2>En esta sección podrás encontrar el historial de todas tus órdenes de compra emitidas.</h2>
      </div>
    </header>
    <div id="data--input" class="grupo">
      <h3>Mis órdenes de compra</h3>
    </div>
	
    <div id="buscar" class="grupo">
      <div class="caja-80">
        <form id="" method="POST" action="" onSubmit="return validarForm(this)" class="seek"> 
          <input type="search" name="palabra" placeholder="ingresa número de OC">
          <button type="submit" value="buscar OC" name="buscar">buscar</button>
        </form>		
      </div>
    </div>
	
	<?php    	
	//  ----------   A partir de este codigo se realiza la busqueda  ----------
	if(isset($_POST['buscar'])){   
	
	?>
	
	<?php
		$buscar = $_POST["palabra"];
		$conexion=mysqli_connect("localhost","root","123","test") or die("Problemas con la conexión");
		
		//Ojo esto es para buscar una orden en especifica
		$consulta_mysql=mysqli_query($conexion,"SELECT * FROM ordenes WHERE numero_orden = '$buscar' ") or		
		//$consulta_mysql=mysqli_query($conexion,"SELECT * FROM ordenes WHERE numero_orden = '142-424-555'") or
		die("Problemas en el select:".mysqli_error($conexion));
		
		//$consulta_mysql= mysql_query ("SELECT * FROM ordenes WHERE numero_orden like '%$buscar%'");
		while($reg = mysqli_fetch_array($consulta_mysql)) {
	?> 
	<br>	
	
	<div id="campana" class="grupo">
		<div class="caja-100">
			<div id="tabla">
			  <div id="titulo--orden-1">Nº de OC</div>
			  <div id="titulo--orden-2">Fecha</div>
			  <div id="titulo--orden-3">Detalle</div>
			  <div id="titulo--orden-4">OC SAP</div>
			  <div id="titulo--orden-5">OC RECEPCIÓN</div>
			  <div id="titulo--orden-6T"> <img src="tema/img/time.gif" alt=""></div>
			  <div id="titulo--orden-6S"><img src="tema/img/download.gif" alt=""></div>
			</div>   
		</div>	
	
	
	<?php
		//if ($reg=mysqli_fetch_array($registros))
				  
		//Aqui se calculan los dias que van transcurriendo desde la emision de la OC
		  $fecha = $reg['fecha'];		  
		  $todate = date("Y-m-d",strtotime($fecha));		  
		  $fecha_format = date("d-m-Y",strtotime($fecha));		  		  		  
		  date_default_timezone_set('America/Santiago');
		  $fromdate = date('Y-m-d', time());		  
		  $calculate_seconds = strtotime($fromdate) - strtotime($todate); // Numero de segundos entre las dos fechas
		  $days = floor($calculate_seconds / (24 * 60 * 60 )); // Conversion a dias
		  
		echo "<div id=\"tabla\">";
		echo "<div id=\"orden--1\">".$reg['numero_orden']."</div>";
		echo "<div id=\"orden--2\">".$fecha_format."</div>";
		echo "<div id=\"orden--3\">".$reg['descripcion']."</div>";
		echo "<div id=\"orden--4\">".$reg['orden_sap']."<span class=\"yes\"><img src=\"tema/img/yes.gif\" alt=\"\"></span>"."</div>";
		echo "<div id=\"orden--5\">".$reg['orden_recepcion']."<span class=\"no\"><img src=\"tema/img/yes.gif\" alt=\"\"></span>"."</div>";
		//Aqui manipulo la fecha para que si pasa de 5 dias se muestre en rojo
		  if ($days>=5){
			echo "<div id=\"orden--6T\" style=\"color:#FF0000\">".$days." dias"."</div>";
		  } else {
			  echo "<div id=\"orden--6T\" >".$days." dias"."</div>";
		  }	
		echo "<div id=\"orden--6S\"><a href=\"#inline2\" data-tooltip=\"Descargar archivo\" class=\"various\"><img src=\"tema/img/download.gif\" alt=\"\"></a></div>";
		echo "</div>";
		  		  
		  
	?>	  		
	
	<p> </p>
	
	<?php }   }  // fin if  ?>
	

    <div id="campana" class="grupo">
      <div class="caja-100">
        <div id="tabla">
          <div id="titulo--orden-1">Nº de OC</div>
          <div id="titulo--orden-2">Fecha</div>
          <div id="titulo--orden-3">Detalle</div>
          <div id="titulo--orden-4">OC SAP</div>
          <div id="titulo--orden-5">OC RECEPCIÓN</div>
          <div id="titulo--orden-6T"> <img src="tema/img/time.gif" alt=""></div>
          <div id="titulo--orden-6S"><img src="tema/img/download.gif" alt=""></div>
        </div>
		        
		
		<?php
		
		$dir = "uploads/";
		$items = array();
		
		// Aqui leo el contenido del directorio uploads
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {										
					$items[] = $file;					
				}
				closedir($dh);
			}
		}
		
		
		while ($reg=mysqli_fetch_array($rs))
		{
		  
		  $nro_orden = $reg['numero_orden'];
		  $nro_orden_comp = $nro_orden . ".pdf";
		  //echo "la mamada que construi: " . $nro_orden_comp;
		  
		  //Aqui se calculan los dias que van transcurriendo desde la emision de la OC
		  $fecha = $reg['fecha'];		  
		  $todate = date("Y-m-d",strtotime($fecha));		  
		  $fecha_format = date("d-m-Y",strtotime($fecha));		  		  		  
		  date_default_timezone_set('America/Santiago');
		  $fromdate = date('Y-m-d', time());		  
		  $calculate_seconds = strtotime($fromdate) - strtotime($todate); // Numero de segundos entre las dos fechas
		  $days = floor($calculate_seconds / (24 * 60 * 60 )); // Conversion a dias	
		  
		  echo "<div id=\"tabla\">";
		  echo "<div id=\"orden--1\">".$reg['numero_orden']."</div>";
		  echo "<div id=\"orden--2\">".$fecha_format."</div>";
		  echo "<div id=\"orden--3\">".$reg['descripcion']."</div>";
		  echo "<div id=\"orden--4\">".$reg['orden_sap']."<span class=\"yes\"><img src=\"tema/img/yes.gif\" alt=\"\"></span>"."</div>";
		  echo "<div id=\"orden--5\">".$reg['orden_recepcion']."<span class=\"no\"><img src=\"tema/img/yes.gif\" alt=\"\"></span>"."</div>";
		  
		  //Aqui manipulo la fecha para que si pasa de 5 dias se muestre en rojo
		  if ($days>=5){
			echo "<div id=\"orden--6T\" style=\"color:#FF0000\">".$days." dias"."</div>";
		  } else {
			  echo "<div id=\"orden--6T\" >".$days." dias"."</div>";
		  }		
		  		  
		  //Aqui valido que la orden tenga archivos para poder descargarlos	
		  if (in_array($nro_orden_comp,@$items)){  			  
			  echo "<div id=\"orden--6S\"><a href=\"./uploads/$nro_orden.pdf\" data-tooltip=\"Descargar archivo\" class=\"various\" download><img src=\"tema/img/download.gif\" alt=\"\"></a></div>";
		  }else{
			  echo "<div id=\"orden--6S\"></div>";
		  }
		  
		  echo "</div>";
		  
		  //echo "Iterando en los items: " . @$items[$it];
		  //$it = $it	+ 1;
		  
		}
		
		
		mysqli_free_result($rs); 
		mysqli_close($conexion);
		
		//Falta centrar y darle estilo al selector de paginas
		
		echo "<div class=\"caja-100\">";
			echo "<div class=\"paginator\">";
		
		//muestro los distintos índices de las páginas, si es que hay varias páginas 
		if ($total_paginas > 1){ 
		for ($i=1;$i<=$total_paginas;$i++){ 
			if ($pagina == $i) 
				//si muestro el índice de la página actual, no coloco enlace 
				echo "<span class=\"pag--cube\">" . $pagina . "</span>" . " "; 
			else 
				//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 				
				echo "<a href='perfil-user.php?pagina=" . $i . "'>"  . $i .  "</a> " ; 
			}   
		}	
			echo "</div>";				
		echo "</div>";
		
		
		?>	
		
		
      </div>
    </div>
	
	
    <div id="footer" class="total">
      <div class="grupo">
        <div id="logo-footer" class="caja-50"><img src="tema/img/logo-footer.png" alt=""></div>
        <div id="copy" class="caja-50">
          <p>© 2015 Easy S.A.</p>
        </div>
      </div>
    </div>
  </body>
</html>