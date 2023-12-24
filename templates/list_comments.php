<?php

/**
 * @var $pdo PDO
 * @var $postID Integer
 */
?>
<div class="comment-list">
	<h3><?php echo countCommentsForPost($pdo, $postId); ?> Comments</h3>

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
</div>