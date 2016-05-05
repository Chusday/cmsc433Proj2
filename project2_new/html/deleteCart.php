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

<?php
	echo '<table>';
	$oNum = 0;
	$oArr = $_SESSION['chosen'];
	foreach ($oArr as $oVal) {
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

	echo '</table>';







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

	$newO = $_REQUEST["c"];
	if ($newO !=NULL) {
		array_push($oArr,$newO);
	}
	$_REQUEST["c"] = NULL;
	

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