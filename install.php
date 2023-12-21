<?php

require_once "lib/common.php";
require_once "lib/install.php";

// Create session
session_start();

// Only run the installer when responding to form
if($_POST)
{
    $pdo = getPDO();
    list($rowCount, $error) = installBlog($pdo);

    $password = '';
    if(!$error)
    {
        $username = "admin";
        list($password, $error) = createUser($pdo, $username);
    }

    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['count'] = $rowCount;
    $_SESSION['error'] = $error;
    $_SESSION['try-install'] = true;

    redirectAndExit('install.php');
}

$attempted = false;

if(isset($_SESSION['try-install']))
{
    $attempted = true;

    $count = $_SESSION['count'];
    $error = $_SESSION['error'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    // Unset session variable to report failure only once
    unset($_SESSION['count'], $_SESSION['error'], $_SESSION['username'], $_SESSION['password'], $_SESSION['try-install']);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <?php require "templates/head.php"; ?>
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

                    <?php // Report the count for each table ?>
                    <?php foreach (['post', 'comment'] as $tableName)
                    {
                        if(isset($count[$tableName]))
                        {
                            echo $count[$tableName] . " new " . $tableName . " were created! <br>";
                        }
                    }
                    ?>

                    <?php // Report new password ?>
                    The new '<?php echo htmlEscape($username); ?>' password is
                    <span class="install password">
                        <?php echo htmlEscape($password); ?>
                    </span> (You can copy it if you want.)
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