<div class="auth-container">
    <h1>Register</h1>
    
    <?php 
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="error">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <div><?php echo $error; ?></div>
            <?php endforeach; ?>
        </div>
    <?php 
    unset($_SESSION['errors']);
    endif; 
    ?>
    
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="register">
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo $_SESSION['post_data']['username'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $_SESSION['post_data']['email'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Register</button>
    </form>
    
    <p style="text-align: center; margin-top: 1rem;">
        Already have an account? <a href="index.php?action=login" style="color: #667eea;">Login here</a>
    </p>
</div>
<?php unset($_SESSION['post_data']); ?> 