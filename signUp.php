<?php session_start(); ?>
<!--
signUp.php 
this file helps to enter the information of a new student
into the database. If the student info does not exist in the DB
it is redirected to this file to insert student info, 
in the Student tables. 

The database used here is kayoung2, in mariaDB provided from UMBC
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
<?php

//http://userpages.umbc.edu/~kayoung2/CMSC433/project2/signUp.php?i=AA00000&f=Shawn&l=Lupoli&e=slupoli@umbc.edu
	$cid = $_REQUEST["i"];
	$fName = $_REQUEST["f"];
	$lName = $_REQUEST["l"];
	$email = $_REQUEST["e"];

	echo $cid."<br>";
	echo $fName."<br>";
	echo $lName."<br>";
	echo $email."<br>";

	$servername = "studentdb-maria.gl.umbc.edu";
	$username = "kayoung2";
	$password = "kayoung2";
	$dbname = "kayoung2";
	//$_SESSION['userCID'] = $cid;

	//DB connect info and SELECT Query
	$con = mysql_connect("$servername", "$username", "$password");
	if (!$con){
		exit;
	}

	$db = mysql_select_db("$dbname", $con);
	if(! $db){
		exit;
	}

	$studentQuery = "SELECT * FROM `Students` WHERE ( `student_cid` = '$cid' )";
	$studentResult = mysql_query($studentQuery);
	if (!$studentResult) {
		print mysql_error();
		exit;
	}
	//echo "numRow: ".mysql_numrows($studentResult)."<br>";

	if( mysql_numrows($studentResult) == 0 ) 
	{
		$insertQuery = "INSERT INTO Students (student_cid, student_first_name, student_last_name, student_email) 
				VALUES ('$cid', '$fName', '$lName', '$email')";
		$insertResult = mysql_query($insertQuery);
		if (!$insertResult) 
		{
			print "ERROR insertResult2: ";
			print mysql_error();
			exit;
		}
		$_SESSION['flagSign'] = 'up';
	}

	$studentQuery = "SELECT * FROM `Students` WHERE ( `student_cid` = '$cid' )";
	$studentResult = mysql_query($studentQuery);
	if (!$studentResult) {
		print mysql_error();
		exit;
	}
	if (mysql_numrows($studentResult) > 1) {
		$_SESSION['flagSign'] = 'error';
	}
	$uid = mysql_result($studentResult, 0, 'student_id');
	$cid = mysql_result($studentResult, 0, 'student_cid');
	$fName = mysql_result($studentResult, 0, 'student_first_name');
	$lName = mysql_result($studentResult, 0, 'student_last_name');
	$email = mysql_result($studentResult, 0, 'student_email');
	echo $cid.", ". $uid ."<br>";
	$_SESSION['flagSign'] = 'in';
	$_SESSION['userCID'] = $cid;
	$_SESSION['userUID'] = $uid;
	$_SESSION['userName'] = $fName." ".$lName;
	$_SESSION['userEmail'] = $email;


	echo $_SESSION['userCID'].", ".$_SESSION['userUID'] ."<br>";
	
?>
</body>
</html>