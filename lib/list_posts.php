<?php

/**
 * Tries to delete the specified post
 * 
 * first we delete the attached comments and then deleye the post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @return boolean Return true on successful deletion
 * @throws Exception
 */
function deletePost(PDO $pdo, $postId)
{
	$sqls = [
		// delete the comment dirst
		"
		DELETE FROM
			comment
		WHERE
			post_id = ?
		",

		// Delete the post now
		"
		DELETE FROM
			post
		WHERE
			id = ?
		"
	];

	foreach($sqls as $sql)
	{
			$query = $pdo->prepare($sql);
		if($query === false)
		{
			throw new Exception("There was a problem preparing the query");
		}

		$result = $query->execute([$postId]);

		if($result === false)
		{
			break;
		}
	}




	return $result !== false;
}