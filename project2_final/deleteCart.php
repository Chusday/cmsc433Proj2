<?php session_start(); 
/*
deleteCart.php
This file actually helps to remove the class that the 
user choses to remove from the cart. It is just a function 
that removes a certain element selected by the user from 
cart table. 

 */
function removeArrElement($inArr, $elementNr) {

  for ($i = $elementNr; $i < count($inArr) - 1; $i++) {
    $inArr[$i] = $inArr[$i + 1];
  }
  unset($inArr[count($inArr) - 1]);
  
  return $inArr;
}
  if ($_REQUEST["d"] != NULL) {
    $i = 0;
    $del_value = $_REQUEST["d"];
  
    foreach ($_SESSION['chosenArr'] as $value) {
      if ($value == $del_value) {
	//echo "<br>___ ".$_SESSION['chosenArr'][$i]."<br>";
	//unset($_SESSION['chosenArr'][$i]);
	$_SESSION['chosenArr'] = removeArrElement($_SESSION['chosenArr'],$i);
      }
      $i++;
    }
  }

?>
