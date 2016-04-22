<!DOCTYPE html>
<html>
	<head>
		<title>Computer Science Degree Tracker</title>

		<!-- external stylesheet for the whole page -->
		<link rel="stylesheet" href="css/index.css">

		<!-- get the encoded json from php for javascript -->
		<script type="text/javascript">var help_info = '<?php echo($help_info); ?>';</script>
		<script type="text/javascript">var courses_json = <?php echo($courses_json); ?>;</script>

		<!-- external javascript for functions corresponding to the script names -->
		<script type="text/javascript" src="js/courses.js"></script>
		<script type="text/javascript" src="js/tooltip.js"></script>
		<script type="text/javascript" src="js/tab-content.js"></script>
		<script type="text/javascript" src="js/form.js"></script>
	</head>

	<body>
		<h1>Computer Science Degree Tracker</h1>

		<!-- global warning used by javascript for invalid user interaction notifications -->
		<div id="global-warning" style="display: none;" onmouseover="toggleGlobalWarning(false)"></div>
		
		<!-- top section of the page before the tab buttons -->
		<div id="top-section">
			<!-- container for the student information form -->
			<div id="form-div">
				<form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<!-- first name and last name -->
					<div class="form-section">
						<label for="first_name">First Name </label>
						<span class="form-error"><?php echo $first_nameErr; ?></span><br />
						<input type="text" name="first_name" tabindex="1" value="<?php echo $first_name; ?>"><br />
						<label for="last_name">Last Name </label>
						<span class="form-error"><?php echo $last_nameErr; ?></span><br />
						<input type="text" name="last_name" tabindex="2" value="<?php echo $last_name; ?>"><br />
					</div>

					<!-- email and student id -->
					<div class="form-section">
						<label for="email">Email </label>
						<span class="form-error"><?php echo $emailErr; ?></span><br />
						<input type="text" name="email" tabindex="3" value="<?php echo $email; ?>"><br />
						<label for="id">Student ID </label>
						<span class="form-error"><?php echo $idErr; ?></span><br />
						<input type="text" name="id" tabindex="4" value="<?php echo $id; ?>">
					</div>

					<!-- container for javascript to populate with course data on form submit -->
					<div id="hidden"></div>

					<div class="clear"></div>

					<!-- submit and help buttons -->
					<div id="form-submit" class="button" onclick="processForm()">Submit</div>
					<div id="help" class="button" onclick="updateTooltip()">Help</div>

					<div class="clear"></div>
				</form>	
			</div>

			<!-- the tooltip area initialized with the help_info.txt contents -->
			<div id="tooltip-container"><p id="tooltip"><?php echo $help_info; ?></p></div>
		</div>
		<!-- end of top section -->

		<!-- buttons to switch between tabs -->
		<div id="cmsc-tab-button" class="tab-button tab-button-active" onclick="changeTab('cmsc')"><p>Computer Science</p></div>
		<div id="math-tab-button" class="tab-button" onclick="changeTab('math')"><p>Math</p></div>
		<div id="sci-tab-button" class="tab-button" onclick="changeTab('sci')"><p>Science</p></div>

		<div class="clear"></div>

		<!-- container for the tab content titles -->
		<div id="tab-content-titles">
			<div class="tab-content-title"><p>Available</p></div>
			<div class="tab-content-title"><p>Taken</p></div>
			<div class="tab-content-title"><p>Options</p></div>
		</div>

		<div class="clear"></div>

		<!-- tab content container -->
		<div id="tab-content">
			<!-- computer science courses tab container -->
			<div id="cmsc-tab" class="tab">
				<div class="course-section">
					<div id="cmsc-available" class="course-select cmsc-select"></div>
				</div>

				<div class="course-section">
					<div id="cmsc-taken" class="course-select cmsc-select"></div>
				</div>

				<div class="course-section">
					<div id="cmsc-options" class="course-select cmsc-select"></div>
				</div>
			</div>

			<!-- math courses tab container -->
			<div id="math-tab" class="tab" style="display: none;">
				<div class="course-section">
					<div id="math-available" class="course-select math-select"></div>
				</div>

				<div class="course-section">
					<div id="math-taken" class="course-select math-select"></div>
				</div>

				<div class="course-section">
					<div id="math-options" class="course-select math-select"></div>
				</div>
			</div>

			<!-- science courses tab container -->
			<div id="sci-tab" class="tab" style="display: none;">
				<div class="course-section">
					<div id="sci-available" class="course-select sci-select"></div>
				</div>

				<div class="course-section">
					<div id="sci-taken" class="course-select sci-select"></div>
				</div>

				<div class="course-section">
					<div id="sci-options" class="course-select sci-select"></div>
				</div>
			</div>
		</div>
		<!-- end of tab content -->

		<!-- DEBUG (used to dump course data with getCoursesDebug()) -->
		<div class="clear"></div>
		<div id="main"></div>
		<!-- END DEBUG -->
	</body>
</html>