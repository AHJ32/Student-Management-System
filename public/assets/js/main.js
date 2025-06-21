// Modal functionality
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Edit student function
function editStudent(student) {
    document.getElementById('edit_id').value = student.id;
    document.getElementById('edit_name').value = student.name;
    document.getElementById('edit_email').value = student.email;
    document.getElementById('edit_phone').value = student.phone;
    document.getElementById('edit_course').value = student.course;
    document.getElementById('edit_current_image').value = student.image || '';
    
    openModal('editModal');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const action = form.querySelector('input[name="action"]')?.value;
            
            if (action === 'register') {
                const password = form.querySelector('input[name="password"]').value;
                const confirmPassword = form.querySelector('input[name="confirm_password"]').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }
                
                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long!');
                    return false;
                }
            }
            
            if (action === 'add_student' || action === 'update_student') {
                const name = form.querySelector('input[name="name"]').value.trim();
                const email = form.querySelector('input[name="email"]').value.trim();
                const phone = form.querySelector('input[name="phone"]').value.trim();
                const course = form.querySelector('input[name="course"]').value.trim();
                
                if (!name || !email || !phone || !course) {
                    e.preventDefault();
                    alert('Please fill in all required fields!');
                    return false;
                }
                
                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address!');
                    return false;
                }
                
                // Basic phone validation
                const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
                if (!phoneRegex.test(phone)) {
                    e.preventDefault();
                    alert('Please enter a valid phone number!');
                    return false;
                }
            }
        });
    });
    
    // File upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (5MB limit)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB!');
                    e.target.value = '';
                    return;
                }
                
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Only JPG, JPEG, PNG, and GIF files are allowed!');
                    e.target.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(event) {
                    // You can add image preview functionality here if needed
                };
                reader.readAsDataURL(file);
            }
        });
    });
});

// Auto-hide success/error messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.success, .error');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

// Search functionality for students table
function addSearchFunction() {
    const table = document.querySelector('.table');
    if (table && table.querySelector('thead')) {
        const searchContainer = document.createElement('div');
        searchContainer.innerHTML = `
            <div style="margin-bottom: 1rem;">
                <input type="text" id="searchInput" placeholder="Search students..." style="width: 300px; padding: 0.5rem; border: 2px solid #ddd; border-radius: 8px;">
            </div>
        `;
        table.parentNode.insertBefore(searchContainer, table);
        
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
}

// Add search functionality when on students page
if (window.location.search.includes('action=students')) {
    document.addEventListener('DOMContentLoaded', addSearchFunction);
}

// Responsive navigation
function toggleMobileNav() {
    const nav = document.querySelector('.nav-links');
    if (nav) {
        nav.style.display = nav.style.display === 'none' ? 'flex' : 'none';
    }
}

// Add mobile menu button for small screens
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
        const nav = document.querySelector('.nav');
        if (nav) {
            const mobileBtn = document.createElement('button');
            mobileBtn.innerHTML = '☰';
            mobileBtn.style.cssText = 'background: none; border: none; font-size: 1.5rem; cursor: pointer;';
            mobileBtn.onclick = toggleMobileNav;
            nav.appendChild(mobileBtn);
        }
    }
}); 