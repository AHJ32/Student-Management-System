<?php
$student_model = new Student($db);
$total_students = $student_model->count_all($_SESSION['user_id']);
$total_courses = $student_model->count_courses($_SESSION['user_id']);
$recent_students = $student_model->get_recent_by_user($_SESSION['user_id']);
$institution_type = $user_profile['institution_type'] ?? 'Polytechnic';

if ($institution_type === 'Polytechnic') {
    $total_departments = $student_model->count_departments($_SESSION['user_id']);
    $total_semesters = $student_model->count_semesters($_SESSION['user_id']);
    $departments = $student_model->get_departments_with_counts($_SESSION['user_id']);
}
?>

<div class="dashboard-header">
    <div class="profile-card dashboard-welcome">
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
        <?php if ($user_profile['profile_image']): ?>
            <img src="<?php echo $user_profile['profile_image']; ?>" alt="Profile" class="profile-image">
        <?php else: ?>
            <div style="width: 100px; height: 100px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 2.5rem; color: #aaa;"><i class="fas fa-user"></i></div>
        <?php endif; ?>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p><strong>Member since:</strong> <?php echo date('M d, Y', strtotime($user_profile['created_at'])); ?></p>
    </div>

    <?php if ($institution_type === 'Polytechnic'): ?>
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_students; ?></div>
            <div>Total Students</div>
        </div>
        <div class="stat-card" style="flex:2; min-width:300px;">
            <div style="font-weight:bold; margin-bottom:0.5rem;">Departments & Student Count</div>
            <?php if ($departments): ?>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <?php foreach ($departments as $dept): ?>
                        <div class="stat-card" style="min-width: 120px; flex: 1; background: #f8f8f8; box-shadow:none;">
                            <div class="stat-number" style="color:#333;"><?php echo htmlspecialchars($dept['count']); ?></div>
                            <div style="color:#666; font-size:1rem;"><?php echo htmlspecialchars($dept['dept']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No departments found. <a href="index.php?action=students">Add your first student!</a></p>
            <?php endif; ?>
        </div>
    </div>
    <?php elseif ($institution_type === 'Coaching Center'): ?>
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
    <?php endif; ?>
</div>

<?php if ($institution_type === 'Polytechnic'): ?>
    <div class="recent-students-section">
        <h3>Recent Students</h3>
        <?php if ($recent_students): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Dept.</th>
                        <th>Sem.</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['dept']); ?></td>
                            <td><?php echo htmlspecialchars($student['sem']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students added yet. <a href="index.php?action=students">Add your first student!</a></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="recent-students-section">
        <h3>Recent Students</h3>
        <?php if ($recent_students): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['course']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students added yet. <a href="index.php?action=students">Add your first student!</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>