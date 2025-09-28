<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #4b6cb7, #182848);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 10px 10px;
            margin-bottom: 30px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 2rem;
        }
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        nav a:hover, nav a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #4b6cb7;
        }
        
        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .card p {
            color: #666;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .form-section, .list-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .section-title i {
            color: #4b6cb7;
            font-size: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        button {
            background: #4b6cb7;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #3a5999;
        }
        
        .student-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .student-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background 0.3s;
        }
        
        .student-item:hover {
            background: #f9f9f9;
        }
        
        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #4b6cb7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .student-info h4 {
            margin-bottom: 5px;
        }
        
        .student-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #888;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ddd;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #666;
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <h1>Student Management System</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Dashboard</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Grades</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <section class="dashboard">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Students</h3>
                <p id="total-students">0</p>
            </div>
            <div class="card">
                <i class="fas fa-user-graduate"></i>
                <h3>Active Students</h3>
                <p id="active-students">0</p>
            </div>
            <div class="card">
                <i class="fas fa-book"></i>
                <h3>Courses</h3>
                <p>12</p>
            </div>
            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h3>Average Grade</h3>
                <p>85.2%</p>
            </div>
        </section>
        
        <section class="main-content">
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user-plus"></i>
                    <h2>Add New Student</h2>
                </div>
                
                <form id="student-form">
                    <div class="form-group">
                        <label for="student-id">Student ID</label>
                        <input type="text" id="student-id" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="course">Course</label>
                        <select id="course" required>
                            <option value="">Select a course</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Business Administration">Business Administration</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Psychology">Psychology</option>
                            <option value="Medicine">Medicine</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Year Level</label>
                        <select id="year" required>
                            <option value="">Select year</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                    
                    <button type="submit">Add Student</button>
                </form>
            </div>
            
            <div class="list-section">
                <div class="section-title">
                    <i class="fas fa-list"></i>
                    <h2>Student List</h2>
                </div>
                
                <div class="student-list" id="student-list">
                    <div class="empty-state">
                        <i class="fas fa-user-graduate"></i>
                        <p>No students added yet. Add your first student!</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer>
        <p>Student Management System &copy; 2023 | Part 1: Create & Read Operations</p>
    </footer>

    <script>
        // Student data storage (in a real app, this would be a database)
        let students = JSON.parse(localStorage.getItem('students')) || [];
        
        // DOM elements
        const studentForm = document.getElementById('student-form');
        const studentList = document.getElementById('student-list');
        const totalStudentsEl = document.getElementById('total-students');
        const activeStudentsEl = document.getElementById('active-students');
        
        // Initialize the dashboard
        updateDashboard();
        
        // Form submission handler
        studentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const studentId = document.getElementById('student-id').value;
            const fullName = document.getElementById('full-name').value;
            const email = document.getElementById('email').value;
            const course = document.getElementById('course').value;
            const year = document.getElementById('year').value;
            
            // Create new student object
            const newStudent = {
                id: studentId,
                name: fullName,
                email: email,
                course: course,
                year: year,
                status: 'Active'
            };
            
            // Add to students array
            students.push(newStudent);
            
            // Save to localStorage
            localStorage.setItem('students', JSON.stringify(students));
            
            // Update UI
            renderStudentList();
            updateDashboard();
            
            // Reset form
            studentForm.reset();
            
            // Show success message (in a real app, you might use a toast notification)
            alert('Student added successfully!');
        });
        
        // Render student list
        function renderStudentList() {
            if (students.length === 0) {
                studentList.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-user-graduate"></i>
                        <p>No students added yet. Add your first student!</p>
                    </div>
                `;
                return;
            }
            
            studentList.innerHTML = '';
            
            students.forEach(student => {
                const studentItem = document.createElement('div');
                studentItem.className = 'student-item';
                
                // Get initials for avatar
                const initials = student.name.split(' ').map(n => n[0]).join('').toUpperCase();
                
                studentItem.innerHTML = `
                    <div class="student-avatar">${initials}</div>
                    <div class="student-info">
                        <h4>${student.name}</h4>
                        <p>${student.course} • ${student.year} • ${student.id}</p>
                        <p>${student.email}</p>
                    </div>
                `;
                
                studentList.appendChild(studentItem);
            });
        }
        
        // Update dashboard statistics
        function updateDashboard() {
            totalStudentsEl.textContent = students.length;
            activeStudentsEl.textContent = students.filter(s => s.status === 'Active').length;
            
            // Render student list if needed
            if (students.length > 0) {
                renderStudentList();
            }
        }
        
        // Initial render
        renderStudentList();
    </script>
</body>
</html>