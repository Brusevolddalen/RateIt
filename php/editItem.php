<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$value = $_POST['Row'];

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
/*
	UPDATE items
	SET column1 = value1, column2 = value2, ...
	WHERE condition;
*/
	$itemid = $value['itemid'];
	unset($value['itemid']);


  foreach ($value as $key => $value) {
    $sql_edit_item = "UPDATE items SET tablevalue = '$value' WHERE username = '$username' AND itemid = '$itemid' AND headername = '$key'";

		$result_edit_item = $user_db->query($sql_edit_item);

		if ($result_edit_item) {
			header("Location:../items.html?category=" . $currentCategory);
		}
		else {
			 echo "something went wrong :(";
		}

  }

}

?>
