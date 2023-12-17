<?php

/**
 * Fetch a single post
 * 
 * @param PDO $pdo
 * @param integer $postI
 * @throws Exception
 */
function getPostRow(PDO $pdo, $postId)
{
	$pdo = getPDO();

	$sql = "SELECT 
	  title, 
	  created_at, 
	  body 
	FROM 
	  post 
	WHERE 
	  id = ?
	";

	$query = $pdo->prepare($sql);
	if($query === false)
	{
		throw new Exception("Error while preparing the query");
	}

	$result = $query->execute([$postId]);
	if($result === false)
	{
		throw new Exception("Error while executing the query");
	}

	$row = $query->fetch(PDO::FETCH_ASSOC);

	return $row;
}