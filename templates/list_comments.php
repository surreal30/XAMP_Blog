<?php

/**
 * @var $pdo PDO
 * @var $postID Integer
 * @var $commentCount integer
 */
?>
<form action="view_post.php?action=delete-comment&amp;post_id=<?php echo $postId?>&amp;" method="post" class="comment-list">
	<h3><?php echo $commentCount ?> comments</h3>

	<?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
		<div class="comment">
			<div class="comment-meta">
				Comment from
				<?php echo htmlEscape($comment['name']); ?>
				on
				<?php echo convertSqlDate($comment['created_at']); ?>
				<?php if(isLoggedIn()): ?>
					<input type="submit" name="delete-comment[<?php echo $comment['id']; ?>]" value="delete">
				<?php endif; ?>
			</div>
			<div class="comment-body">
				<?php echo convertNewlinesToParagraph($comment['text']); ?>
			</div>
		</div>
	<?php endforeach; ?>
</form>