<?php
//defined functions
require("functions.php");

//database connection variables
$db_server = "studentdb-maria.gl.umbc.edu";
$db_username = "kayoung2";
$db_password = "kayoung2";
$db_dbname = "kayoung2";

$error = false;
$first_name = $last_name = $email = $id = "";
$first_nameErr = $last_nameErr = $emailErr = $idErr = "";

//validate the post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//first name
	if (empty($_POST["first_name"])) {
		$error = true;
		$first_nameErr = "Required";
	} else {
		$first_name = test_input($_POST["first_name"]);
		if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
			$error = true;
			$first_nameErr = "Invalid";
		}
	}

	//last name
	if (empty($_POST["last_name"])) {
		$error = true;
		$last_nameErr = "Required";
	} else {
		$last_name = test_input($_POST["last_name"]);
		if (!preg_match("/^[a-zA-Z\-]*$/", $last_name)) {
			$error = true;
			$last_nameErr = "Invalid";
		}
	}

	//email address
	if (empty($_POST["email"])) {
		$error = true;
		$emailErr = "Required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$emailErr = "Invalid";
		}
	}

	//student id number
	if (empty($_POST["id"])) {
		$error = true;
		$idErr = "Required";
	} else {
		$id = test_input($_POST["id"]);
		if (!preg_match("/^[A-Z]{2}[0-9]{6}$/", $id)) {
			$error = true;
			$idErr = "Invalid";
		}
	}

	//add entry to the database if no form errors
	if (!$error) {
		//connect to the mysql server
		$mysql = mysql_connect($db_server, $db_username, $db_password);
		if (!$mysql) {
			die("Could not connect to the database: " . mysql_error());
		}
		//select the database
		$db = mysql_select_db($db_dbname, $mysql);

		//query for the student based on the provided id
		$query = "SELECT * FROM Students WHERE student_id = '$id'";
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}

		//if they don't exist, add them
		$num_results = mysql_num_rows($result);
		if ($num_results < 1) {
			$query = "INSERT INTO Students 
				(student_id, student_first_name, student_last_name, student_email, date_added)
				VALUES ('$id', '$first_name', '$last_name', '$email', CURRENT_TIMESTAMP)";
			$result = mysql_query($query);
			if (!$result) {
				die("Error: " . mysql_error() . "<br />Query: " . $query);
			}
		//if they do exist update their information
		} else {
			$query = "UPDATE Students SET
				student_first_name = '$first_name', student_last_name = '$last_name',
				student_email = '$email' WHERE
				student_id = '$id'";
			$result = mysql_query($query);
			if (!$result) {
				die("Error: " . mysql_error() . "<br />Query: " . $query);
			}
		}

		//remove their previous submission of courses taken and options
		$query = "DELETE FROM Students_Courses_Taken WHERE student_id = '$id'";
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}
		$query = "DELETE FROM Students_Courses_Options WHERE student_id = '$id'";
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}

		//insert the courses they have taken
		$query = "INSERT INTO Students_Courses_Taken (student_id, course_id) VALUES";
		$first = true;
		foreach ($_POST["courses_taken"] as $course_id) {
			if (!$first) {
				$query .= ",";
			}
			$first = false;
			$query .= " ('$id', '$course_id')";
		}
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}

		//insert the courses they have as options
		$query = "INSERT INTO Students_Courses_Options (student_id, course_id) VALUES";
		$first = true;
		foreach ($_POST["courses_options"] as $course_id) {
			if (!$first) {
				$query .= ",";
			}
			$first = false;
			$query .= " ('$id', '$course_id')";
		}
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}

		//include the html file for the thank you page
		require("html/index-thanks.html.php");
		exit;
	}
}

//grab the help information for the tooltip for javascript
$help_info = str_replace("\n", "<br />", file_get_contents("data/help_info.txt"));

//update the json file using the mysql server database


/*require("json_update.php");

if (!function_exists('json_encode')) {
function json_encode($data) {
    switch (gettype($data)) {
        case 'boolean':
            return $data?'true':'false';
        case 'integer':
        case 'double':
            return $data;
        case 'string':
            return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"')).'"';
        case 'array':
            $rel = false; // relative array?
            $key = array_keys($data);
            foreach ($key as $v) {
                if (!is_int($v)) {
                    $rel = true;
                    break;
                }
            }

            $arr = array();
            foreach ($data as $k=>$v) {
                $arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').json_encode2($v);
            }

            return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
        default:
            return '""';
    }
}
}
//grab the contents of the json file and encode them for sending to javascript
$courses_json = json_encode(file_get_contents("json/courses.json"));

*/


//include the html file for the page
require("html/index.html.php");
?>