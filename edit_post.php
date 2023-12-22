<?php

require_once 'lib/common.php';

session_start();

if(!isLoggedIn())
{
	redirectAndExit('index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>A Blog Implementation | New Post</title>
	<?php require_once "templates/head.php"; ?>
</head>
<body>
	<?php require_once "templates/title.php"; ?>

	<form method="post" class="post-form user-form">
		<div>
			<label for="post-title">Title:</label>
			<input type="text" name="post-title" id="post-title">
		</div>
		<div>
			<label for="post-body">Body:</label>
			<textarea id="post-body" name="post-body" rows="12" cols="70"></textarea>
		</div>
		<div>
			<input type="submit" name="submit" value="Save post">
		</div>
	</form>

</body>
</html>