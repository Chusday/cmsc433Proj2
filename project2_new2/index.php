<?php session_start(); ?>
<!--
TO DO LIST

0. user input validation : Capitalized names when a user sign up
1. clean up unnecessary css class
2. clean up debugging print statement
3. external js file
4. documentation and ppt slides
5. comments
6. what else??

-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Computer Science Degree Tracker</title>

	<!-- external stylesheet for the whole page -->
	<link rel="stylesheet" href="index.css">

	
<script type="text/javascript">

function addCart (Ith,val) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "html/optionFrame.php?c=" + val , true);
	alert(Ith+","+val);
	xmlhttp.send();

	var oiframe = document.getElementById("oFrame");
	alert(Ith+","+val);
	oiframe.contentWindow.location.reload(true);
}

function checkValidUser() {
	var flag = true;
	var nameRegex = /^[a-zA-Z\-]+$/;
	var idRegex = /^[A-Z]{2}[0-9]{5}$/;
	var emailRegex = /^[a-zA-Z0-9]+@umbc.edu$/;
	var errno = "User Input Error!\n";
	//Check input validation

	var fName = document.getElementById("fName").value;
	var lName = document.getElementById("lName").value;
	var email = document.getElementById("studentEmail").value;
	var cid  = document.getElementById("studentID").value;

	if ( (fName.length == 0)||(lName.length == 0)||(email.length == 0)||(cid.length == 0) ){
		alert("Input cannot be empty!\n Try again!");
		return;
	};


	if( !nameRegex.test(fName) )
	{
		flag = false;
		errno += "\t\"First name: "+fName+" is invalid!\"\n";
	}

	if( !nameRegex.test(lName) )
	{
		flag = false;
		errno += "\t\"Last name: "+lName+" is invalid!\"\n";
	}

	if( !emailRegex.test(email) )
	{
		flag = false;
		errno += "\t\"Student Email: "+email+" is invalid!\"\n";
	}

	if( !idRegex.test(cid) )
	{
		flag = false;
		errno += "\t\"Student ID: "+cid+" is invalid!\"\n";
	}

	if(!flag) {
		alert(errno);
		return;
	}
	else
	{
		//VALID USER
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "signUp.php?i="+cid+"&f="+fName+"&l="+lName+"&e="+email , true);
		xmlhttp.send();
		//document.getElementById("userForm").submit();
		alert("AJAX3!");
		window.location.replace('index.php');

	}

}

function logOut () {
	if (confirm("Log out?") ){
		window.location.replace('index.php?logFlag=true');
	}
	else{
		return;
	}
}

function submitCart () {
	var flagSubmit = false;
	var uid = document.getElementById("userUID").value;
	alert(uid);
	flagSubmit = confirm("Are you sure?\nOK? NO?");

	if (flagSubmit) {
		//document.getElementById("deleteHidden").innerHTML = ">>> PROCESSING SUBMIT >>><br>";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "submitCart.php?flagCart=true&uid="+uid , true);
		xmlhttp.send();
		alert(uid);
		window.location.replace('optionFrame.php');
			alert(uid);
	window.location.reload();
	}else{
		return;
	}

	//window.top.location.reload();
}

</script>
</head>

<body>

<?php
	require 'classes.php';
	//defined functions
	//require("functions.php");


	if ( isset($_GET['logFlag']) ) {
		if ( $_GET['logFlag'] == 'true' ) {
			echo 'logFlag set:'.$_GET['logFlag'].'<br>';
			// remove all session variables
			session_unset(); 

			// destroy the session 
			session_destroy(); 
		}
	}
$first_name;
$last_name;
$email;
function saveInput($f,$l,$e)
{
	$first_name = $f;
	$last_name = $l;
	$email = $e;
}

	$_SESSION['takenArr'] = array();
	$_SESSION['availableArr'] = array('CMSC201','CMSC232','CMSC291','CMSC352','CMSC391');
	$_SESSION['chosenArr'] = array();

	$servername = "studentdb-maria.gl.umbc.edu";
	$username = "kayoung2";
	$password = "kayoung2";
	$dbname = "kayoung2";

	//DB connect info and SELECT Query
	$con = mysql_connect("$servername", "$username", "$password");
	if (!$con){
		echo '<script type="text/javascript">alert("CANNOT CONNECT TO DB: mysql_connect error!")</script>';
		exit;
	}

	$db = mysql_select_db("$dbname", $con);
	if(! $db){

		echo '<script type="text/javascript">alert("CANNOT SELECT DB: mysql_select_db error!")</script>';
		exit;
	}



?>


<h1>Computer Science Degree Tracker</h1>

	<!-- global warning used by javascript for invalid user interaction notifications -->
	<div id="global-warning" style="display: none;" onmouseover="toggleGlobalWarning(false)"></div>
	
	<!-- top section of the page before the tab buttons -->
	<div id="top-section">

<?php
	if ($_SESSION['userCID'] == NULL) {

		$str = '<div id="form-div">

			<form id="form" name="userForm" method="post" action="index.php">
			<table class="formTB"><tr>
				<td><div class="form-section">
					<label for="first_name">First Name </label>
					<input id="fName" type="text" name="first_name" tabindex="1" value=""><br />
				</div></td>

				<td><div class="form-section">
					<label for="last_name">Last Name </label>
					<input id="lName" type="text" name="last_name" tabindex="2" value=""><br />
				</div></td>

				<td><div class="form-section">
					<label for="email">Email </label>
					<input id="studentEmail" type="text" name="email" tabindex="3" value=""><br />
				</div></td>

				<td><div class="form-section">
					<label for="id">Student ID </label>
					<input id="studentID" type="text" name="id" tabindex="4" value="">
				</div></td></tr>


				<tr><td colspan="4">
				<div id="form-submit" class="button" onclick="checkValidUser()">SignUp / SignIn</div>
				</td></tr>

			</table>
			</form>	
		</div>';
		echo $str;
	}
	else{

/*		echo '<div class="topMenu">';
		echo "<a href='index.php?logFlag=true' class=".'"logOutBTN"'.'><img src="images/img_Exit-48.png"></a>';
		echo '<button onclick="submitCart()" class="takeBTN"></button>';
		echo '</div>';*/
		echo '<div class="topMenu">';
		echo '<button onclick="logOut()" class='.'"logOutBTN"'.'></button>';
		echo '&nbsp;<button onclick="submitCart()" class="takeBTN"></button>';
		echo '</div>';

		echo '<br><table class="formTB">';
		echo '<tr class"formTBUnder">'."<td>Campus ID: ".$_SESSION['userCID'].", ".$_SESSION['userUID']."</td></tr>";
		echo '<tr class"formTBUnder">'."<td>Student Name: ".$_SESSION['userName']."</td></tr>";
		echo '<tr class"formTBUnder">'."<td>Student Email: ".$_SESSION['userEmail']."</td></tr>";
		//echo '<tr class"formTBUnder">'."<td>"."<a href='index.php?logFlag=true' class=".'"logOutBTN"'.">Log out</a>"."</td></tr>";
		//echo '<tr class"formTBUnder">'."<td>"."<button href='index.php?logFlag=true'>Log out</button>";
		//echo '<tr class"formTBUnder">'."<td>".'<button onclick="submitCart()"> TAKE CLASSES </button>'."</td></tr>";
		echo "</table>";



	}
	/*
	if ($_SESSION['flagSign'] == 'up') {
		echo "SUCCESSFULLY SIGN UP<br>";
	}else if ($_SESSION['flagSign'] == 'in') {
		echo "Welcome back:-)<br>";
	}else if ($_SESSION['flagSign'] == 'error') {
		echo "SignIn error<br>";
	}*/
?>

	</div>
	<!-- end of top section -->
	<div class="clear"></div>

<?php 
	$id = $_SESSION['userCID'];
	$uid = $_SESSION['userUID'];
	echo $first_name."<br>";
	echo '<input id="userUID" type="hidden" value="'.$uid.'"></div>';
?>

	<!-- container for the tab content titles -->
	<div id="tab-content-titles">
		<div class="tab-content-title"><p>Taken</p></div>
		<div class="tab-content-title"><p>Available</p></div>
		<div class="tab-content-title"><p>CART</p></div>
	</div>

	<div class="clear"></div>

	<!-- tab content container -->
	<div id="tab-content">
		<!-- computer science courses tab container -->
		<div id="cmsc-tab" class="tab">
			<div class="course-section">
<!-- START TAKEN -->
				<div id="cmsc-taken" class="course-select cmsc-select">
<table>
<?php

	//$id = 1; //DEBUG
	if($id!=NULL) {
		echo $id.", ".$uid."<br>";
		//"SELECT `student_id` FROM `Students` WHERE ( `student_cid` = '$id' )";
		$takenQ = "SELECT `taken_id`, `student_id`, `class_id` FROM `proj2_taken` WHERE (`student_id`='$uid')";
		$takenResult = mysql_query($takenQ);
		if(! $takenResult){
			print("ERROR TAKEN 2: QUARY");
			print($id);
			print mysql_error();
			exit;
		}
		$num = mysql_numrows($takenResult);
		echo $num;
		$i=0;
		while ($i < $num) {
			$eachClass = mysql_result($takenResult, $i, 'class_id');
			array_push($_SESSION['takenArr'], $eachClass);
			echo '<tr><td height="50px"><img src="images/img_check2-30.png" /></td>';
			echo '<td id="t_'.$eachClass.'" >&nbsp;'.$eachClass.'</td></tr>';
			echo "\n";
			$i++;
		}

	}
	else{
		echo "NEW USER<br>";
	}
?>
</table>
					</div>
<!-- END TAKEN -->

				</div>

				<div class="course-section">
<!-- START AVAILABLE -->
					<div id="cmsc-available" class="course-select cmsc-select">
					<table>

<?php

	$imgNum = 0;
	$numClasses = count($_SESSION['classesInfo']);
	if ($id == NULL) {
		# display 2xx level classes for a guest
		echo "NEW USER: ".$numClasses."<br>";

	} else {
		# display available classes
		$num = count($_SESSION['takenArr']);

		while( $eachArr = current($_SESSION['classesInfo']) ) {
			$flagExist = true;
			$value = key($_SESSION['classesInfo']);

			if (in_array($value, $_SESSION['takenArr'])) {
				$flagExist = false;
				//echo " (Taken: ".$value.")<br>";
			}
			else{
				for ($i=1; $i < count($eachArr) ; $i++) { 
					if ( !in_array($eachArr[$i], $_SESSION['takenArr']) ){
						$flagExist = false;
						break;
					}
				}
			}
			if ($flagExist) {
				//echo $value.', '.$imgNum.'<br>';

				echo '<tr><td height="50px"><img id="a_img_'.$imgNum.'" src="images/img_AddProperty-30.png" ';
				echo 'onmouseover="this.src=\'images/img_available-30.png\'" ';
				echo 'onmouseout="this.src=\'images/img_AddProperty-30.png\'" ';
				echo 'onclick="addCart(\''.$imgNum.'\',\''.$value.'\')"/></td>';
				echo '<td><input type="hidden" id="'.$value.'" value="'.$value.'">';
				echo '&nbsp;'.$value.'</td></tr>';
				echo "\n";
				$imgNum++;
			}
			next($_SESSION['classesInfo']);	
			
		}

	}


?>
					</table>
					</div>
<!-- END AVAILABLE -->

				</div>

				<div class="course-section">
<!-- START CART -->
					<div id="optionInner"></div>
					<div id="cmsc-options" class="course-select cmsc-select">

	<iframe src="optionFrame.php" id="oFrame" width="280px" height="600px" overflow-x="hidden" frameBorder="1"></iframe>


					</div>
<!-- END CART -->
				</div>
			</div>


		<!-- DEBUG (used to dump course data with getCoursesDebug()) -->
		<div class="clear"></div>
		<div id="main"></div>
		<!-- END DEBUG -->
	</body>

</html>