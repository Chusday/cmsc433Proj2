/*
Functions:
initTabContent()
toggleGlobalWarning(message, timeout)
changeTab(type)
makeTabButtonActive(type)
adjustScrollContent(type)
scrollTabContent(event, id)
*/

//timeout for the global warning
var global_warning_timeout;

//top offset from the top of the page
var tab_start_top;

//height in pixels of the selection areas
var selection_area_height = 400;
//margin in pixels at the bottom of the selection areas
var selection_area_padding = 15;

//number of pixels to scroll per scroll event
var tab_scroll_rate = 20;

/*
initTabContent()
initializes tab_start_top and adds event listeners for the selection area elements
*/
function initTabContent() {
	//initialize the top offset
	tab_start_top = document.getElementById("cmsc-available").offsetTop;

	/*
	add an event listener to each tab selection area that calls
	scrollTabContent with the event and the id of the element; this must be done
	explicitly for each element
	*/

	//cmsc
	var cmsc_available = document.getElementById("cmsc-available");
	cmsc_available.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "cmsc-available");
	});
	var cmsc_taken = document.getElementById("cmsc-taken");
	cmsc_taken.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "cmsc-taken");
	});
	var cmsc_options = document.getElementById("cmsc-options");
	cmsc_options.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "cmsc-options");
	});

	//math
	var math_available = document.getElementById("math-available");
	math_available.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "math-available");
	});
	var math_taken = document.getElementById("math-taken");
	math_taken.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "math-taken");
	});
	var math_options = document.getElementById("math-options");
	math_options.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "math-options");
	});

	//sci
	var sci_available = document.getElementById("sci-available");
	sci_available.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "sci-available");
	});
	var sci_taken = document.getElementById("sci-taken");
	sci_taken.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "sci-taken");
	});
	var sci_options = document.getElementById("sci-options");
	sci_options.addEventListener("wheel", function(event) {
		event.preventDefault();
		scrollTabContent(event, "sci-options");
	});
}

/*
toggleGlobalWarning(status, message, timeout)
status  - indicates whether to show or hide the warning
message - the message to put into the element with id "global-warning"
timeout - time to wait until the message is hidden again (default 5 seconds)
Toggles the display of the element with id "global-warning" and sets the
contents to message, sets a timeout to hide the message
*/
function toggleGlobalWarning(status, message = "", timeout = 5000) {
	//get the element with id "global-warning"
	var global_warning = document.getElementById("global-warning");

	//clear the global warning timeout
	clearTimeout(global_warning_timeout);

	//show the warning if status is true and set the timeout to hide it
	if (status) {
		global_warning.innerHTML = "<p>" + message + "</p>";
		global_warning.style.display = "inline";
		global_warning_timeout = setTimeout(function() {
			global_warning.style.display = "none";
		}, timeout);
	//hide the warning	
	} else {
		global_warning.style.display = "none";
	}
}

/*
changeTab(type)
type - type of courses (cmsc, math, sci)
displays the active tab based on type and hides the others
*/
function changeTab(type) {
	//get all of the tabs and hide them
	var tabs = document.getElementsByClassName("tab");
	for (var i = 0; i < tabs.length; i++) {
		tabs[i].style.display = "none";
	}
	
	//display the active tab based on type
	document.getElementById(type + "-tab").style.display = "inline";

	makeTabButtonActive(type);
}

/*
makeTabButtonActive(type)
type - type of courses (cmsc, math, sci)
resets the classes of the tab buttons and adds the active class to the tab
button of type
*/
function makeTabButtonActive(type) {
	var buttons = document.getElementsByClassName("tab-button");
	var button = document.getElementById(type + "-tab-button");

	for (var i = 0; i < buttons.length; i++) {
		buttons[i].className = "tab-button";
	}

	button.className += " tab-button-active";
}

/*
adjustScrollContent(type)
type - type of courses (cmsc, math, sci)
respositions the internal divs of the selection areas of type to be within a
range defined by the height of the div
*/
function adjustScrollContent(type) {
	//get all of the selection area elements
	var selections = document.getElementsByClassName(type + "-select");

	//iterate over the selection area elements
	for (var i = 0; i < selections.length; i++) {
		/*
		get the current offset height of the object, this will be NaN if the
		element is hidden
		*/
		var height = selections[i].offsetHeight;

		var top;
		//only compute if height is a number and more than the selection area
		if (!isNaN(height) && height >= selection_area_height) {
			//compute the relative top offset based on that value and the start
			top = selections[i].offsetTop - tab_start_top;

			//reduce the top based on the height
			if (top < (height * (-1)) + selection_area_height) {
				top = (height * (-1)) + selection_area_height;
			}
		} else {
			top = 0;
		}

		//update the top style of the element
		selections[i].style.top = top + "px";
	}

}

/*
scrollTabContent(event, id)
event - a javascript wheel event object
id 	  - id of a selection area div
repositions the div element with id based on the wheel event
*/
function scrollTabContent(event, id) {
	//get the selection area element
	var selection = document.getElementById(id);
	//get the current offset height of the object
	var height = selection.offsetHeight;
	//compute the relative top offset based on that value and the start one
	var top = selection.offsetTop - tab_start_top;

	//normalize the scroll delta
	var normal_delta = event.deltaY / event.deltaY;
	if (event.deltaY < 0) {
		normal_delta *= (-1);
	}

	//reverse the direction of the delta for scrolling
	var reverse_delta = normal_delta * (-1);

	//compute the distance in pixels to scroll
	var scroll_dist = reverse_delta * tab_scroll_rate;

	//compute the new top value
	var scroll = top + scroll_dist;

	//set the style if the top value is within specified bounds
	if (scroll <= 0 && scroll > ((height * (-1)) + 
		(selection_area_height - selection_area_padding))) {
		selection.style.top = scroll + "px";	
	}

}