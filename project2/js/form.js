/*
Functions:
processForm()
coursesTaken()
generateHidden(course, type)
*/

/*
processForm()
ensures at least one class has been taken then generates hidden input fields
of the course ids from the courses taken and courses options objects of each
class type then submits the form
*/
function processForm() {
	var hidden_content = "";

	//make sure one class has been taken
	if (!coursesTaken()) {
		var message = "Please select at least one class as taken.";
		toggleGlobalWarning(true, message);
		return;
	}

	//generate the hidden form fields for each course taken
	for (var i = 0; i < courses_taken["cmsc"].length; i++) {
		hidden_content += generateHidden(courses_taken["cmsc"][i], "taken");
	}
	for (var i = 0; i < courses_taken["math"].length; i++) {
		hidden_content += generateHidden(courses_taken["math"][i], "taken");
	}
	for (var i = 0; i < courses_taken["sci"].length; i++) {
		hidden_content += generateHidden(courses_taken["sci"][i], "taken");
	}

	//generate the hidden form fields for each course option
	for (var i = 0; i < courses_options["cmsc"].length; i++) {
		hidden_content += generateHidden(courses_options["cmsc"][i], "options");
	}
	for (var i = 0; i < courses_options["math"].length; i++) {
		hidden_content += generateHidden(courses_options["math"][i], "options");
	}
	for (var i = 0; i < courses_options["sci"].length; i++) {
		hidden_content += generateHidden(courses_options["sci"][i], "options");
	}

	//set the hidden content element
	document.getElementById("hidden").innerHTML = hidden_content;

	//submit the form
	document.getElementById("form").submit();
}

/*
coursesTaken()
returns true if at least one class has been taken, otherwise false
*/
function coursesTaken() {
	return courses_taken["cmsc"].length != 0 ||
		courses_taken["math"].length != 0 ||
		courses_taken["sci"].length != 0;
}

/*
generateHidden(course, type)
course - a course object
type   - taken or options (hidden field array naming)
returns a string of an html input field with the name asocciated with the type
and value of the course id from the course object
*/
function generateHidden(course, type) {
	return "<input type=\"hidden\" name=\"courses_" + type + "[]\" value=\"" + course.id + "\" />";
}