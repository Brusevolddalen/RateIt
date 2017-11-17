<?php

error_reporting(E_ERROR); //turn off warnings

require_once('/home1/kazura92/includes/dbinfo.php');

$db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);

if ($db->connect_error) {
	echo $db->connect_error;
}
else {
	$db->set_charset('utf8');

	$sql = "SELECT categoryname FROM mastercategories";



	$rows = $db->query($sql);
	$length = $rows->num_rows;

	// empty array

	$result = array();
	for ($i = 0; $i < $length; $i++) {
		$row = $rows->fetch_assoc(); //retrieving each row
		array_push($result, $row); //add to the array
	}

	echo json_encode($result); //convert to json and output the result
} //end else

?>
