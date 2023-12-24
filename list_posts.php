<?php

require_once "lib/common.php";
require_once 'lib/list_posts.php';

session_start();

// Non-auth users are redirected
if(!isLoggedIn())
{
	redirectAndExit("index.php");
}

if($_POST)
{
	$deleteResponse = $_POST['delete-post'];
	if($deleteResponse)
	{
		$keys = array_keys($deleteResponse);
		$deletePostId = $keys[0];

		if($deletePostId)
		{
			deletePost(getPDO(), $deletePostId);
			redirectAndExit("list_posts.php");
		}
	}
}

// Connect to database
$pdo = getPDO();
$posts = getAllPosts($pdo);

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
				<?php foreach($posts as $post): ?>
					<tr>
						<td>
							<?php echo htmlEscape($post['title']); ?>
						</td>
						<td>
	                            <?php echo convertSqlDate($post['created_at']); ?>
	                    </td>
						<td>
							<a href="edit_post.php?post_id=<?php echo $post['id']; ?>">Edit</a>
						</td>
						<td>
							<input type="submit" name="delete-post[<?php echo $post['id']; ?>]" value="delete">
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>

</body>
</html>