<?php
$student_model = new Student($db);
$total_students = $student_model->count_all($_SESSION['user_id']);
$total_courses = $student_model->count_courses($_SESSION['user_id']);
$recent_students = $student_model->get_recent_by_user($_SESSION['user_id']);
?>

<div class="profile-section">
    <div class="profile-card">
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
        <?php if ($user_profile['profile_image']): ?>
            <img src="<?php echo $user_profile['profile_image']; ?>" alt="Profile" class="profile-image">
        <?php else: ?>
            <div style="width: 100px; height: 100px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">No Image</div>
        <?php endif; ?>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p><strong>Member since:</strong> <?php echo date('M d, Y', strtotime($user_profile['created_at'])); ?></p>
    </div>
    
    <div>
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_students; ?></div>
                <div>Total Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_courses; ?></div>
                <div>Courses</div>
            </div>
        </div>
        
        <h3>Recent Students</h3>
        <?php if ($recent_students): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <?php if ($user_profile['institution_type'] === 'School'): ?>
                            <th>Class</th>
                        <?php elseif ($user_profile['institution_type'] === 'Polytechnic'): ?>
                            <th>Dept.</th>
                            <th>Sem.</th>
                        <?php else: ?>
                            <th>Course</th>
                        <?php endif; ?>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($student['email'] ?? ''); ?></td>
                            <?php if ($user_profile['institution_type'] === 'School'): ?>
                                <td><?php echo htmlspecialchars($student['class'] ?? ''); ?></td>
                            <?php elseif ($user_profile['institution_type'] === 'Polytechnic'): ?>
                                <td><?php echo htmlspecialchars($student['dept'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($student['sem'] ?? ''); ?></td>
                            <?php else: ?>
                                <td><?php echo htmlspecialchars($student['course'] ?? ''); ?></td>
                            <?php endif; ?>
                            <td><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students added yet. <a href="index.php?action=students">Add your first student!</a></p>
        <?php endif; ?>
    </div>
</div>