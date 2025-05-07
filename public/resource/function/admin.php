<?php
try {
    $data = "CREATE TABLE IF NOT EXISTS projects(
    id int AUTO_INCREMENT PRIMARY KEY,
    cover_path VARCHAR(255),
    title VARCHAR(255) UNIQUE,
    deskrip LONGTEXT,
    uploadby VARCHAR(255),
    catagory ENUM('framework','backend','frontend','other') DEFAULT 'other',
    link VARCHAR(255),
    sample VARCHAR(255),
    createat TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $admin = "CREATE TABLE IF NOT EXISTS admin(
    id int AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE,
    password VARCHAR(255))";
    $sql->exec($data);
    $sql->exec($admin);
} catch(PDOException $e) {
    echo '<div class="error-message">Database error: '. $e->getMessage() . '</div>';
}

// Function to display project upload form
function showform() {
    global $sql, $error;
    
    if(empty($_SESSION['user_id'])) {
        loginform();
        return;
    }
    
    if(isset($_POST['logout'])) {
        session_destroy();
        session_unset();
        header('Location: /admin');
        exit();
    } elseif(isset($_POST['upload'])) {
        // Handle file upload
        if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
            $upload_dir = '../../../upload/';
            
            // Create directory if it doesn't exist
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($_FILES['cover']['name']);
            $target_path = $upload_dir . $file_name;
            
            if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_path)) {
                // File uploaded successfully, now save to database
                $title = htmlspecialchars($_POST['title']);
                $deskrip = htmlspecialchars($_POST['deskrip']);
                $uploadby = htmlspecialchars($_POST['uploadby']);
                $category = $_POST['category'];
                $link = htmlspecialchars($_POST['link']);
                $view = htmlspecialchars($_POST['view']);
                
                try {
                    $in = "INSERT INTO projects(cover_path, title, deskrip, uploadby, catagory, link, sample) 
                           VALUES(:cover, :title, :deskrip, :uploadby, :catagory, :link, :view)";
                    $stmt = $sql->prepare($in);
                    $stmt->bindParam(':cover', $target_path);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':deskrip', $deskrip);
                    $stmt->bindParam(':uploadby', $uploadby);
                    $stmt->bindParam(':catagory', $category);
                    $stmt->bindParam(':link', $link);
                    $stmt->bindParam(':view', $view);
                    $stmt->execute();
                    
                    $error = '<div class="success-message">Project uploaded successfully!</div>';
                } catch(PDOException $e) {
                    $error = '<div class="error-message">Database error: ' . $e->getMessage() . '</div>';
                }
            } else {
                $error = '<div class="error-message">Error uploading file!</div>';
            }
        } else {
            $error = '<div class="error-message">Please select a valid image file!</div>';
        }
    }
    
    start('upload', 'upload');

    echo '<div class="admin-container">
        <h2>Admin Panel - Upload Project</h2>';
        
    if(isset($error)) {
        echo $error;
    }
        
    echo '<form action="" method="post" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label for="cover">Project Cover Image:</label>
                <input type="file" name="cover" id="cover" accept="image/*" required>
                <small>Recommended size: 1200x630px</small>
            </div>
            
            <div class="form-group">
                <label for="title">Project Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter project title" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="framework">Framework</option>
                    <option value="backend">Backend</option>
                    <option value="frontend">Frontend</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="hidden" name="uploadby" id="uploadby" value="n3mr1d">
                <label for="deskrip">Project Description:</label>
                <textarea name="deskrip" id="deskrip" rows="6" placeholder="Enter detailed project description" required></textarea>
            </div>
            <div class="form-group">
                <label for="link">GitHub Link: (https://...)</label>
                <input type="url" name="link" id="link" placeholder="Enter GitHub repository URL">
                <label for="view">View Link: (https://...)</label>
                <input type="url" name="view" id="view" placeholder="Enter view URL">
            </div>
            <div class="form-actions">
                <button type="submit" name="upload" class="upload">Upload Project</button>
            </div>
        </form>
        <div class="form-actions">
        <form action="" method="post">        
            <button type="submit" name="logout" class="logout">Logout</button>
        </form>
        </div>
    </div>';
}

function loginform() {
    global $sql, $error;
    
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $countQuery = "SELECT COUNT(*) as total FROM admin";
    $countStmt = $sql->prepare($countQuery);
    $countStmt->execute();
    $totalAdmins = $countStmt->fetch(PDO::FETCH_ASSOC);
    
    if($totalAdmins['total'] == 0) {
        setupadmin();
        return;
    }
    
    if(isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        
        if(empty($username) || empty($password)) {
            $error = "Please enter both username and password";
        } else {
            $stmt = $sql->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                
                header('Location: /admin');
                exit();
            } else {
                $error = "Invalid username or password";
            }
        }
    }
    
    if(isset($_SESSION['user_id'])) {
        showform();  
    } else {
        start('login', 'login');
        echo '<div class="kontainerform">
            <div class="login-kontainer">
                <span class="title">Login Admin</span>
                <div class="inputform">';
                
        if(isset($error)) {
            echo '<div class="warn">'. $error . '</div>';
        }
        
        echo '<form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username: </label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-actions">
                    <input type="submit" name="login" value="Login" class="btn-submit"> 
                </div>
            </form>
            </div>
        </div>
        </div>';
        echo '</body></html>';
    }
}

function setupadmin() {
    global $sql, $error;
    
    start('admin', 'admin');
    
    echo '<div class="admin-setup-container">
        <h2>Initial Admin Setup</h2>';
        
    if(isset($error)) {
        echo '<div class="warn">'. $error . '</div>';
    }
    
    echo '<form action="" method="POST" class="admin-form">
        <div class="form-group">
            <label for="adminuser">Username: </label>
            <input type="text" name="adminuser" id="adminuser" required>
        </div>
        <div class="form-group">
            <label for="adminpasss">Password: </label> 
            <input type="password" name="adminpasss" id="adminpasss" required>
        </div>
        <div class="form-group">
            <label for="confirmpass">Confirm Password: </label> 
            <input type="password" name="confirmpass" id="confirmpass" required>
        </div>
        <div class="form-actions">
            <input type="submit" name="adminreg" value="Register" class="btn-submit">
        </div>
    </form>
    </div>';
    
    if(isset($_POST['adminreg'])) {
        $username = trim($_POST['adminuser']);
        $password = $_POST['adminpasss'];
        $confirmpass = $_POST['confirmpass'];
        
        if(empty($username) || empty($password)) {
            $error = "Please fill in all fields";
        } elseif($password !== $confirmpass) {
            $error = "Passwords do not match";
        } else {
            $decrypt = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $sql->prepare("INSERT INTO admin (username, password) VALUES(:user, :pass)");
                $stmt->bindParam(':user', $username);
                $stmt->bindParam(':pass', $decrypt);
                if($stmt->execute()) {
                    header('Location: /admin');
                    exit();
                }
            } catch(PDOException $e) {
                $error = 'Database error: '. $e->getMessage();
            }
        }
    }
}