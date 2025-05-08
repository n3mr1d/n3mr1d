<?php
try {
    global $sql;
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

// Ensure session is started
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['logout'])) {
    // Proper session cleanup
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    echo '<script>window.location.href = "/admin";</script>';
    exit;
} 

// Function to display project upload form
function showform() {
    global $sql, $error;
    
    if(empty($_SESSION['user_id'])) {
        loginform();
        return;
    }
    
    start('upload', 'upload');

    echo '<div class="admin-container">
        <h2>Admin Panel - Upload Project</h2>';
        
    if(isset($error) && !empty($error)) {
        echo '<div class="error-message">' . $error . '</div>';
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
    // show project deleted or not 
    showproj();
    // Complete the HTML document
    echo '</body></html>';
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
                
                // Use JavaScript for redirection instead of header()
                echo '<script>window.location.href = "/admin";</script>';
                exit;
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
                
        if(isset($error) && !empty($error)) {
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
        
    if(isset($error) && !empty($error)) {
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
                    // Use JavaScript for redirection instead of header()
                    echo '<script>window.location.href = "/admin";</script>';
                    exit;
                }
            } catch(PDOException $e) {
                $error = 'Database error: '. $e->getMessage();
            }
        }
    }
    
    // Complete the HTML document
    echo '</body></html>';
}