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
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require_once "templates/title.php";

            if($notFound)
            {
            ?>
                <div style="border: 1px solid #ff6666; padding: 6px;">
                    Error: cannot find the requested blog post
                </div>
            <?php
            }
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
            ?>
                <h2> <?php echo htmlEscape($row['title']);?> </h2>
                <div> <?php echo convertSqlDate($row['created_at']);?> </div>
                <?php echo countCommentsForPost($row['id']); ?> comments
                <p> <?php echo htmlEscape($row['body']);?> </p>
                <p>
                    <a href="view_post.php?post_id=<?php echo $row['id']; ?>">Read more...</a>
                </p>
            <?php
            }
        ?>        
    </body>
</html>