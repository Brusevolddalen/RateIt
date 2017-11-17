<?php
session_start();

$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$column = $_POST['Column'];

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
	$sql_get_headerid = "SELECT headerid FROM headers WHERE categoryname = '$currentCategory' AND username = '$username' AND headername = 'rating'";
	$rows = $user_db->query($sql_get_headerid);
	$length = $rows->num_rows;
	$result = array();
	for ($i = 0; $i < $length; $i++) {
		$row = $rows->fetch_assoc();
		array_push($result, $row);
	}

	$headervalue = $result[0]["headerid"];
	$increase_by = count($column);

	// echo($result[0]["headerid"]);

	$sql_increase_headers_headerid = "UPDATE headers SET headerid = headerid + $increase_by WHERE headerid>= '$headervalue' AND categoryname = '$currentCategory' AND username = '$username'";
	$sql_increase_items_headerid = "UPDATE items SET headerid = headerid + $increase_by WHERE headerid>= '$headervalue' AND categoryname = '$currentCategory' AND username = '$username'";
	$result_increase_headers_headerid = $user_db->query($sql_increase_headers_headerid);
	$result_increase_items_headerid = $user_db->query($sql_increase_items_headerid);

	if ($result_increase_headers_headerid and $result_increase_items_headerid) {

		foreach($column as $key => $headername) {
			$sql_add_header = "INSERT INTO headers (headername, headerid, username, categoryname) VALUES ('$headername', '$headervalue' , '$username', '$currentCategory')";
			$result_add_header = $user_db->query($sql_add_header);

			if ($result_add_header) {
				$sql_get_itemids = "SELECT DISTINCT itemid FROM items WHERE username = '$username' AND categoryname = '$currentCategory'";
				$rows = $user_db->query($sql_get_itemids);
				$length = $rows->num_rows;
				$result = array();

				for ($i = 0; $i < $length; $i++) {
					$row = $rows->fetch_assoc();
					array_push($result, $row);
				}

				foreach($result as $key => $itemid) {
					$sql_add_column = "INSERT INTO items (itemid, username, categoryname, tablevalue, headername, headerid) VALUES ('$itemid[itemid]','$username', '$currentCategory', ' ',  '$headername', '$headervalue')";
					$result_add_column = $user_db->query($sql_add_column);

					if ($result_add_column) {
						header("Location:../items.html?category=" . $currentCategory);
					}

					else {
						echo "Something went wrong :(";
					}
				}
			}

			else {
				echo "Something went wrong :(";
			}
			$headervalue++;
		}
	}
	else{
		echo $sql_increase_headers_headerid."<br />";
		echo $sql_increase_items_headerid."<br />";
	}
}

?>
