<?php

require_once "lib/common.php";
require_once "lib/install.php";

// Create session
session_start();

// Only run the installer when responding to form
if($_POST)
{
    $pdo = getPDO();
    list($_SESSION['count'], $_SESSION['error']) = installBlog($pdo);

    redirectAndExit('install.php');
}

$attempted = false;

if($_SESSION)
{
    $attempted = true;

    $count = $_SESSION['count'];
    $error = $_SESSION['error'];

    // Unset session variable to report failure only once
    unset($_SESSION['count'], $_SESSION['error']);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
        <?php if($attempted): ?>
            <?php if ($error): ?>
                <div class="error box">
                    <?php echo $error ?>
                </div>
            <?php else: ?>
                <div class="success box">
                    The database and demo data was created OK. <br>
                    <?php foreach (['post', 'comment'] as $tableName)
                    {
                        if(isset($count[$tableName]))
                        {
                            echo $count[$tableName] . " new " . $tableName . " were created! <br>";
                        }
                    }
                    ?>
                </div>
                <p>
                    <a href="index.php">View the blog</a>, or <a href="install.php">install again</a>
                </p>
            <?php endif; ?>
        <?php else: ?>
            <p> Click the install button to reset the database. </p>

            <form method="post">
                <input name="install" type="submit" value="Install">
            </form>
        <?php endif; ?>
    </body>
</html>