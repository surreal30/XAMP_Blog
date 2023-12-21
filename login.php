<?php

require_once "lib/common.php";

// Check for minimum version of PHP
if(version_compare(PHP_VERSION, '5.3.7') < 0)
{
	throw new Exception("This system needs PHP 5.3.7 or late");
}

session_start();

$username = '';
// Handle the form posting
if($_POST)
{
	// Initialise database
	$pdo = getPDO();

	// Redirect only if the password is correct
	$username = $_POST['username'];
	$ok = tryLogin($pdo, $username, $_POST['password']);
	if($ok)
	{
		login($username);
		redirectAndExit("index.php");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A Blog Application | Login
	</title>
    <?php require "templates/head.php"; ?>

</head>
<body>
	<?php include "templates/title.php"; ?>

	<?php // If we have username then the user didn't login due to some error 
	if($username): ?>
		<div class="error box">
                The username or password is incorrect, try again
        </div>
    <?php endif; ?>


	<p>Login here</p>
	<form method="post">
		<p>
			Username: 
			<input type="text" name="username" value="<?php echo htmlEscape($username); ?>">
		</p>
		<p>
			Password: 
			<input type="text" name="password">
		</p>
		<input type="submit" name="submit" value="Login">
	</form>

</body>
</html>