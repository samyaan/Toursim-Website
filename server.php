<?php
session_start();

// variable declaration
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'pink_pedals');

// REGISTER USER
if (isset($_POST['reg_user'])) {
	// receive all input values from the form

	$email = mysqli_real_escape_string($db, $_POST['email']);
	$fname = mysqli_real_escape_string($db, $_POST['fname']);
	$lname = mysqli_real_escape_string($db, $_POST['lname']);
	$phone = mysqli_real_escape_string($db, $_POST['phone']);
	$phone2 = mysqli_real_escape_string($db, $_POST['phone2']);
	$address = mysqli_real_escape_string($db, $_POST['address']);
	$delivery_address = mysqli_real_escape_string($db, $_POST['addrg']);
	$gender = mysqli_real_escape_string($db, $_POST['radiogroup1']);
	$id_type = mysqli_real_escape_string($db, $_POST['radiogroup2']);
	$id_num = mysqli_real_escape_string($db, $_POST['id_card']);
	$duration = mysqli_real_escape_string($db, $_POST['duration']);
	$ngear = mysqli_real_escape_string($db, $_POST['ngear']);
	$gear = mysqli_real_escape_string($db, $_POST['gear']);
	$tandem = mysqli_real_escape_string($db, $_POST['tandem']);

	// form validation: ensure that the form is correctly filled
	if (empty($fname)) {
		array_push($errors, "First Name is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($lname)) {
		array_push($errors, "Last Name is required");
	}
	if (empty($phone)) {
		array_push($errors, "Phone Number is required");
	}
	if (empty($gender)) {
		array_push($errors, "Gender is required");
	}
	if (empty($address)) {
		array_push($errors, "Address is required");
	}
	if (empty($id_num)) {
		array_push($errors, "ID Card Number is required");
	}
	if (empty($phone2)) {
		array_push($errors, "Alternate Number is required");
	}
	if (empty($id_type)) {
		array_push($errors, "Id Type is required");
	}



	// register user if there are no errors in the form
	if (count($errors) == 0) {

		$query = "INSERT INTO package1 (Fname, Lname, phone, Address, gender, email, alternate_num, id_type, id_num, delivery_addr ,duration, nongear, gear, tandem) 
					  VALUES('$fname','$lname','$phone', '$address', '$gender', '$email', '$phone2', '$id_type', '$id_num', '$delivery_address', '$duration', '$ngear', '$gear', '$tandem' )";
		mysqli_query($db, $query);

		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		header('location: register2payment.php');
	}
}
