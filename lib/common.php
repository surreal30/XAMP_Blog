<?php

/** 
 * Get the root path of the project
 * 
 * @return string
 */
function getRootPath()
{
	return realpath(__DIR__ . '/..');
}

/**
 *  Get the full path of database file
 * 
 * @return string
 */
function getDatabasePath()
{
	return getRootPath() . "/data/data.sqlite";
}

/**
 *  Get the DSN for the SQLite connection
 * 
 * @return string
 */
function getDsn()
{
	return "sqlite:" . getDatabasePath();
}

/**
 *  Get PDO object for database access
 * 
 * @return \PDO
 */
function getPDO()
{
	return new PDO(getDsn());
}

/**
 * Escape HTMl so it is safe for output
 * 
 * @param string $html
 * @return string
 */
function htmlEscape($html)
{
	return htmlspecialchars($html, ENT_HTML5, "UTF-8");
} 

function convertSqlDate($sqlDate)
{
	/* @var $date DateTime */
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);

	return $date->format('d M Y, H:i');
}

/**
 * Return number of comments for the post
 * 
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId)
{
	$pdo = getPDO();

	$sql = "SELECT COUNT(*) FROM comment WHERE post_id = ?";
	$query = $pdo->prepare($sql);
	$query->execute([$postId]);

	return (int) $query->fetchColumn();
}

/**
 * Return comments for the specific post
 * 
 * @param integer $postId
 */
function getCommentsForPost($postId)
{
	$pdo = getPDO();

	$sql = "SELECT * FROM comment WHERE post_id = ?";
	$query = $pdo->prepare($sql);
	$query->execute([$postId]);

	return $query->fetchAll(PDO::FETCH_ASSOC);
}

function redirectAndExit($script)
{
	$relativeUrl = $_SERVER['PHP_SELF'];
	$urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, "/") + 1);

	$host = $_SERVER['HTTP_HOST'];
	$fullUrl = "http://" . $host . $urlFolder . $script;

	header("location: " . $fullUrl);
	exit();
}

/**
 * Convert unsafe text to safe, paragraphed, HTML
 * @param string $text
 * @return string
 */
function convertNewlinesToParagraph($text)
{
	$escaped = htmlEscape($text);

	return "<p>" . str_replace("\n", "</p><p>", $escaped);
}

function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}

/**
 * Check if the username and password are correct or not
 * 
 * @param PDO $pdo
 * @param string $username
 * @param string $password
 */
function tryLogin(PDO $pdo, $username, $password)
{
	$sql = "SELECT
			password 
		FROM
			user
		WHERE
		username = ?
	";

	$query = $pdo->prepare($sql);
	$query->execute([$username]);

	$hash = $query->fetchColumn();
	$success = password_verify($password, $hash);

	return $success;
}

/**
 * Log the user in
 * 
 * @param string $username
 */
function login($username)
{
	session_start();

	$_SESSION['logged_in_username'] = $username;
}

/**
 * Check if the user is logged in or not
 * 
 * @return bool
 */
function isLoggedIn()
{
	return isset($_SESSION['logged_in_username']);
}