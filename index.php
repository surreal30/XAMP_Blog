<?php

require_once "lib/common.php";

session_start();

$pdo = getPDO();

$result = $pdo->query("
        SELECT 
          id,
          title, 
          created_at, 
          body 
        FROM 
          post 
        ORDER BY 
          created_at DESC
    ");

if($result === false)
{
    throw new Exception("Error in running this query");
}

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
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                    <div class="post-synopsis">
                        <h2> <?php echo htmlEscape($row['title']);?> </h2>
                        <div class="meta">
                            <?php echo convertSqlDate($row['created_at']);?>
                                
                            </div>
                        <?php echo countCommentsForPost($pdo, $row['id']); ?> comments
                        <p> <?php echo htmlEscape($row['body']);?> </p>
                        <div class="post-controls">
                                <a href="view_post.php?post_id=<?php echo $row['id']; ?>">Read more...</a>
                                <?php if(isLoggedIn()): ?>
                                    <a href="edit_post.php?post_id=.<?php echo $row['id']; ?>">Edit</a>
                                <?php endif; ?>
                        </div>
                    </div>
                <?php
                }
            ?>     
            </div>   
    </body>
</html>