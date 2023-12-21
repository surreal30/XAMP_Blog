<?php

/** 
 * blog installer function
 * 
 * 
 * @param \PDO $pdo
 * @return array(count array, error string)
 */
function installBlog(PDO $pdo)
{
    $root = getRootPath();
    $database = getDatabasePath();

    $error = '';

    // A security measure, to avoid anyone resetting the database if it already exists
    if (is_readable($database) && filesize($database) > 0)
    {
        $error = 'Please delete the existing database manually before installing it afresh';
    }

    // Create an empty file for the database
    if (!$error)
    {
        $createdOk = @touch($database);
        if (!$createdOk)
        {
            $error = sprintf(
                'Could not create the database, please allow the server to create new files in \'%s\'',
                dirname($database)
            );
        }
    }

    // Grab the SQL commands we want to run on the database
    if (!$error)
    {
        $sql = file_get_contents($root . '/data/init.sql');
        if ($sql === false)
        {
            $error = 'Cannot find SQL file';
        }
    }

    // Connect to the new database and try to run the SQL commands
    if (!$error)
    {
        $result = $pdo->exec($sql);
        if ($result === false)
        {
            $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
        }
    }

    // See how many rows we created, if any
    $count = [];

    foreach (['post', 'comment'] as $tableName)
    {
        if(!$error)
        {
            $sql = "SELECT COUNT(*) AS c FROM " . $tableName;
            $stmt = $pdo->query($sql);
            if ($stmt)
            {
                $count[$tableName] = $stmt->fetchColumn();
            }
        }
    }

    return [$count, $error];
}

/**
 * Create a new user in database
 * 
 * @param PDO $pdo
 * @param string $username
 * @param integer length
 * @return array Duple of (password, error)
 */
function createUser($pdo, $username, $length = 10)
{
    // Create a random password
    $alphabet = range(ord('A'), ord('Z'));
    $alphabetLength = count($alphabet);

    $password = '';
    for ($i = 0; $i < $length; $i++)
    { 
        $letterCode = $alphabet[rand(0, $alphabetLength - 1)];
        $password .= chr($letterCode);
    }

    // Insert in database
    $sql = "INSERT INTO
        user 
        (
            username, password, created_at
        ) 
        VALUES (
            ?, ?, ?
        )
    ";

    $query = $pdo->prepare($sql);

    if($query === false)
    {
        $error = "Could not prepare the query statement due to some error";
    }

    if(!$error)
    {
        $result = $query->execute([$username, $password, getSqlDateForNow()]);

        if($result === false)
        {
            $error = "Could not execute the query statement due to some error";
        }
    }

    if($error)
    {
        $password = '';
    }

    return [$password, $error];
}