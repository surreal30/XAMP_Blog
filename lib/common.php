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
	$date = DateTime::createFromFormat('Y-m-d', $sqlDate);

	return $date->format('d-m-y');
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