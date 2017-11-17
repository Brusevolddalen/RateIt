<?php
session_start();
foreach($_POST['masterCategories'] as $master_categories_selected) {

	//If user doesn't select any Master Categories, send them to category page
	if (empty($master_categories_selected)) {
		header("Location:../categories.html");
	}
	//If user selects mastercategories, connect to databases and create tables in users database
	else{

		$username = $_SESSION['username'];

		require_once('/home1/kazura92/includes/dbinfo.php');

		$db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
		$db->set_charset('utf8');
		$master_categories_selected = $db->real_escape_string($master_categories_selected);


		$sql_insert_master_categories = "INSERT INTO categories (username, categoryname) VALUES ('$username', '$master_categories_selected')";
		$result_insert_master_categories = $db->query($sql_insert_master_categories);


		$sql_select_mastercategory_headers = "SELECT categoryname, headername, headerid FROM mastercategoryheaders WHERE categoryname = '$master_categories_selected'";

		$rows = $db->query($sql_select_mastercategory_headers);
		$length = $rows->num_rows;
		$result = array();

		for ($i = 0; $i < $length; $i++) {
			$row = $rows->fetch_assoc();
			array_push($result, $row);
		}


		if($result_insert_master_categories){

			$sql_select_mastercategory_headers = "SELECT categoryname, headername, headerid FROM mastercategoryheaders WHERE categoryname = '$master_categories_selected'";

			$rows = $db->query($sql_select_mastercategory_headers);
			$length = $rows->num_rows;
			$result = array();

			for ($i = 0; $i < $length; $i++) {
				$row = $rows->fetch_assoc();
				array_push($result, $row);
			}

			foreach ($result as $key => $value) {
				$sql_insert_headers = "INSERT INTO headers (headername, headerid, username, categoryname) VALUES ('$value[headername]','$value[headerid]', '$username', '$value[categoryname]')";
				$result_insert_headers = $db->query($sql_insert_headers);
			}
			header("Location:../categories.html");
		}
		else{
		/*
			echo "<script>
								alert('Error: 3. Could not insert MasterCategories into table!');
								window.location.href='../categories.html';
								</script>";
								*/
								echo $sql_insert_headers."<br />";
		}

	}
}

?>
