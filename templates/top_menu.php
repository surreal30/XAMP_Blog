<div class="top-menu">
        <div class="menu-options">
                <?php if(isLoggedIn()): ?>
                        <a href="edit_post.php"> New Post </a>
                        
                        Hello, <?php echo htmlEscape(getAuthUser());
                ?>
                <a href="logout.php"> Logout </a>
                <?php else: ?>
                        <a href="login.php"> Login </a>
                <?php endif; ?>
        </div>
</div>