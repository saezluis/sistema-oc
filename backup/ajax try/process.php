<?php

$errors         = array();  	// array to hold validation errors
$data 			= array(); 		// array to pass back data

// validate the variables ======================================================
	// if any of these variables don't exist, add an error to our $errors array

	if (empty($_POST['campana']))
		$errors['campana'] = 'Name is required.';

	//echo $_POST['typeahead'];
	
	//if (empty($_POST['email']))
	//	$errors['email'] = 'Email is required.';

	//if (empty($_POST['superheroAlias']))
	//	$errors['superheroAlias'] = 'Superhero alias is required.';

// Insertar los datos ======================================================
	
$conexion=mysqli_connect("localhost","root","123","test") or die("Problemas con la conexion");

mysqli_query($conexion,"insert into users(username,password,status) values ('$_POST[campana]',
												'1234',
												99)")
  or die("Debe llenar todos los campos");  	

// return a response ===========================================================

	// if there are any errors in our errors array, return a success boolean of false
	if ( ! empty($errors)) {

		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {

		// if there are no errors process our form, then return a message

		// DO ALL YOUR FORM PROCESSING HERE
		// THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success!';
	}

	// return all our data to an AJAX call
	echo json_encode($data);