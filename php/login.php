<?php
session_start();
error_reporting(E_ERROR); //turn off warnings
require_once('/home1/kazura92/includes/dbinfo.php');

$master_db = new MySQLi("localhost", $admin_username, $admin_password,$db_name);
$master_db->set_charset('utf8');

if ($master_db->connect_error) {
	echo $master_db->connect_error;
}
else {


	$email = $_POST['email'];
	$password = $_POST['password'];

	$email = $master_db->real_escape_string($email);
	$password = $master_db->real_escape_string($password);

	$validUser = false;
	$login_sql = "SELECT email, password FROM members WHERE email='$email'";


  $result = $master_db->query($login_sql);

  //If someone with email is found, check if password is correct
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$hashPassword = $row['password'];
		$validUser = password_verify($password, $hashPassword);
	}


  //If the password is correct, check if its first time logging in
	if ($validUser) {
    $login_sql_username = "SELECT username, lastlogin  FROM members WHERE email='$email'";
    $result_username = $master_db->query($login_sql_username);


    if ($row = $result_username->fetch_row()) {
      $_SESSION['username'] = $row[0];

      //If this is first time logging in, sends to welcomepage where you select from MasterCategories
      if (empty($row[1])) {
        $record_login_sql ="UPDATE members SET lastlogin = now() WHERE email='$email'";
        $result_record_login_sql = $master_db->query($record_login_sql);
        header("Location:../welcome.html");
      }
      else{
        header("Location:../categories.html");
      }

    }

	}

	else {

		echo "<script>
      alert('Wrong username or password, please try again!');
      window.location.href='../login.html';
      </script>";
	}
}

?>
