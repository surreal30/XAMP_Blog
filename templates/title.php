<div style="float: right">
        <?php if(isLoggedIn()): ?>
        <a href="logout.php"> Logout </a>
        <?php else: ?>
                <a href="login.php"> Login </a>
        <?php endif; ?>
</div>
<a href="index.php">
        <h1>Blog title</h1>
</a>
<p>This paragraph summarises what the blog is about.</p>