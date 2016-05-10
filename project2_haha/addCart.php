<!--
addCart.php
Used to add classes in the "cart" 
Here it is stored in an array named $oArr

-->

<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Cart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
<?php

	$newO = $_REQUEST["c"];
	if ($newO !=NULL) {
		array_push($oArr,$newO);
	}
	$_REQUEST["c"] = NULL;

	
?>
</body>
</html>