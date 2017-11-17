<?php
error_reporting(E_ERROR); //turn off warnings
date_default_timezone_set('Europe/Berlin');

require_once('/home1/kazura92/includes/dbinfo.php');


$master_db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
$master_db->set_charset('utf8');

if ($master_db->connect_error) {
	echo $master_db->connect_error;
}
else {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sex = $_POST['sex'];
	$birthdate = $_POST['birthdate'];
	$country = $_POST['country'];

	$username = $master_db->real_escape_string($username);
	$email = $master_db->real_escape_string($email);
	$password = $master_db->real_escape_string($password);
	$sex = $master_db->real_escape_string($sex);
	$birthdate = $master_db->real_escape_string($birthdate);
	$country = $master_db->real_escape_string($country);
	$passwordcrypt = password_hash($password, PASSWORD_BCRYPT);

	// Creates the member in master.members

	$sql_register = "INSERT INTO members (username, email, password, sex, birthdate, country, regdate) VALUES ('$username', '$email', '$passwordcrypt', '$sex', '$birthdate', '$country', now())";
	$result_register = $master_db->query($sql_register);

	// If successfull in registering the member, redirects to login screen

	if ($result_register) {
    header("Location:../login.html");

	}
	else {

		// header("Location:../register.html");

		echo "<script>
              alert('Error: 1. A user with that username or email already exists!');
              window.location.href='../register.html';
              </script>";
	}
}

?>
