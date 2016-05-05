<?php session_start(); ?>
<!--
	/****************************************************************************
	* File Name: cartEmpty.php
	* Use-case: customer view inventory
	* Author: Kayoung Kim
	* E-mail: kayoung2@umbc.edu
	*
	* This php file is only via emptyCart javascript function in kayoung2.js
	* Simply it delete all the rows where user_num equals to $uid
	*
	*****************************************************************************/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
<?php
/*
	$servername = "studentdb-maria.gl.umbc.edu";
	$username = "kayoung2";
	$password = "kayoung2";
	$dbname = "kayoung2";

  
	//DB connect info and SELECT Query
	$con = mysql_connect("$servername", "$username", "$password");
	if (!$con){
		print mysql_error();
		exit;
	}

	$db = mysql_select_db("$dbname", $con);
	if(! $db){
		print mysql_error();
		exit;
	}
*/ 
	$newO = $_REQUEST["c"];
	if ($newO !=NULL) {
		array_push($oArr,$newO);
	}
	$_REQUEST["c"] = NULL;
	
/*
	if ( ($user_num != NULL) && ($user_num != NULL) && ($user_num != NULL) ){
		$updateQ = "UPDATE shopping_cart SET quantity=$newQ 
			WHERE (user_num = $user_num) AND (item_num = $item_num)";
		$updateResult = mysql_query($updateQ);
		if (!$updateResult){
			print "ERROR UPDATE3: ";
			print mysql_error();
			exit;
		}
	}
*/

	
?>
</body>
</html>