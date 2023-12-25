<?php

require_once "lib/common.php";

session_start();

$pdo = getPDO();
$posts = getAllPosts($pdo);

$notFound = isset($_GET['not_found']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <?php require "templates/head.php"; ?>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require_once "templates/title.php";

            if($notFound)
            {
            ?>
                <div class="error box">
                    Error: cannot find the requested blog post
                </div>
            <?php
            }
            ?>
            <div class="post-list">
            <?php
                foreach($posts as $post)
                {
                ?>
                    <div class="post-synopsis">
                        <h2> <?php echo htmlEscape($post['title']);?> </h2>
                        <div class="meta">
                            <?php echo convertSqlDate($post['created_at']);?>
                                
                            </div>
                        <?php echo $post['comment_count']; ?> comments
                        <p> <?php echo htmlEscape($post['body']);?> </p>
                        <div class="post-controls">
                                <a href="view_post.php?post_id=<?php echo $post['id']; ?>">Read more...</a>
                                <?php if(isLoggedIn()): ?>
                                    <a href="edit_post.php?post_id=.<?php echo $post['id']; ?>">Edit</a>
                                <?php endif; ?>
                        </div>
                    </div>
                <?php
                }
            ?>     
            </div>   
    </body>
</html>