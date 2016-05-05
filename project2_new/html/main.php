<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Computer Science Degree Tracker</title>

		<!-- external stylesheet for the whole page -->
		<link rel="stylesheet" href="css/index.css">


		<script type="text/javascript" src="js/tooltip.js"></script>
		<script type="text/javascript" src="js/tab-content.js"></script>
		<script type="text/javascript" src="js/form.js"></script>
<?php 	$oArr = array('CMSC304','CMSC313','CMSC331','CMSC341'); ?>		
<script type="text/javascript">
function crtChild (id) {

}

function addCart (Ith,val) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "html/optionFrame.php?c=" + val , true);
	xmlhttp.send();
	alert(Ith);

	var oiframe = document.getElementById('oFrame');
	oiframe.contentWindow.location.reload(true);

	alert(val);

}
function deleteCart (Ith,val) {
	// body...
	alert(Ith);
	alert(val);
	document.getElementById("o_div_"+Ith).style.visibility = "hidden";

}
/*
function changeImgMouseOver (imgNum) {
	// body...
	var id = "a_img_" + imgNum;
	document.getElementById(id).src="images/img_available-30.png";
}

function changeImgMouseOut (imgNum) {
	// body...
	var id = "a_img_" + imgNum;
	document.getElementById(id).src="images/img_AddProperty-30.png";
}*/
</script>
	</head>

	<body>

<?php

	$_SESSION['chosen'] = array();
	array_push($_SESSION['chosen'], "TEST000");
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
			<!-- container for the student information form -->
			<div id="form-div">
				<form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<!-- first name and last name -->
					<div class="form-section">
						<label for="first_name">First Name </label>
						<span class="form-error"><?php echo $first_nameErr; ?></span><br />
						<input type="text" name="first_name" tabindex="1" value="<?php echo $first_name; ?>"><br />
						<label for="last_name">Last Name </label>
						<span class="form-error"><?php echo $last_nameErr; ?></span><br />
						<input type="text" name="last_name" tabindex="2" value="<?php echo $last_name; ?>"><br />
					</div>

					<!-- email and student id -->
					<div class="form-section">
						<label for="email">Email </label>
						<span class="form-error"><?php echo $emailErr; ?></span><br />
						<input type="text" name="email" tabindex="3" value="<?php echo $email; ?>"><br />
						<label for="id">Student ID </label>
						<span class="form-error"><?php echo $idErr; ?></span><br />
						<input type="text" name="id" tabindex="4" value="<?php echo $id; ?>">
					</div>

					<!-- container for javascript to populate with course data on form submit -->
					<div id="hidden"></div>

					<div class="clear"></div>

					<!-- submit and help buttons -->
					<div id="form-submit" class="button" onclick="processForm()">Submit</div>
					<div id="help" class="button" onclick="updateTooltip()">Help</div>

					<div class="clear"></div>
				</form>	
			</div>

			<!-- the tooltip area initialized with the help_info.txt contents -->
			<div id="tooltip-container"><p id="tooltip"><?php echo $help_info; ?></p></div>
		</div>
		<!-- end of top section -->

		<!-- buttons to switch between tabs -->
		<div id="cmsc-tab-button" class="tab-button tab-button-active" onclick="changeTab('cmsc')"><p>Computer Science</p></div>
		<div id="math-tab-button" class="tab-button" onclick="changeTab('math')"><p>Math</p></div>
		<div id="sci-tab-button" class="tab-button" onclick="changeTab('sci')"><p>Science</p></div>

		<div class="clear"></div>

		<!-- container for the tab content titles -->
		<div id="tab-content-titles">
			<div class="tab-content-title"><p>Available</p></div>
			<div class="tab-content-title"><p>Taken</p></div>
			<div class="tab-content-title"><p>Options</p></div>
		</div>

		<div class="clear"></div>

		<!-- tab content container -->
		<div id="tab-content">
			<!-- computer science courses tab container -->
			<div id="cmsc-tab" class="tab">
				<div class="course-section">
<!-- START AVAILABLE -->
					<div id="cmsc-available" class="course-select cmsc-select">
					<table>

<?php
$id = NULL; #DEBUG
$cmscArr = array('CMSC201','CMSC232','CMSC291','CMSC352','CMSC391');
$imgNum = 0;
if ($id == NULL) {
	# display 2xx level classes for a guest

	foreach ($cmscArr as $value) {
		echo '<tr><td height="50px"><img id="a_img_'.$imgNum.'" src="images/img_AddProperty-30.png" ';
		echo 'onmouseover="this.src=\'images/img_available-30.png\'" ';
		echo 'onmouseout="this.src=\'images/img_AddProperty-30.png\'" ';
		echo 'onclick="addCart(\''.$imgNum.'\',\''.$value.'\')"/></td>';
		echo '<td><input type="hidden" id="'.$value.'" value="'.$value.'">';
		echo '&nbsp;'.$value.'</td></tr>';
		echo "\n";
		$imgNum++;
	}
} else {
	# display available classes
	$num = mysql_numrows($takenResult);
	$i=0;
	while ($i < $num) {
		echo '<tr><td height="50px"><img id="a_img_'.$imgNum.'" src="images/img_AddProperty-30.png" ';
		echo 'onclick="addCart("'.$imgNum.'","'.$value.'")"/></td>';
		echo '<td><input type="hidden" id="'.$value.'" value="'.$value.'">';
		echo '&nbsp;'.$value.'</td></tr>';
		echo "\n";
		$imgNum++;
	}
}


?>
					</table>
					</div>
<!-- END AVAILABLE -->
				</div>

				<div class="course-section">
<!-- START TAKEN -->
					<div id="cmsc-taken" class="course-select cmsc-select">
<table>
<?php

	$id=1;
	if($id!=NULL) {
		$takenQ = "SELECT `class_id` FROM `proj2_taken` WHERE student_id = $id";
		$takenResult = mysql_query($takenQ);
		if(! $takenResult){
			print("ERROR TAKEN 2: QUARY");
			print mysql_error();
			exit;
		}
		$num = mysql_numrows($takenResult);
		$i=0;
		while ($i < $num) {
			$eachClass = mysql_result($takenResult, $i, 'class_id');
			echo '<tr><td height="50px"><img src="images/img_check2-30.png" /></td>';
			echo '<td id="t_'.$eachClass.'" >&nbsp;'.$eachClass.'</td></tr>';
			echo "\n";
			$i++;
		}

	}
?>
</table>
					</div>
<!-- END TAKEN -->
				</div>

				<div class="course-section">
<!-- START OPTIONS -->
					<div id="optionInner"></div>
					<div id="cmsc-options" class="course-select cmsc-select">

	<iframe src="html/optionFrame.php" id="oFrame" width="150px"></iframe>
<?php

/*
	$oNum = 0;

	foreach ($oArr as $oVal) {
		echo '<div id="o_div_'.$oNum.'" style="visibility: hidden;">';
		echo '<tr><td height="50px"><img id="o_img_'.$oNum.'" src="images/img_DeleteProperty-30.png" ';
		echo 'onmouseover="this.src=\'images/img_unavailable-30.png\'" ';
		echo 'onmouseout="this.src=\'images/img_DeleteProperty-30.png\'" ';
		echo 'onclick="deleteCart(\''.$oNum.'\',\''.$oVal.'\')"/></td>';
		echo '<td><input type="hidden" id="'.$oVal.'" value="'.$oVal.'">';
		echo '&nbsp;'.$oVal.'</td></tr>';
		echo "</div>\n";
		$oNum++;
	}

*/
?>





					</div>
<!-- END OPTIONS -->
				</div>
			</div>

			<!-- math courses tab container -->
			<div id="math-tab" class="tab" style="display: none;">
				<div class="course-section">
					<div id="math-available" class="course-select math-select"></div>
				</div>

				<div class="course-section">
					<div id="math-taken" class="course-select math-select"></div>
				</div>

				<div class="course-section">
					<div id="math-options" class="course-select math-select"></div>
				</div>
			</div>

			<!-- science courses tab container -->
			<div id="sci-tab" class="tab" style="display: none;">
				<div class="course-section">
					<div id="sci-available" class="course-select sci-select"></div>
				</div>

				<div class="course-section">
					<div id="sci-taken" class="course-select sci-select"></div>
				</div>

				<div class="course-section">
					<div id="sci-options" class="course-select sci-select"></div>
				</div>
			</div>
		</div>


		<!-- end of tab content -->

		<!-- DEBUG (used to dump course data with getCoursesDebug()) -->
		<div class="clear"></div>
		<div id="main"></div>
		<!-- END DEBUG -->
	</body>
</html>