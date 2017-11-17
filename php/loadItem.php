<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$itemid = $_POST['itemid'];

require_once('/home1/kazura92/includes/dbinfo.php');

$user_db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	echo "<script>
            alert('Error: 7. Could not connect to database!');
            window.location.href='../categories.html';
            </script>";
}
else {
	$itemid = mysqli_real_escape_string($user_db, $itemid);
  $sql_select_item = "SELECT itemid, tablevalue, headername FROM items WHERE username='$username' AND itemid = '$itemid' ORDER BY headerid";
  $result_select_item = $user_db->query($sql_select_item);


  $length = $result_select_item->num_rows;

	// empty array

	$result = array();
	for ($i = 0; $i < $length; $i++)
		{
		$row = $result_select_item->fetch_assoc(); //retrieving each row
		array_push($result, $row); //add to the array
		}

	echo json_encode($result); //convert to json and output the result
	} //end else


  /*
	if ($result_delete_item) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		echo $result_select_item;
	}
  */


?>
