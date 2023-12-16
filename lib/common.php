<?php

// Get the root path of the project
function getRootPath() : string
{
	return realpath(__DIR__ . '/..');
}

// Get the full path of database file
function getDatabasePath() : string
{
	return getRootPath() . "/data/data.sqlite";
}

// Get the DSN for the SQLite connection
function getDsn() : string
{
	return "sqlite:" . getDatabasePath();
}

// Get PDO object for database access
function getPDO() : \PDO
{
	return new PDO(getDsn());
}