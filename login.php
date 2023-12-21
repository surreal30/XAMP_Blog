<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A Blog Application | Login
	</title>
</head>
<body>
	<?php include "templates/title.php"; ?>

	<form method="post">
		<p>
			Username: 
			<input type="text" name="username">
		</p>
		<p>
			Password: 
			<input type="text" name="password">
		</p>
		<input type="submit" name="submit" value="Login">
	</form>

</body>
</html>