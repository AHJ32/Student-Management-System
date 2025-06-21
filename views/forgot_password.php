<div class="auth-container">
    <h1>Forgot Password</h1>
    <p style="text-align: center; margin-bottom: 1rem;">Enter your email address and we'll help you reset your password.</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="forgot_password">
        
        <div class="form-group">
            <label for="email">Your Email Address:</label>
            <input type="email" name="email" id="email" required>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Find Account</button>
    </form>
    
    <p style="text-align: center; margin-top: 1rem;">
        Remember your password? <a href="index.php?action=login" style="color: #667eea;">Login here</a>
    </p>
</div> 