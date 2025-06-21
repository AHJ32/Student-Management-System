<div class="profile-section">
    <div class="profile-card">
        
        <form method="POST" enctype="multipart/form-data" style="margin-top: 1rem;">
            <input type="hidden" name="action" value="update_profile">

            <!-- Profile Image Display -->
            <div class="profile-image-container">
                <?php if ($user_profile['profile_image']): ?>
                    <img src="<?php echo $user_profile['profile_image']; ?>" alt="Profile" class="profile-image">
                <?php else: ?>
                    <div style="width: 120px; height: 120px; background: #eee; border-radius: 50%; display: inline-block; line-height: 120px; text-align: center;">No Image</div>
                <?php endif; ?>
                <div class="profile-image-overlay">
                    <span><i class="fas fa-camera"></i></span>
                </div>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" class="hidden-file-input">
            </div>
        
            <!-- Update Profile Form -->
            
            <div class="form-group">
                <label for="profile_username">Username:</label>
                <input type="text" name="username" id="profile_username" value="<?php echo htmlspecialchars($user_profile['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="profile_email">Email:</label>
                <input type="email" name="email" id="profile_email" value="<?php echo htmlspecialchars($user_profile['email']); ?>" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%;">Update Profile</button>
        </form>
    </div>
</div> 