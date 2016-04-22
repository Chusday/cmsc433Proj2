<?php
//update the json file using the mysql server database
include("json_update.php");

//grab the contents of the json file and encode them for sending to javascript
$courses_json = json_encode(file_get_contents("../json/courses.json"));

//include the html file for the page
include("json_tester.html.php");
?>