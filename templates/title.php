<div class="top-menu">
        <div class="menu-options">
                <?php if(isLoggedIn()): ?>
                        Hello, <?php echo htmlEscape(getAuthUser()); ?>
                <a href="logout.php"> Logout </a>
                <?php else: ?>
                        <a href="login.php"> Login </a>
                <?php endif; ?>
        </div>
</div>
<a href="index.php">
        <h1>Blog title</h1>
</a>
<p>This paragraph summarises what the blog is about.</p>