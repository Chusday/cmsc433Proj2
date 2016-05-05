//wait until everything is done loading
window.onload = init;

//this function is run after everything loads
function init() {
	//get the div with id main for writing
	var main = document.getElementById("main");
	//parse the json that was passed by php (courses_json)
	var courses = JSON.parse(courses_json);
	courses = courses["courses"];

	//generate the complete list of string representations of the course
	var course_list = getCourses(courses);

	//write all of them to the div with id main
	for (var i = 0; i < course_list.length; i++) {
		main.innerHTML += "<p>" + course_list[i] + "</p>\n";
	}	
}

/*
returns a list of string representations of all of the courses
*/
function getCourses(courses) {
	var course_list = [];
	//iterate over all of the courses in the list of type
	for (var i = 0; i < courses.length; i++) {
		if (courses[i].id == "000004") {
			continue;
		}
		//add its attributes to the string representation
		var course = "<b>Course ID:</b> " + courses[i].id + "<br />";
		course += "<b>Credits:</b> " + courses[i].credits + "<br />";
		course += "<b>Required:</b> " + courses[i].required + "<br />";
		course += "<b>Senior:</b> " + courses[i].senior + "<br />";
		course += "<b>Course Name:</b> " + courses[i].name + "<br />";
		course += "<b>Course Description:</b><br />" + courses[i].desc + "<br />";

		//add all of the names of its prerequisites
		course += "<b>Prerequisites:</b><br />";
		var prereqs = courses[i].prereqs;
		//no prerequisites
		if (prereqs.length == 0) {
			course += "&nbsp;&nbsp;&nbsp;&nbsp;None<br />";
		//has prerequisites
		} else {
			//get the course name of the prerequisite using its course id
			for (var j = 0; j < prereqs.length; j++) {
				var prereq = findCourse(courses, prereqs[j].id);
				course += "&nbsp;&nbsp;&nbsp;&nbsp;" + prereq.name + "<br />";
			}			
		}

		course_list.push(course);
	}

	return course_list;
}

/*
returns the object representing the course from the list of type with a course
id of id
*/
function findCourse(courses, id) {
	//search through the courses
	for (var i = 0; i < courses.length; i++) {
		//found the course, return it
		if (courses[i].id == id) {
			return courses[i];
		}
	}
	//doesn't exist (should never happen)
	return null;
}