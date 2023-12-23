<?php

function addPost(PDO $pdo, $title, $body, $userId)
{
	$sql = "
		INSERT INTO
			post
			(title, body, user_id, created_at)
			VALUES
			(?, ?, ?, ?)
	";

	$query = $pdo->prepare($sql);
	if($query === false)
	{
		throw new Exception("Couldn't prepare post statement");
	}

	$result = $query->execute([$title, $body, $userId, getSqlDateForNow()]);
	if($result === false)
	{
		throw new Exception("Couldn't execute the query");
	}

	return $pdo->lastInsertId();
}

function editPost(PDO $pdo, $title, $body, $postId)
{
	$sql = "
		UPDATE
			post
		SET
			title = ?, body = ?
		WHERE
			id = ?
	";

	$query = $pdo->prepare($sql);
	if($query === false)
	{
		throw new Exception("Error occured during preparing the query");
	}

	$result = $query->execute([$title, $body, $postId]);
	if($result === false)
	{
		throw new Exception("Error occured during executing the query");
	}

	return true;
}