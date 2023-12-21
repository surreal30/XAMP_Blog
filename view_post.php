<?php

require_once "lib/common.php";
require_once "lib/view_post.php";

session_start();

if(isset($_GET['post_id']))
{
	$id = $_GET['post_id'];
}
else
{
	$id = 0;
}

$pdo = getPDO();
$row = getPostRow($pdo, $id);

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

    $errors = addCommentToPost($pdo, $id, $commentData);

    if(!$errors)
    {
        redirectAndExit("view_post.php?post_id=" . $id);
    }
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
	

	<h2>
		<?php echo htmlEscape($row['title']); ?>
	</h2>

	<div>
		<?php echo convertSqlDate($row['created_at']); ?>
	</div>

	<p>
		<?php echo convertNewlinesToParagraph($row['body']); ?>
	</p>

    <h3>
        <?php echo countCommentsForPost($id) . " comments"; ?>
    </h3>

    <hr>

    <?php
        foreach (getCommentsForPost($id) as $comment)
        {
        ?>
            <div class = "comment">
                <div class = "comment-meta">
                    Comment from:
                    <?php echo htmlEscape($comment['name']); ?>
                    on
                    <?php echo htmlEscape($comment['created_at']); ?>
                </div>
                <div class = "comment-body">
                    <?php echo convertNewlinesToParagraph($comment['text']); ?>
                </div>
                
            </div>
        <?php
        } ?>

    <?php require_once "templates/comment_form.php"; ?>
    

</body>
</html>