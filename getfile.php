<html>
<head>
<title>Process Uploaded File</title>
<link type="text/css" href="presentation.css" rel="stylesheet">
</head>
<body>
<?php

echo "file is " . $_FILES['uploadFile'] ['tmp_name'] . "<br><br>";

$target_file = $_FILES['uploadFile'] ['tmp_name'];

function __autoload($class) {
	// convert namespace to full file path
	$class = str_replace('\\', '/', $class) . '.php';
	require_once($class);
}

use lib\powerpoint\PowerPoint;

$powerpoint = new Powerpoint($target_file);
$powerpoint->buildAll();
echo "Number of slides:   " . $powerpoint->getNumberOfSlides() . "<br>";
echo "The first slide is: " . $powerpoint->getSlide(0)->filename . "<br>";
echo $powerpoint->getHTML();

unlink($_FILES['uploadFile'] ['tmp_name']);
echo "<br>file removed<br>";

?>

</body>
</html>
