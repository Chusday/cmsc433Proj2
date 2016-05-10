<?php session_start(); ?>
<!--
optionFrame.php
this file is used as an iFrame replacement underneath the CART table 
It helps to view the classes that are added to the $chosenArr (in this file) 
and also delete them if the user wants to. Gives it a dynamic feel to the 
web page
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Update Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<script src="functions.js">
</script>
</head>

<body>
	<div id="idHidden" ></div>

<?php
	echo "<table>\n";
	$oNum = 0;
	$cid = $_SESSION['userCID'];
	$uid = $_SESSION['userUID'];
//	echo $cid.", ".$uid."<br>";
	echo '<input id="userUID" type="hidden" value="'.$uid.'"></div>';
?>

<?php
	if ( ($_REQUEST["c"] != NULL)&&(!in_array($_REQUEST["c"], $_SESSION['chosenArr']) ) ){
		array_push($_SESSION['chosenArr'], $_REQUEST["c"]);
	}
	$_REQUEST["c"] = NULL;
// validation to make sure the course credits do not exceed 18 credits 
	if (count($_SESSION['chosenArr'])>6) {
		echo "\nCANNOT EXCEED 18credits!<br>REMOVE ONE<br>\n";
	}
// viewing the courses that are in the array 
	if ( count($_SESSION['chosenArr'])>0 ) {
		$oNum = 0;
		$oArr = $_SESSION['chosenArr'];
		foreach ($oArr as $oVal) {
			if($oVal == NULL){
				echo '@@@@';
			}
			echo '<div id="o_div_'.$oNum.'">';
			echo '<tr><td height="50px"><img id="o_img_'.$oNum.'" src="images/img_DeleteProperty-30.png" ';
			echo 'onmouseover="this.src=\'images/img_unavailable-30.png\'" ';
			echo 'onmouseout="this.src=\'images/img_DeleteProperty-30.png\'" ';
			echo 'onclick="deleteCart(\''.$oNum.'\',\''.$oVal.'\')"/></td>'."\n";
			echo '<td><input type="hidden" id="'.$oVal.'" value="'.$oVal.'">';
			echo '&nbsp;'.$oVal.'</td></tr>';
			echo "</div>\n";
			$oNum++;
		}	
	}
	echo "\n</table>";
	if ( !empty($_SESSION['chosenArr']) ) {
	  // basically do nothing
	  // DEBUG code
	  //	echo $cid.", ".$uid."<br>\n\n";
	  //echo '<center><button onclick="submitCart("'.$cid.'")"> SUBMIT </button></center>'
	  // echo "\n\n".$cid.", ".$uid."<br>";
	}
?>
</body>
</html>

