<?php
session_start();
error_reporting(E_ERROR); //turn off warnings

$username = $_SESSION['username'];

require_once('/home1/kazura92/includes/dbinfo.php');

$db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
$db->set_charset('utf8');

if ($db->connect_error) {
	echo $db->connect_error;
}
else {

  $category = $_POST['categoryName'];

  $category = $db->real_escape_string($category);

  //creates tables based on which user selected
  //$sql_add_category = "CREATE TABLE $username.$category (id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY, rating TINYINT(1), edited date)";
	$sql_add_category = "INSERT INTO categories (username, categoryname) VALUES ('$username', '$category')";

  $result_add_category = $db->query($sql_add_category);

  if (!$result_add_category) {
    echo $sql_add_category;
      //"<script>alert('Error 4 could not add category');</script>"
	}
	header("Location:../categories.html");

}

?>
