<?php

require_once "lib/common.php";
require_once "lib/view_post.php";

session_start();

if(isset($_GET['post_id']))
{
	$postId = $_GET['post_id'];
}
else
{
	$postId = 0;
}

$pdo = getPDO();
$row = getPostRow($pdo, $postId);

if(!$row)
{
    redirectAndExit("index.php?not_found=1");
}

$errors = null;

if($_POST)
{
    $commentData = [
        "name"    => $_POST["comment-name"],
        "website" => $_POST["comment-website"],
        "text"    => $_POST["comment-text"]
    ];

    $errors = handleAddComment($pdo, $postId, $commentData);
}
else
{
    $commentData = [
        "name" => '',
        "website" => '',
        "text" => ''
    ];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A blog Application | <?php echo htmlEscape($row['title']); ?> 
	</title>
    <?php require 'templates/head.php'; ?>
</head>
<body>
    <?php require_once "templates/title.php"; ?>
	
    <div class="post">
    	<h2>
    		<?php echo htmlEscape($row['title']); ?>
    	</h2>
    </div>

	<div class="date">
		<?php echo convertSqlDate($row['created_at']); ?>
	</div>

	<p>
		<?php echo convertNewlinesToParagraph($row['body']); ?>
	</p>

    <hr>

    <?php require "templates/list_comments.php"; ?>

    <?php // We use $commentData in this HTML fragment ?>
    <?php require_once "templates/comment_form.php"; ?>
    

</body>
</html>