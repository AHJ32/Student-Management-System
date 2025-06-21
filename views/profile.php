<h2>My Profile</h2>

<div class="profile-section">
    <div class="profile-card">
        <h3>Current Profile</h3>
        <?php if ($user_profile['profile_image']): ?>
            <img src="<?php echo $user_profile['profile_image']; ?>" alt="Profile" class="profile-image">
        <?php else: ?>
            <div style="width: 100px; height: 100px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">No Image</div>
        <?php endif; ?>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user_profile['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_profile['email']); ?></p>
        <p><strong>Member since:</strong> <?php echo date('M d, Y', strtotime($user_profile['created_at'])); ?></p>
    </div>
    
    <div class="profile-card">
        <h3>Update Profile</h3>
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_profile">
            
            <div class="form-group">
                <label for="profile_username">Username:</label>
                <input type="text" name="username" id="profile_username" value="<?php echo htmlspecialchars($user_profile['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="profile_email">Email:</label>
                <input type="email" name="email" id="profile_email" value="<?php echo htmlspecialchars($user_profile['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</div> 