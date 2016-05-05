<?php
//update the json file using the mysql server database
include("json_update.php");


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
$courses_json = json_encode(file_get_contents("../json/courses.json"));

//include the html file for the page
include("json_tester.html.php");
?>