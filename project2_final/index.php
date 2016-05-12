<?php session_start(); ?>
<!--
index.php
this is the main file that operate the whole web page,
and brings together all the other code. 
The file has html embeded in it. Sometimes 
the code for html is outputted as html format, 
second half of the html code is in php strings. 
Once an ID is received from signing in more web page
divs are loaded from the php file. If the ID is null
then only the top section of sign in/sign up part is 
loaded to the page. 

-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Computer Science Degree Tracker</title>

	<!-- external stylesheet for the whole page -->
	<link rel="stylesheet" href="index.css">
	
<script src="functions.js"></script>

</head>
<body>

<?php
	// class pre-req array 
	require 'classes.php';
	
	if ( isset($_GET['logFlag']) ) {
		if ( $_GET['logFlag'] == 'true' ) {
			//echo 'logFlag set:'.$_GET['logFlag'].'<br>';
			// remove all session variables
			session_unset(); 
			// destroy the session 
			session_destroy(); 
		}
	}
// VARIABLES
$first_name;
$last_name;
$email;
$fourhundredflag = 0;
$CMSC331flag = 0;


//FUNCTIONS
function saveInput($f,$l,$e)
{
	$first_name = $f;
	$last_name = $l;
	$email = $e;
}
	// set arrays for each table
	$_SESSION['takenArr'] = array();
	$_SESSION['availableArr'] = array('CMSC201','CMSC232','CMSC291','CMSC352','CMSC391');
	$_SESSION['chosenArr'] = array();

	// DATABASE name and login
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
	// if userID is not specified than use this format for login
	if ($_SESSION['userCID'] == NULL) {

		$str = 
		'<div id="form-div">

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

	// if user id is specified, then use this format for logout button feature
	else{
		echo '<div class="topMenu">';
		echo '<button onclick="logOut()" class='.'"logOutBTN"'.'></button>';
		echo '&nbsp;<button onclick="submitCart()" class="takeBTN"></button>';
		echo '</div>';

		echo '<br><table class="formTB">';
		echo '<tr class"formTBUnder">'."<td>Campus ID: ".$_SESSION['userCID'].", ".$_SESSION['userUID']."</td></tr>";
		echo '<tr class"formTBUnder">'."<td>Student Name: ".$_SESSION['userName']."</td></tr>";
		echo '<tr class"formTBUnder">'."<td>Student Email: ".$_SESSION['userEmail']."</td></tr>";
		echo "</table>";
	
	
//? >	OLD WAY

	echo '</div>';
	//<!-- end of top section -->
	echo '<div class="clear"></div>';

// <? php   OLD WAY
	// receive user ID 
	$id = $_SESSION['userCID'];
	$uid = $_SESSION['userUID'];
	echo $first_name."<br>";
	echo '<input id="userUID" type="hidden" value="'.$uid.'"></div>';

// ? >	OLD WAY
	//<!-- container for the tab content titles -->
	$str2 = 
	'<div id="tab-content-titles">
		<div class="tab-content-title"><p>Taken</p></div>
		<div class="tab-content-title"><p>Available</p></div>
		<div class="tab-content-title"><p>CART</p></div>
	</div>

	<div class="clear"></div>';
	echo $str2;

	//<!-- tab content container -->
	//=====================================================
	$str3 = '<div id="tab-content">
		<!-- computer science courses tab container -->
		<div id="cmsc-tab" class="tab">
			<div class="course-section">';
	echo $str3;
//<!-- START TAKEN -->
	$str4 =      '<div id="cmsc-taken" class="course-select cmsc-select">
<table>';
echo $str4;

// < ? php    OLD WAY
	//$id = 1; //DEBUG
	if($id!=NULL) {
		//"SELECT `student_id` FROM `Students` WHERE ( `student_cid` = '$id' )";
		// select all the classes student has taken to show in taken table
		$takenQ = "SELECT `taken_id`, `student_id`, `class_id` FROM `proj2_taken` WHERE (`student_id`='$uid')";
		$takenResult = mysql_query($takenQ);
	
		if(! $takenResult){
			print("ERROR TAKEN 2: QUARY");
			print($id);
			print mysql_error();
			exit;
		}
		$num = mysql_numrows($takenResult);
		
		$i=0;
		while ($i < $num) {
			$eachClass = mysql_result($takenResult, $i, 'class_id');
			$check = preg_match('/^CMSC4[0-9][0-9]/',$eachClass);
			if ($check == 1){
				$fourhundredflag =1;
			}
			
			if ($eachClass == "CMSC203" || $eachClass == "MATH301"){
				$CMSC331flag=1;
			}
			
			array_push($_SESSION['takenArr'], $eachClass);
			echo '<tr><td height="50px"><img src="images/img_check2-30.png" /></td>';
			echo '<td id="t_'.$eachClass.'" >&nbsp;'.$eachClass.'</td></tr>';
			echo "\n";
			$i++;
		}
		if ($fourhundredflag ==1){
			array_push($_SESSION['takenArr'], "CMSC4XX");
		}
		
		if ($CMSC331flag ==1){
			array_push($_SESSION['takenArr'], "CMSC203ORMATH301");
		}



	}
	else{
	  // Show Nothing 
	}
// ? >	OLD WAY
	echo '</table>';
	echo '		</div>';
//<!-- END TAKEN -->

	echo '			</div>';

	echo '  		<div class="course-section">';
// <!-- START AVAILABLE -->
	echo '				<div id="cmsc-available" class="course-select cmsc-select">';
	echo '				<table>';


// < ? php       OLD WAY
	$imgNum = 0;
	$numClasses = count($_SESSION['classesInfo']);
	if ($id == NULL) {
		# display 2xx level classes for a guest
		#echo "NEW USER: ".$numClasses."<br>";

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
				echo '<tr><td height="50px"><img id="a_img_'.$imgNum.'" src="images/img_AddProperty-30.png" ';
				echo 'onmouseover="this.src=\'images/img_available-30.png\'" ';
				echo 'onmouseout="this.src=\'images/img_AddProperty-30.png\'" ';
				echo 'onclick="addCart(\''.$imgNum.'\',\''.$value.'\')"/></td>';
				echo '<td><input type="hidden" id="'.$value.'" value="'.$value.'">';
				echo '&nbsp;'.$value.'</td></tr>';
				echo "\n";
				$imgNum++;
			}
			if($fourhundredflag ==1 && $dsflag ==1){
				$value = "CMSC447";
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

// ? >	OLD WAY

	echo '				</table>
					</div>';
//<!-- END AVAILABLE -->

	echo '			</div>';

	echo '			<div class="course-section">';
//<!-- START CART -->
	echo '				<div id="optionInner"></div>
					<div id="cmsc-options" class="course-select cmsc-select">';
//	  <!--==================== SET IFRAME TO 0, SO IT IS INVISIBLE -->
	echo '<iframe src="optionFrame.php" id="oFrame" width="260px" height="600px" overflow-x="hidden" frameBorder="0"></iframe>';


	echo '				</div>';
//<!-- END CART -->
	echo '			</div>';
	echo '		</div>';


//		<!-- DEBUG (used to dump course data with getCoursesDebug()) -->
	echo '	<div class="clear"></div>';
	echo '  <div id="main"></div>';

//		<!-- END DEBUG -->
}

?>
</body>
</html>