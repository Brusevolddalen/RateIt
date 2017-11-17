<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$item = $_POST['Item'];

require_once('/home1/kazura92/includes/dbinfo.php');
$user_db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	"<script>alert('Error 5 Could not connect to database, please check your internet connection!');</script>";
}
else {
	$sql_find_highest_itemid = "SELECT MAX(itemid) FROM items";
	$result_find_highest_itemid = $user_db->query($sql_find_highest_itemid);
	$length = $result_find_highest_itemid->num_rows;
	$headerid=1;


	$result = array();
	for ($i = 0; $i < $length; $i++) {
		$row = $result_find_highest_itemid->fetch_assoc();
		array_push($result, $row);
	}

	$itemid = $result[0]["MAX(itemid)"] + 1;
	foreach($item as $key => $value) {
		$sql_add_item = "INSERT INTO items (itemid, username, categoryname, tablevalue, headername, headerid) VALUES ('$itemid','$username', '$currentCategory','$value','$key','$headerid' )";
		$result_add_item = $user_db->query($sql_add_item);
		$headerid++;
	}

	$sql_add_item = "INSERT INTO items (itemid, username, categoryname, tablevalue, headername, headerid) VALUES ('$itemid','$username', '$currentCategory',  DATE_FORMAT(NOW(),'%d-%m-%Y'), 'Edited', '$headerid')";
	$result_add_item = $user_db->query($sql_add_item);
	if ($result_add_item) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		"<script>
			alert('Something went wrong :(');
			window.location.href='../items.html?category='" . "'$currentCategory';
		</script>";
	}
}

?>
