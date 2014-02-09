<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>File Upload Form</title>
</head>
<body>
	This form allows you to upload a file to the server.
	<br>

	<form action="./getfile.php" enctype="multipart/form-data"
		method="post">
		<br> Type (or select) Filename: <input type="file" name="uploadFile">
		<input type="hidden" name="MAX_FILE_SIZE" value="25000" /> <input
			type="submit" value="Upload File">
	</form>

</body>
</html>