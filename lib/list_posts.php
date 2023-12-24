<?php

/**
 * Tries to delete the specified post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @return boolean Return true on successful deletion
 * @throws Exception
 */
function deletePost(PDO $pdo, $postId)
{
	$sql = "
		DELETE FROM
			post
		WHERE
			id = ?
	";

	$query = $pdo->prepare($sql);
	if($query === false)
	{
		throw new Exception("There was a problem preparing the query");
	}

	$result = $query->execute([$postId]);

	return $result !== false;
}