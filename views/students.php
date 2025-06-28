<?php
$student_model = new Student($db);
$students = $student_model->get_all_by_user($_SESSION['user_id']);
$institution_type = $user_profile['institution_type'] ?? 'School';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Manage Students</h2>
    <button onclick="openModal('addModal')" class="btn">Add New Student</button>
</div>

<?php if ($students): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <?php if ($institution_type === 'School'): ?>
                    <th>Class</th>
                <?php elseif ($institution_type === 'Polytechnic'): ?>
                    <th>Dept.</th>
                    <th>Sem.</th>
                <?php else: ?>
                    <th>Course</th>
                <?php endif; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td>
                        <?php if ($student['image']): ?>
                            <img src="<?php echo $student['image']; ?>" alt="Student" class="student-image">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #aaa;"><i class='fas fa-user'></i></div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><?php echo htmlspecialchars($student['phone']); ?></td>
                    <?php if ($institution_type === 'School'): ?>
                        <td><?php echo htmlspecialchars($student['class']); ?></td>
                    <?php elseif ($institution_type === 'Polytechnic'): ?>
                        <td><?php echo htmlspecialchars($student['dept']); ?></td>
                        <td><?php echo htmlspecialchars($student['sem']); ?></td>
                    <?php else: ?>
                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                    <?php endif; ?>
                    <td>
                        <button onclick='editStudent(<?php echo json_encode([
                            "id" => $student["id"],
                            "name" => $student["name"],
                            "email" => $student["email"],
                            "phone" => $student["phone"],
                            "course" => $student["course"] ?? "",
                            "dept" => $student["dept"] ?? "",
                            "sem" => $student["sem"] ?? "",
                            "class" => $student["class"] ?? "",
                            "image" => $student["image"] ?? ""
                        ]); ?>)' class="btn btn-secondary" style="margin-right: 0.5rem;">Edit</button>
                        <a href="index.php?action=students&delete_student=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No students found. Add your first student using the button above.</p>
<?php endif; ?>

<!-- Add Student Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <h2>Add New Student</h2>
        <form method="POST" action="index.php" enctype="multipart/form-data" id="addStudentForm">
            <input type="hidden" name="action" value="add_student">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" required>
            </div>

            <?php if ($institution_type === 'School'): ?>
                <div class="form-group" id="class-group">
                    <label for="class">Class:</label>
                    <input type="text" name="class" id="class" required>
                </div>
            <?php elseif ($institution_type === 'Polytechnic'): ?>
                <div class="form-group" id="dept-group">
                    <label for="dept">Dept.:</label>
                    <select name="dept" id="dept" required>
                        <option value="Civil">Civil</option>
                        <option value="Computer">Computer</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Mechanical">Mechanical</option>
                    </select>
                </div>
                <div class="form-group" id="sem-group">
                    <label for="sem">Sem:</label>
                    <select name="sem" id="sem" required>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                        <option value="6th">6th</option>
                        <option value="7th">7th</option>
                        <option value="8th">8th</option>
                    </select>
                </div>
            <?php else: ?>
                <div class="form-group" id="course-group">
                    <label for="course">Course:</label>
                    <input type="text" name="course" id="course" required>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Add Student</button>
        </form>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Edit Student</h2>
        <form method="POST" action="index.php" enctype="multipart/form-data" id="editStudentForm">
            <input type="hidden" name="action" value="update_student">
            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="current_image" id="edit_current_image">
            
            <div class="form-group">
                <label for="edit_name">Name:</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            
            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" name="email" id="edit_email" required>
            </div>
            
            <div class="form-group">
                <label for="edit_phone">Phone:</label>
                <input type="tel" name="phone" id="edit_phone" required>
            </div>

            <?php if ($institution_type === 'School'): ?>
                <div class="form-group" id="edit_class-group">
                    <label for="edit_class">Class:</label>
                    <input type="text" name="class" id="edit_class" required>
                </div>
            <?php elseif ($institution_type === 'Polytechnic'): ?>
                <div class="form-group" id="edit_dept-group">
                    <label for="edit_dept">Dept.:</label>
                    <select name="dept" id="edit_dept" required>
                        <option value="Civil">Civil</option>
                        <option value="Computer">Computer</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Mechanical">Mechanical</option>
                    </select>
                </div>
                <div class="form-group" id="edit_sem-group">
                    <label for="edit_sem">Sem:</label>
                    <select name="sem" id="edit_sem" required>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                        <option value="6th">6th</option>
                        <option value="7th">7th</option>
                        <option value="8th">8th</option>
                    </select>
                </div>
            <?php else: ?>
                <div class="form-group" id="edit_course-group">
                    <label for="edit_course">Course:</label>
                    <input type="text" name="course" id="edit_course" required>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="edit_image">New Image (optional):</label>
                <input type="file" name="image" id="edit_image" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Update Student</button>
        </form>
    </div>
</div> 