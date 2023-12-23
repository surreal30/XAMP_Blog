<?php

require_once "lib/common.php";

session_start();

// Non-auth users are redirected
if(!isLoggedIn())
{
	redirectAndExit("index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>A Blog Application | Blog Posts</title>
	<?php require_once "templates/head.php"; ?>
</head>
<body>
	<?php require_once "templates/top_menu.php"; ?>

	<h1>Post List</h1>

	<form method="post">
		<table id="post-list">
			<tbody>
				<tr>
					<td>
						Title of the first post
					</td>
					<td>
                            dd MM YYYY h:mi
                    </td>
					<td>
						<a href="edit_post.php?post_id=1">Edit</a>
					</td>
					<td>
						<input type="submit" name="post[1]" value="delete">
					</td>
				</tr>
				<tr>
					<td>
						Title of the second post
					</td>
					<td>
                            dd MM YYYY h:mi
                    </td>
					<td>
						<a href="edit_post.php?post_id=2">Edit</a>
					</td>
					<td>
						<input type="submit" name="post[2]" value="delete">
					</td>
				</tr>
				<tr>
					<td>
						Title of the third post
					</td>
					<td>
                            dd MM YYYY h:mi
                    </td>
					<td>
						<a href="edit_post.php?post_id=3">Edit</a>
					</td>
					<td>
						<input type="submit" name="post[3]" value="delete">
					</td>
				</tr>
			</tbody>
		</table>
	</form>

</body>
</html>