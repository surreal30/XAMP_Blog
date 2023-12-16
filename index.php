<?php

$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

$pdo = new PDO($dsn);

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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require_once "templates/title.php"; ?>
        <!-- <h1>Blog title</h1>
        <p>This paragraph summarises what the blog is about.</p> -->
        <?php
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
            ?>
                <h2> <?php echo $row['title'];?> </h2>
                <div> <?php echo $row['created_at'];?> </div>
                <p> <?php echo $row['body'];?> </p>
                <p>
                    <a href="view_post.php?post_id=<?php echo $row['id']; ?>">Read more...</a>
                </p>
            <?php
            }
        ?>        
    </body>
</html>