<?php

require_once 'lib/common.php';
require_once 'lib/edit_post.php';

session_start();

if(!isLoggedIn())
{
	redirectAndExit('index.php');
}

// Handle post operations
$errors = [];
if($_POST)
{
	// Validate input
	$title = $_POST['post-title'];
	if(!$title)
	{
		$errors[] = "The post must have a title";
	}

	$body = $_POST['post-body'];
	if(!$body)
	{
		$errors[] = "The post must have a body";

	}

	if(!$errors)
	{
		$pdo = getPDO();
		$userId = getAuthUserId($pdo);
		$postId = addPost($pdo, $title, $body, $userId);

		if($postId === false)
		{
			$errors[] = "Post operations failed";
		}
	}

	if(!$errors)
	{
		redirectAndExit("edit_post.php?post_id=" . $postId);
	}
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

	<?php if($errors): ?>
		<div class="error box">
			<ul>
				<?php foreach ($errors as $error): ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

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