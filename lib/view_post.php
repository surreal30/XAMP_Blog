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

/**
 * Write a comment to a particular post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 * 
 * @return array
 */
function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
	$errors = [];

	if(empty($commentData['name']))
	{
		$errors['name'] = "A name is required";
	}

	if(empty($commentData['text']))
	{
		$errors['text'] = "A comment is required";
	}

	if(!$errors)
	{
		$sql = "
			INSERT INTO
				comment
				(
					name,
					website,
					text,
					post_id,
					created_at
				)
				VALUES
				(?, ?, ?, ?, ?)";
				
		$query = $pdo->prepare($sql);

		if($query === false)
		{
			throw new Exception('Cannot prepare statement to insert comment');
		}

		$result = $query->execute([$commentData['name'], $commentData['website'], $commentData['text'], $postId, getSqlDateForNow()]);


		if($result === false)
		{
			// @todo this renders a database-level message to the useer, fix this
			$errorInfo = $query->errorInfo();

			if($errorInfo)
			{
				$errors = $errorInfo[2];
			}
		}
	}

	return $errors;
}