<?php
// Ensure the user got here legitimately by checking for the reset email in the session
if (!isset($_SESSION['reset_email'])) {
    header("Location: index.php?action=forgot_password");
    exit;
}
?>

<div class="auth-container">
    <h1>Reset Your Password</h1>
    <p style="text-align: center; margin-bottom: 1rem;">Enter your new password for <?php echo htmlspecialchars($_SESSION['reset_email']); ?>.</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="reset_password">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['reset_email']); ?>">
        
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Reset Password</button>
    </form>
</div> 