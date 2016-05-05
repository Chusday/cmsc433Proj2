<?php
//name of the json file
$json_file = "json/courses.json";

//mysql server connection info
$server = "studentdb-maria.gl.umbc.edu";
$username = "kayoung2";
$password = "kayoung2";

//connect to the mysql server
$mysql = mysql_connect($server, $username, $password);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}

//select the XX database
$db = mysql_select_db("kayoung2", $mysql);

//query for the data
$query = "SELECT c.*, p.* FROM Courses c INNER JOIN Courses_Prereqs cp ON cp.course_id = c.course_id INNER JOIN Prereqs p ON p.prereq_id = cp.prereq_id
	ORDER BY c.course_name";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}

/*while ($course = mysql_fetch_assoc($result)) {
	var_dump($course);
	echo "<br /><br />";
}
exit;*/

//start of the json file
$json = "{\n";
$json .= "\t\"courses\": [\n";
//process the data
$course = mysql_fetch_assoc($result);
while ($course) {
	//want pretty formatting so the json is readable
	//add the info for the course
	$json .= "\t\t{\n";
	$json .= "\t\t\t\"id\": \"" . $course["course_id"] . "\",\n";
	$json .= "\t\t\t\"type\": \"" . $course["course_type"] . "\",\n";
	$json .= "\t\t\t\"credits\": \"" . $course["course_credits"] . "\",\n";
	$json .= "\t\t\t\"required\": \"" . $course["course_required"] . "\",\n";
	$json .= "\t\t\t\"senior\": \"" . $course["course_senior"] . "\",\n";
	$json .= "\t\t\t\"name\": \"" . $course["course_name"] . "\",\n";
	$json .= "\t\t\t\"desc\": \"" . $course["course_desc"] . "\",\n";

	//need to add the array of prerequisite courses
	$json .= "\t\t\t\"prereqs\": [";
	$prereqs = intval($course["course_prereqs"]);
	//none to add
	if ($prereqs == 0) {
		$json .= "]\n";
	} else {
		$passed_self = false;
		//iterate over all associated rows
		for ($i = 0; $i < $prereqs; $i++) {
			//dont need to note self as prerequisite
			if ($course["course_id"] == $course["prereq_id"]) {
				$passed_self = true;
				$course = mysql_fetch_assoc($result);
			}

			//generate the prerequisite course for json
			$json .= "\n\t\t\t\t{\n";
			$json .= "\t\t\t\t\t\"id\": \"" . $course["prereq_id"] . "\"\n";
			$json .= "\t\t\t\t}";

			if ($prereqs > 1 && $i < $prereqs - 1) {
				$json .= ",";
			}

			if ($i < $prereqs - 1 || !$passed_self) {
				//get the next associated row
				$course = mysql_fetch_assoc($result);
			}
		}
		$json .= "\n\t\t\t]\n";		
	}
	//next row for the next iteration
	$course = mysql_fetch_assoc($result);

	//end of course syntax
	$json .= "\t\t}";
	if ($course) {
		$json .= ",";
	}
	$json .= "\n";
}
$json .= "\t]\n";
$json .= "}";

//write to the file
//file_put_contents($json_file, $json);
// Check to see if functin exists 
if (!function_exists('file_put_contents')) { 

    // Define constants used by function, if not defined 
    if (!defined('FILE_USE_INCLUDE_PATH')) define('FILE_USE_INCLUDE_PATH', 1); 
    if (!defined('FILE_APPEND'))           define('FILE_APPEND', 8); 
     
    // Define function and arguments 
    function file_put_contents($json_file, &$json, $flags=0) 
    { 
        // Varify arguments are correct types 
        if (!is_string($json_file)) return(false); 
        if (!is_string($json) && !is_array($json)) return(false); 
        if (!is_int($flags)) return(false); 
         
        // Set the include path and mode for fopen 
        $include = false; 
        $mode    = 'wb'; 
         
        // If data in array type.. 
        if (is_array($json)) { 
            // Make sure it's not multi-dimensional 
            reset($json); 
            while (list(, $value) = each($json)) { 
                if (is_array($value)) return(false); 
            } 
            unset($value); 
            reset($json); 
            // Join the contents 
            $json = implode('', $json); 
        } 
         
        // Check for flags.. 
        // If include path flag givin, set include path 
        if ($flags&FILE_USE_INCLUDE_PATH) $include = true; 
        // If append flag givin, set append mode 
        if ($flags&FILE_APPEND) $mode = 'ab'; 
         
        // Open the file with givin options 
        if (!$handle = @fopen($json_file, $mode, $include)) return(false); 
        // Write data to file 
        if (($bytes = fwrite($handle, $json)) === false) return(false); 
        // Close file 
        fclose($handle); 
         
        // Return number of bytes written 
        return($bytes); 
    } 
}  

//output for testing
//echo "<pre>" . $json . "</pre>";

//close the mysql server connection
mysql_close($mysql);

