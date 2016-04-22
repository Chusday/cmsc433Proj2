<!DOCTYPE html>
<html>
	<head>
		<title>JSON Tester</title>
		<link rel="stylesheet" href="json_tester.css" />
		<!-- get the encoded json from php for javascript -->
		<script type="text/javascript">var courses_json = <?php echo($courses_json); ?>;</script>
		<script type="text/javascript" src="json_tester.js"></script>
	</head>
	<body>
		<div id="main"></div>
	</body>
</html>