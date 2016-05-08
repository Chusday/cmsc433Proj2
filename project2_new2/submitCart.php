<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Update Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript">

</script>
</head>

<body>

<?php
	

	if ( ($_REQUEST["flagCart"] == 'true')&&(!empty($_SESSION['chosenArr']) ) ){
		echo $_SESSION['userCID'] .", ".$_SESSION['userUID'] ."<br>";
		$uid = $_REQUEST["uid"];

		$servername = "studentdb-maria.gl.umbc.edu";
		$username = "kayoung2";
		$password = "kayoung2";
		$dbname = "kayoung2";

		$insertQuery = "";
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

		
		for ($i=0; $i < count($_SESSION['chosenArr']); $i++) { 
			# code...
			echo $_SESSION['chosenArr'][$i]."<br>";
			$each = $_SESSION['chosenArr'][$i];
			$insertQuery = "INSERT INTO `proj2_taken`(`student_id`, `class_id`) VALUES ('$uid', '$each')";
			$insertResult = mysql_query($insertQuery);
			if (!$insertResult) 
			{
				print "ERROR insertResult2: ";
				print mysql_error();
				exit;
			}
		}
	}
	

?>



</body>
</html>

