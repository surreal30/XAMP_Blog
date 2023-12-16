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