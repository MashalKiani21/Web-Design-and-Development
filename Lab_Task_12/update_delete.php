<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ---------------------- DELETE STUDENT ----------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id") or die($conn->error);
    header("Location: update_delete.php");
    exit();
}

// ---------------------- EDIT STUDENT ----------------------
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id") or die($conn->error);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_id = $row['id'];
        $edit_name = $row['name'];
        $edit_email = $row['email'];
        $edit_age = $row['age'];
        $edit_course = $row['course'];
        $edit_year = $row['year'];
    }
}

// ---------------------- UPDATE STUDENT ----------------------
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $age = $conn->real_escape_string($_POST['age']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);

    $sql = "UPDATE students SET name='$name', email='$email', age='$age', course='$course', year='$year' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: update_delete.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Get total students count
$total_students_result = $conn->query("SELECT COUNT(*) as total FROM students");
$total_students = $total_students_result->fetch_assoc()['total'];

// Get active students count
$active_students_result = $conn->query("SELECT COUNT(*) as active FROM students WHERE status='Active'");
$active_students = $active_students_result->fetch_assoc()['active'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Update & Delete</title>
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
            grid-template-columns: 1fr 2fr;
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
        
        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .student-table th, .student-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .student-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #4b6cb7;
        }
        
        .student-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .btn-edit {
            background-color: #3498db;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #2980b9;
        }
        
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c0392b;
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
            
            .student-table {
                display: block;
                overflow-x: auto;
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
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="#" class="active">Manage Students</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Grades</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <section class="dashboard">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Students</h3>
                <p id="total-students"><?php echo $total_students; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-user-graduate"></i>
                <h3>Active Students</h3>
                <p id="active-students"><?php echo $active_students; ?></p>
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
                    <i class="fas fa-user-edit"></i>
                    <h2 id="form-title"><?php echo isset($edit_id) ? 'Edit Student' : 'Update Student'; ?></h2>
                </div>
                
                <form id="student-form" method="POST" action="update_delete.php">
                    <input type="hidden" id="student-id" name="id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
                    
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" name="name" value="<?php echo isset($edit_name) ? $edit_name : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($edit_email) ? $edit_email : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" min="16" max="50" value="<?php echo isset($edit_age) ? $edit_age : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="course">Course</label>
                        <select id="course" name="course" required>
                            <option value="">Select a course</option>
                            <option value="Computer Science" <?php echo (isset($edit_course) && $edit_course == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Business Administration" <?php echo (isset($edit_course) && $edit_course == 'Business Administration') ? 'selected' : ''; ?>>Business Administration</option>
                            <option value="Engineering" <?php echo (isset($edit_course) && $edit_course == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                            <option value="Psychology" <?php echo (isset($edit_course) && $edit_course == 'Psychology') ? 'selected' : ''; ?>>Psychology</option>
                            <option value="Medicine" <?php echo (isset($edit_course) && $edit_course == 'Medicine') ? 'selected' : ''; ?>>Medicine</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Year Level</label>
                        <select id="year" name="year" required>
                            <option value="">Select year</option>
                            <option value="1st Year" <?php echo (isset($edit_year) && $edit_year == '1st Year') ? 'selected' : ''; ?>>1st Year</option>
                            <option value="2nd Year" <?php echo (isset($edit_year) && $edit_year == '2nd Year') ? 'selected' : ''; ?>>2nd Year</option>
                            <option value="3rd Year" <?php echo (isset($edit_year) && $edit_year == '3rd Year') ? 'selected' : ''; ?>>3rd Year</option>
                            <option value="4th Year" <?php echo (isset($edit_year) && $edit_year == '4th Year') ? 'selected' : ''; ?>>4th Year</option>
                        </select>
                    </div>
                    
                    <button type="submit" name="update" id="submit-btn"><?php echo isset($edit_id) ? 'Update Student' : 'Update Student'; ?></button>
                </form>
            </div>
            
            <div class="list-section">
                <div class="section-title">
                    <i class="fas fa-list"></i>
                    <h2>Student List</h2>
                </div>
                
                <div class="student-list">
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="student-table-body">
                            <?php
                            $result = $conn->query("SELECT * FROM students") or die($conn->error);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['age']}</td>
                                        <td>{$row['course']}</td>
                                        <td>{$row['year']}</td>
                                        <td>
                                            <div class='action-buttons'>
                                                <a class='btn-edit' href='update_delete.php?edit={$row['id']}'>Edit</a>
                                                <a class='btn-delete' href='update_delete.php?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                            </div>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr>
                                    <td colspan='7' class='empty-state'>
                                        <i class='fas fa-user-graduate'></i>
                                        <p>No students added yet.</p>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    
    <footer>
        <p>Student Management System &copy; 2023 | Part 2: Update & Delete Operations</p>
    </footer>

    <script>
        // JavaScript for smooth scrolling and form reset after update
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to form when editing
            <?php if (isset($edit_id)): ?>
                document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
            <?php endif; ?>
            
            // Reset form after successful update
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('edit')) {
                // Form is already populated by PHP
            } else {
                // Reset form if not in edit mode
                document.getElementById('student-form').reset();
            }
        });
    </script>
</body>
</html>