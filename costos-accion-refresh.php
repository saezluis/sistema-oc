<?php
	
	include "config.php";
		
	$conexion=mysqli_connect($host,$username,$password,$db_name) or die("Problemas con la conexión");
	$acentos = $conexion->query("SET NAMES 'utf8'");
	
	$rows = $_REQUEST['rows'];
	
	$nro_solicitud_send = $_REQUEST['nro_solicitud_send'];
	
	echo "rows: ".$rows;
	echo "<br>";
	echo "<br>";
	
	echo "Capturando la matrix";
	echo "<br>";
	echo "<br>";
	
	//-------- Presupuesto Proyectado
	$ppto_real_name_final = array();	
	$ppt = array();
	
	$nro_oc_name_final = array();
	$nroOC = array();
	
	for ($x = 0; $x <= $rows; $x++) {
		$ppto_real_name = 'ppto';
		$ppto_real_name_final[] = $ppto_real_name.$x;
		
		$nro_oc_real_name = 'nroOC';
		$nro_oc_name_final[] = $nro_oc_real_name.$x;
	}
	
	//$cont=0;
	for ($x = 0; $x <= $rows; $x++) {
		$ppt[] = $_REQUEST[$ppto_real_name_final[$x]];
		
		$nroOC[] = $_REQUEST[$nro_oc_name_final[$x]];
		
		if($x!=0){
			//echo $nroOC[$x]."<br>";
			buscarOC($nroOC[$x],$ppt[$x]);
			//$cont = $cont + 1;
			//echo $cont."<br>";
			//echo $verificador."<br>";
			/*
			if($verificador=='T'){
				insertPptoReal($ppt[$x],$nroOC[$x],$nro_solicitud_send);
			}
			*/
		}
	}
	
	/*
	for ($x = 0; $x <= $rows; $x++) {
		echo "Valor capturado PPTO ".$x.": ".$ppt[$x];
		echo "<br>";
		echo "<br>";
		echo "Valor capturado nroOC: ".$x.": ".$nroOC[$x];
		echo "<br>";
		
	}
	*/
	
			//-------- Numero de Orden
			
			/*
			for ($x = 0; $x <= $rows; $x++) {
				$nro_oc_real_name = 'nroOC';
				$nro_oc_name_final[] = $nro_oc_real_name.$x;
			}
			
			for ($x = 0; $x <= $rows; $x++) {
				$nroOC[] = $_REQUEST[$nro_oc_name_final[$x]];
			}
			
			for ($x = 0; $x <= $rows; $x++) {
				echo "Valor capturado nroOC: ".$x.": ".$nroOC[$x];
				echo "<br>";
			}
			*/
	
	
	
	/*
	function familyName($fname) {
		echo "$fname Refsnes.<br>";
	}
	*/
	
	//familyName("Jani");
	
	//funcion buscarOC, si encuentra OC, llamar a la funcion actualizarCAC
	
	
	function buscarOC($nro_oc_buscar,$ppto_real_snapshot){
		$variable_binaria = "";	
		include "config.php";
		global $conexion;
		global $acentos;
		
		$registrosCAC=mysqli_query($conexion,"select * from cac")or die("Problemas en el select:".mysqli_error($conexion));
		
		while($reg=mysqli_fetch_array($registrosCAC)){
			
			$nro_oc_registro = $reg['nro_oc'];
			
			/*echo "<br>";
			echo "-----inicio"."<br>";
			echo $nro_oc_registro."<br>";
			echo $nro_oc_buscar."<br>";
			echo "-----FIN";
			echo "<br>";*/
			
			if($nro_oc_registro==$nro_oc_buscar){
				//$verificador="T";
				//echo "encontro la OC";
				//echo "<br>";
				actualizarCAC($nro_oc_registro,$ppto_real_snapshot);
				//$variable_binaria = "F";
			}
		}
		//return $variable_binaria;
	}
	
	function actualizarCAC($nro_oc_buscar,$ppto_real_get){
	
		include "config.php";
		global $conexion;
		global $acentos;
		
		mysqli_query($conexion, "update cac set ppto_real='$ppto_real_get' WHERE nro_oc='$nro_oc_buscar'") or	die("Problemas en el select:".mysqli_error($conexion));
		
	}
	
	function insertPptoReal($ppto_real,$nro_oc,$nro_solicitud){
		
		include "config.php";
		global $conexion;
		global $acentos;
		
		mysqli_query($conexion,"INSERT INTO cac(ppto_real,nro_oc,nro_solicitud) values ('$ppto_real','$nro_oc','$nro_solicitud')") or die("Problemas con el insert de los servicios");
		/*										
		echo "inside the matrix";
		echo $ppto_real;
		echo "<br>";
		echo $nro_oc;
		echo "<br>";
		echo $nro_solicitud;
		echo "<br>";
		echo "<br>";
		*/
	}
	
	/*
	deberia hacer una funcion para insertar
	y la llamo de acuerdo a la cantidad de veces que vaya a hacer insert,
	sin embargo luego que el campo tenga datos deberia quedar haciendo update 
	*/
	
	/*
	$ppt1 = $_REQUEST['ppto1'];
	$ppt2 = $_REQUEST['ppto2'];

	echo "Valor capturado 1: ".$ppt1;
	echo "<br>";
	echo "<br>";
	
	echo "Valor capturado 2: ".$ppt2;
	echo "<br>";
	echo "<br>";
	
	
	$nroOC1 = $_REQUEST['nroOC1'];
	$nroOC2 = $_REQUEST['nroOC2'];
	
	echo "OC capturada 1: ".$nroOC1;
	echo "<br>";
	echo "<br>";
	
	echo "OC capturada 2: ".$nroOC2;
	echo "<br>";
	echo "<br>";
	*/
	echo "<br>"."<br>";
	echo "<a href=\"costos-accion.php\">Volver</a>";
	
?>