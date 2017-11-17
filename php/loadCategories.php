<?php
session_start();
error_reporting(E_ERROR); //turn off warnings

$username = $_SESSION['username'];

require_once('/home1/kazura92/includes/dbinfo.php');

$db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);

if ($db->connect_error) {
	echo $db->connect_error;
}
else {
	$db->set_charset('utf8');

	$sql = "SELECT categoryname FROM categories WHERE username = '$username'";


	$rows = $db->query($sql);
	$length = $rows->num_rows;

	$result = array();

	for ($i = 0; $i < $length; $i++) {
		$row = $rows->fetch_assoc();
		array_push($result, $row);
	}

	echo json_encode($result);
}

?>
