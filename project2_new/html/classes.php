
<?php session_start(); ?>


<?php

$_SESSION['classesInfo'] = array(
	'CMSC201' => array('0' ),
	'CMSC202' => array('1', 'CMSC201'), 
	'CMSC203' => array('0' ), 
	'CMSC232' => array('1', 'CMSC202'),
	'CMSC291' => array('0' ),
	'CMSC299' => array('0' ),
	'CMSC304' => array('1', 'CMSC202'),
	'CMSC313' => array('2', 'CMSC202', 'CMSC203'),
	'CMSC331' => array('2', 'CMSC202', 'CMSC203'),
	'CMSC341' => array('2', 'CMSC202', 'CMSC203'),
	'CMSC391' => array('0' ),
	'CMSC404' => array('1', 'DEPCONSENT'),
	'CMSC411' => array('1', 'CMSC313'),
	'CMSC421' => array('2', 'CMSC313', 'CMSC331'),
	'CMSC426' => array('1', 'CMSC313'),
	'CMSC427' => array('1', 'CMSC341' ),
	'CMSC431' => array('3', 'CMSC313', 'CMSC331', 'CMSC341'),
	'CMSC432' => array('2', 'CMSC331', 'CMSC341'),
	'CMSC433' => array('1', 'CMSC331'),
	'CMSC435' => array('3', 'CMSC313', 'CMSC341', 'MATH221'),
	/*
	'CMSC436' => array('2' ),
	'CMSC437' => array('2' ),
	'CMSC441' => array('3' ),
	'CMSC442' => array('2' ),
	'CMSC443' => array('3' ),
	'CMSC444' => array('2' ),
	'CMSC448' => array('1' ),
	'CMSC446' => array('2' ),
	'CMSC451' => array('2' ),
	'CMSC452' => array('1' ),
	'CMSC453' => array('3' ),
	'CMSC455' => array('3' ),
	'CMSC456' => array('3' ),
	'CMSC461' => array('1' ),
	'CMSC465' => array('2' ),
	'CMSC466' => array('2' ),
	'CMSC471' => array('1' ),
	'CMSC473' => array('1' ),
	'CMSC475' => array('1' ),
	'CMSC476' => array('1' ),
	'CMSC477' => array('1' ),
	'CMSC478' => array('1' ),
	'CMSC479' => array('1' ),
	'CMSC481' => array('1' ),
	'CMSC483' => array('1' ),
	'CMSC484' => array('1' ),
	'CMSC486' => array('2' ),
	'CMSC487' => array('2' ),
	'CMSC491' => array('0' ),
	'CMSC493' => array('2' ),
	'CMSC495' => array('2', 'CMSC341', 'DEPCONSENT' ),
	'CMSC498' => array('2', 'CMSC341', 'DEPCONSENT' ),
	'CMSC499' => array('2', 'CMSC341', 'DEPCONSENT' ),*/
	'MATH152' => array('0' ),
	'MATH221' => array('0' ),
	'STAT355' => array('1', 'MATH152')

)

?>