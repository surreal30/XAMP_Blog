<?php


/**
 * Called to handle the comment form, redirects upon success
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 */
function handleAddComment(PDO $pdo, $postId, $commentData)
{
	$errors = addCommentToPost($pdo, $postId, $commentData);

	// If not error then redirect back to self and redisplay
	if(!$errors)
	{
		redirectAndExit('view_post.php?post_id=' . $postId);
	}

	return $errors;
}

/**
 * Called to handle delete comment form redirect afterwards
 * 
 * The $deleteResponsearray is expected to be in form:
 * 		[[6] => delete]
 * which comes directly from the input elements of this form:
 * 		name = "delete-comment[6"
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $deleteResponse
 */
function handleDeleteComment(PDO $pdo, $postId, array $deleteResponse)
{
	if(isLoggedIn())
	{
		$deleteResponse = $_POST['delete-comment'];
        $keys = array_keys($deleteResponse);
        $deleteCommentId = $keys[0];
        if($deleteCommentId)
        {
        	deleteComment($pdo, $postId, $deleteCommentId);
        }

        redirectAndExit("view_post.php?post_id=" . $postId);
	}
}

/**
 * Delete the specified comment on specific post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param integer $commentId
 * 
 * @return boolean True if the command executed without errors
 * @throws Exception
 */
function deleteComment(PDO $pdo, $postId, $commentId)
{
	// commentId is enough but $postId is extra safety chunk
	$sql = "
		DELETE FROM
			comment
		WHERE
			post_id = ? AND id = ?
	";

	$query = $pdo->prepare($sql);
	if($query === false)
	{
		throw new Exception("There was a problem in preparing the query");
	}

	$result = $query->execute([$postId, $commentId]);

	return $result !== false;
}

/**
 * Fetch a single post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @throws Exception
 */
function getPostRow(PDO $pdo, $postId)
{
	$pdo = getPDO();

	$sql = "SELECT 
	  title, 
	  created_at, 
	  body,
	  (SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id) comment_count
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