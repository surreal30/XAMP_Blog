<?php
/**
 * @var $errors string
 * @var $commentData array
 */
?>

<?php if($errors): ?>
	<div class="error box comment-margin">
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<h3>Add your comments</h3>

<form action="view_post.php?action=add-comment&amp;post_id=<?php echo $postId?>" method="post" class="comment-form user-form">
	<div>
		<label for="comment-name">
			Name:
		</label>
		<input type="text" name="comment-name" id="comment-name" value="<?php echo htmlEscape($commentData['name']); ?>">
	</div>
	<div>
		<label for="comment-website">
			Website:
		</label>
		<input type="text" name="comment-website" id="comment-website" value="<?php echo htmlEscape($commentData['website']); ?>">
	</div>
	<div>
		<label for="comment-text">
			Comment:
		</label>
		<textarea type="text" name="comment-text" id="comment-text" rows="8" cols="70" value="<?php echo htmlEscape($commentData['text']); ?>"></textarea>
	</div>
	<div>
		<input type="submit" value="Submit comment" />
	</div>
</form>