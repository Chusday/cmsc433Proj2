<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Update Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript">
function deleteCart (Ith,val) {

	alert(val);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "deleteCart.php?d=" + val , true);
	xmlhttp.send();

	window.location.replace('optionFrame.php');

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
	window.parent.location.reload();
	}else{
		return;
	}

}
</script>
</head>

<body>
	<div id="idHidden" ></div>
<?php
	
	echo "<table>\n";
	$oNum = 0;
	$cid = $_SESSION['userCID'];
	$uid = $_SESSION['userUID'];
	echo $cid.", ".$uid."<br>";
	echo '<input id="userUID" type="hidden" value="'.$uid.'"></div>';

?>

<?php
	if ( ($_REQUEST["c"] != NULL)&&(!in_array($_REQUEST["c"], $_SESSION['chosenArr']) ) ){
		array_push($_SESSION['chosenArr'], $_REQUEST["c"]);
	}
	$_REQUEST["c"] = NULL;
	
	if (count($_SESSION['chosenArr'])>6) {
		echo "\nCANNOT EXCEED 18credits!<br>REMOVE ONE<br>\n";
	}
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
			echo $cid.", ".$uid."<br>\n\n";
		
		//echo '<center><button onclick="submitCart("'.$cid.'")"> SUBMIT </button></center>';
		?>


		<?php

		echo "\n\n".$cid.", ".$uid."<br>";
	}
	

?>



</body>
</html>

