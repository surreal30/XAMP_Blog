<?php

require_once "lib/common.php";
require_once "lib/view_post.php";

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

// Swap carriage return for paragraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A blog Application | <?php echo htmlEscape($row['title']); ?> 
	</title>
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
		<?php echo $paraText; ?>
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
                    <?php echo htmlEscape($comment['text']); ?>
                </div>
                
            </div>
        <?php
        } ?>
    

</body>
</html>