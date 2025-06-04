<?php
// menampilkan login form
function loginform(){
  print_start('login','login');  
  if(!isset($_SESSION['user_id'])){
    echo<<<HTML
    <div class="kontainer-login">
      <div class="form-kontainer">
    HTML;
    shownotification();
    echo<<<HTML
        <h3 class="login-admin">Login Admin</h3>
        <form action="" method="POST">
          <input type="hidden" name="login">
          <div class="form-group">
            <label for="username">Username:</label> 
            <input type="text" name="username" id="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
          </div>
          <button type="submit" class="btn-login">Login</button>
        </form>
      </div>
    </div>
    HTML;
    endhtml();
  } else {
    showManage();
  }
}
// validate login passwordd
function validate($username, $password) {
    global $db, $error;

    try {
        $cekuser = "SELECT * FROM admins WHERE username = :user";
        $stmt = $db->prepare($cekuser);
        $stmt->bindParam(':user', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['success'] = "Berhasil masuk!";
            $_SESSION['user_id'] = $user['id'];
            showManage();
          } else {
            $_SESSION['error'] = "Username atau password salah!";
            loginform();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();

    }
}

// regitser 
function regis(){
    print_start('register','login');
    echo<<<HTML
      <div class="kontainer-regiter">
        <div class="kontainer-reg">
        <h3 class="regitser-admin">regitser Admin</h3>
          <form action="" method="POST">
            <div class="form-group">
            <input type="hidden" name="register">
            <label for="username">Username:</label> 
            </div>
            <div class="form-group">
              <input type="text" name="username" id="username">
            <label  for="password">Password:</label>
            <input type="password" name="password"  id="password">
              </div>
              <button type="submit" class="btn-login" > register </button>
          </form>
      
         </div>
        </div>
    HTML;
    endhtml();
}
// form register apabila admin gak ada sama sekali
function isAdminsTableEmpty() {
    global $db;
    try {
        $query = "SELECT COUNT(*) as total FROM admins";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] == 0;

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false; 
    }
}
// function untuk menambahkan admin apabila database kkosong
function registeradmin($username,$password){
    global $db;
    // insert to dattabase

    $user = strtolower($username);
    $passwordhash= password_hash($password,PASSWORD_DEFAULT);
    try{
    $register = "INSERT INTO admins(username,password) values(:user,:pass)";
    $stmt =$db->prepare($register);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':pass',$passwordhash);
    if($stmt->execute()){
      $_SESSION['error'] = "Kamu Berhasil melakukan register";
      showhome();
    }
    }catch(Exception $e){
        echo'Error: ' . $e->getMessage();
    }
}
// fungsi untuk menambahkan sebuah proyek baru
function showaddprojectform() {

    echo<<<HTML
      <div class="kontainer-form">
        <div class="form-header">
            <h2>Add New Project</h2>
            <p>Fill in the details below to add a new project to your portfolio</p>
        </div>
HTML;
    echo<<<HTML
        <div class="kontainer-text">
            <form action="" method="POST" enctype="multipart/form-data" id="projectForm">
                <input type="hidden" name="inputproject">
                <div class="form-group">
                    <label for="title">Title Project <span class="required">*</span></label>
                    <input type="text" id="title" name="title" required placeholder="Enter project title">
                </div>
                
                <div class="form-group">
                    <label for="deskrip">Description <span class="required">*</span></label>
                    <textarea id="deskrip" name="deskrip" rows="5" required placeholder="Explain about your project here"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group half">
                        <label for="github">Github Repository <span class="required">*</span></label>
                        <input type="text" id="github" name="github" required placeholder="https://github.com/username/repo">
                    </div>
                    
                    <div class="form-group half">
                        <label for="demo">Demo Link</label>
                        <input type="text" id="demo" name="demo" placeholder="https://your-demo-link.com">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="progres">Project Status</label>
                    <select name="statuspo" id="progres">
                        <option value="ongoing">Ongoing</option>
                        <option value="complated">Completed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="project_tags">Project Tags</label>
                    <div class="tags-container">
                        <div class="tag-category">
                            <label>Languages</label>
                            <input type="text" id="language_tags" name="language_tags" placeholder="PHP, JavaScript, Python..." class="tag-input blue-tag">
                        </div>
                        <div class="tag-category">
                            <label>Frameworks</label>
                            <input type="text" id="framework_tags" name="framework_tags" placeholder="Laravel, React, Vue..." class="tag-input yellow-tag">
                        </div>
                        <div class="tag-category">
                            <label>Databases</label>
                            <input type="text" id="database_tags" name="database_tags" placeholder="MySQL, MongoDB, PostgreSQL..." class="tag-input red-tag">
                        </div>
                    </div>
                    <div class="tags-preview" id="tagsPreview"></div>
                </div>
                
                <div class="form-group">
                    <label for="project_images">Project Images <span class="required">*</span></label>
                    <div class="file-upload-container">
                        <input type="file" id="project_images" name="imgup" accept="image/*" required>
                        <div class="upload-button">
                            <i class="fas fa-cloud-upload-alt"></i> Choose Files
                        </div>
                    </div>
                    <div class="image-preview" id="imagePreview"></div>
                </div>
                
                <div class="form-actions">
                    <button type="reset" class="btn-secondary">Reset Form</button>
                    <button type="submit" name="submit_project" class="btn-primary">Submit Project</button>
                </div>
            </form>
        </div>
     </div>
HTML;
    jsallow('showproject');
    endhtml();
}
// Function to handle project submission
function handleProjectSubmission() {
    global $db;
    
    try {
        // Start transaction
        $db->beginTransaction();
        
        // Validate required fields
        if (empty($_POST['title']) || empty($_POST['deskrip'])) {
            throw new Exception("Title dan deskripsi harus diisi");
        }
        
        // Insert project data
        $stmt = $db->prepare("INSERT INTO project (title, deskrip, github, demo, statuspo) VALUES (:title, :deskrip, :github, :demo, :statuspo)");
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':deskrip', $_POST['deskrip']);
        $stmt->bindParam(':github', $_POST['github']);
        $stmt->bindParam(':demo', $_POST['demo']);
        $stmt->bindParam(':statuspo', $_POST['statuspo']);
        $stmt->execute();
        
        $projectId = $db->lastInsertId();
        
        // Prepare tag statement once
        $tagStmt = $db->prepare("INSERT INTO tag (tag, color, project_id) VALUES (:tag, :color, :project_id)");
        
        // Process language tags
        if (!empty($_POST['language_tags'])) {
            $tags = is_array($_POST['language_tags']) ? $_POST['language_tags'] : [$_POST['language_tags']];
            foreach ($tags as $tag) {
                if (!empty(trim($tag))) {
                    $tagStmt->execute([
                        ':tag' => trim($tag),
                        ':color' => '#3498db',
                        ':project_id' => $projectId
                    ]);
                }
            }
        }
        
        // Process framework tags
        if (!empty($_POST['framework_tags'])) {
            $tags = is_array($_POST['framework_tags']) ? $_POST['framework_tags'] : [$_POST['framework_tags']];
            foreach ($tags as $tag) {
                if (!empty(trim($tag))) {
                    $tagStmt->execute([
                        ':tag' => trim($tag),
                        ':color' => '#f39c12',
                        ':project_id' => $projectId
                    ]);
                }
            }
        }
        
        // Process database tags
        if (!empty($_POST['database_tags'])) {
            $tags = is_array($_POST['database_tags']) ? $_POST['database_tags'] : [$_POST['database_tags']];
            foreach ($tags as $tag) {
                if (!empty(trim($tag))) {
                    $tagStmt->execute([
                        ':tag' => trim($tag),
                        ':color' => '#e74c3c',
                        ':project_id' => $projectId
                    ]);
                }
            }
        }
        
        // Process uploaded images
        if (isset($_FILES['imgup']) && $_FILES['imgup']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/';
            
            // Create uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['imgup']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Tipe file tidak diizinkan. Hanya JPG, PNG, GIF, dan WebP yang diperbolehkan.");
            }
            
            // Validate file size (max 5MB)
            if ($_FILES['imgup']['size'] > 5 * 1024 * 1024) {
                throw new Exception("Ukuran file terlalu besar. Maksimal 5MB.");
            }
            
            $fileExtension = pathinfo($_FILES['imgup']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . uniqid() . '.' . $fileExtension;
            $targetFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imgup']['tmp_name'], $targetFile)) {
                $relativePath = '/uploads/' . $fileName;
                $imageStmt = $db->prepare("INSERT INTO image (project_id, path_image) VALUES (:project_id, :path_image)");
                $imageStmt->execute([
                    ':project_id' => $projectId,
                    ':path_image' => $relativePath
                ]);
            } else {
                throw new Exception("Gagal mengupload file gambar");
            }
        }
        
        // Commit transaction
        $db->commit();
        
        // Set success message
        $_SESSION['success'] = "Berhasil menambahkan project ke dalam database";
        
        // Redirect using JavaScript (Vercel compatible)
        echo "<script>
            window.location.href = '/';
        </script>";
        exit;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        // Set error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
        
        // Redirect back with error message (Vercel compatible)
        echo "<script>
            sessionStorage.setItem('message', 'Error: " . addslashes($e->getMessage()) . "');
            sessionStorage.setItem('messageType', 'error');
            window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? '/') . "';
        </script>";
        exit;
    }
}
// function untukk melakkuan editing data pada project feature
function editingpage($id){
  global $db;

  // Ambil data project
  $sql = "SELECT * FROM project WHERE id = :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_OBJ); 

  if (!$data) {
    echo "Data tidak ditemukan.";
    return;
  }

  // Ambil tag yang terkait
  $tagSql = "SELECT tag FROM tag WHERE project_id = :id";
  $tagStmt = $db->prepare($tagSql);
  $tagStmt->bindParam(':id', $id, PDO::PARAM_INT);
  $tagStmt->execute();
  $tagRows = $tagStmt->fetchAll(PDO::FETCH_OBJ);

  // Gabungkan semua tag jadi satu string
  $tags = array_map(function($row) {
    return $row->tag;
  }, $tagRows);
  $tagsString = htmlspecialchars(implode(", ", $tags)); 

  print_start("editing", "editing");
$selectedDraft = $data->statuspo === 'complated' ? 'selected' : '';
$selectedPublished = $data->statuspo === 'ongoing' ? 'selected' : '';

  echo <<<HTML
  <div class="kontainer-form">
    <h2 class="title-form">Edit Project</h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="{$data->id}">
        <input type="hidden" name="action" value="update">

    <div class="groupform">
        <label>Judul</label>
        <input type="text" name="title" value="{$data->title}" required>
      </div>

      <div class="groupform">
        <label>Deskripsi</label>
        <textarea name="deskrip" required>{$data->deskrip}</textarea>
      </div>

      <div class="groupform">
        <label>GitHub Link</label>
        <input type="url" name="github" value="{$data->github}">
      </div>

      <div class="groupform">
        <label>Demo Link</label>
        <input type="url" name="demo" value="{$data->demo}">
      </div>

      <div class="groupform">
        <label>Status</label>
        <select name="statuspo">
          <option value="complated" $selectedPublished>complated</option>
          <option value="ongoing" $selectedDraft>ongoing</option>
        </select>
      </div>

      <div class="groupform">
        <label for="tag">Tags (pisahkan dengan koma)</label>
        <input type="text" name="tag" value="{$tagsString}">
      </div>

      <div class="groupform">
        <button type="submit">Update</button>
      </div>
    </form>
  </div>
  HTML;
}

//function update project 
function update($id){
  global $db;
  $post = $_POST;
  $title = $post['title'];
  $deskrip= $post['deskrip'];
  $github = $post['github'];
  $demo = $post['demo'];
  $statuspo = $post['statuspo'];
  $tag = $post['tag'];
  $resault = array_map('trim',explode(',',$tag));


try{
$db->beginTransaction();
    //hapus dulu forign key nya
    $tagchange = "DELETE FROM tag WHERE project_id = :id";
    $stmt2 = $db->prepare($tagchange);
    $stmt2->bindParam(':id',$id);
    $stmt2->execute();
    $tagadd = "INSERT INTO tag(project_id, tag) value(:pro_id, :tag)";
    $stmttag = $db->prepare($tagadd);
    foreach($resault as $tag){
      $stmttag->bindParam(':pro_id',$id);
      $stmttag->bindParam(':tag',$tag);
      $stmttag->execute();
    }
  $data = "UPDATE project SET title = :title, deskrip = :deskrip, github = :github, demo = :demo, statuspo = :statuspo WHERE id = :id";
  $stmt = $db->prepare($data);
  $stmt->bindParam(':title', $title);
  $stmt->bindParam(':deskrip', $deskrip);
  $stmt->bindParam(':github', $github);
  $stmt->bindParam(':demo', $demo);
  $stmt->bindParam(':statuspo', $statuspo);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $db->commit();
  $_SESSION['error'] = "Data Berhasil di update"; 
  // Redirect using JavaScript instead of header
  echo "<script>window.location.href = '/';</script>";
  }catch(Exception $e){
    $db->rollBack();
    echo "gagal memperbarui data dengan error " . $e->getMessage();
  }
}
// function untukk menghapus table
function del(int $id){
  global $db;
  try {
    $db->beginTransaction();

    // Hapus tag terkait project
    $deltag = "DELETE FROM tag WHERE project_id = :id";
    $stmtTag = $db->prepare($deltag);
    $stmtTag->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtTag->execute();

    // Hapus image terkait project
    $delimg = "DELETE FROM image WHERE project_id = :id";
    $stmtImg = $db->prepare($delimg);
    $stmtImg->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtImg->execute();

    // Hapus project
    $deldata = "DELETE FROM project WHERE id = :id";
    $stmtProject = $db->prepare($deldata);
    $stmtProject->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtProject->execute();

    $db->commit();
    $_SESSION['error'] = "Berhasil Menghapus data $id";
    // Redirect using JavaScript instead of header
    echo "<script>window.location.href = '/';</script>";

  } catch(PDOException $e) {
    $db->rollBack();
    echo "gagal menghapus ada kesalah PDOException: " . $e->getMessage();
  }
}
// function form untuk menambahkan crypto coin
function showsettings() {
  echo <<<HTML
  <section>
    <div class="kontainer-form">
      <h1 class="title-crypto">Add Crypto Currency</h1>
      <form action="" method="POST">
        <input type="hidden" name="action" value="addcry">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
          <label for="icon">Icon URL:</label>
          <input type="text" id="icon" name="icon" required>
        </div>
        <div class="form-group">
          <button type="submit" class="submit-btn">Add Currency</button>
        </div>
      </form>
    </div>
  </section>
  HTML;
}
function uploadskil(int $percentage, string $name, string $namesvg) {
    global $db;

    // Initialize response
    $result = [
        'success' => false,
        'message' => '',
        'errors' => []
    ];

    // Input validation
    if ($percentage < 0 || $percentage > 100) {
        $result['errors'][] = "Percentage must be between 0 and 100.";
    }
    if (empty($name) || strlen($name) > 255) {
        $result['errors'][] = "Skill name is required and must be less than 255 characters.";
    }
    if (empty($namesvg) || strlen($namesvg) > 255) {
        $result['errors'][] = "SVG name is required and must be less than 255 characters.";
    }
    if (!isset($_FILES['svg_file']) || $_FILES['svg_file']['error'] !== UPLOAD_ERR_OK) {
        $result['errors'][] = "SVG file upload failed.";
    } else {
        $fileInfo = $_FILES['svg_file'];
        $fileType = mime_content_type($fileInfo['tmp_name']);
        if ($fileType !== 'image/svg+xml' && $fileType !== 'text/plain' && $fileType !== 'application/octet-stream') {
            $result['errors'][] = "Uploaded file is not a valid SVG.";
        }
        if ($fileInfo['size'] > 1024 * 1024) { // 1MB limit
            $result['errors'][] = "SVG file size exceeds 1MB.";
        }
    }


    // Handle SVG file upload and content extraction
    $svgContent = file_get_contents($_FILES['svg_file']['tmp_name']);
    $uploadDir = __DIR__ . '/uploads/';
    

    $safeSvgName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $namesvg);
    $fileName = time() . '_' . $safeSvgName . '.svg';
    $filePath = $uploadDir . $fileName;
    var_dump($filePath);
    // Save SVG file to disk
    if (file_put_contents($filePath, $svgContent) === false) {
        $result['message'] = "Failed to save SVG file to disk.";
        return $result;
    }

    // Insert into database
    try {
        $db->beginTransaction();
        $sql = "INSERT INTO skill(svg_name, skill, svg_content, percentage) VALUES(:svgname, :name, :svgcontent, :percentage)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':svgname', $namesvg);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':svgcontent', $svgContent);
        $stmt->bindParam(':percentage', $percentage);
        $stmt->execute();
        $db->commit();


        $result['success'] = true;
        $result['message'] = "Skill uploaded successfully.";
    } catch (Exception $e) {
        $db->rollBack();
        $result['message'] = "Fatal Error: " . $e->getMessage();
    }

    return $result;
}
// function untuk menghapus crypto coin
function delcry($id){
  global $db;
  try {
    $db->beginTransaction();
    $del = "DELETE FROM cry WHERE id = :id";
    $stmt = $db->prepare($del);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $db->commit();
    $_SESSION['error'] = "Berhasil Menghapus data $id";
    // Redirect using JavaScript instead of header
    echo "<script>window.location.href = '/dashboard';</script>";
  } catch(Exception $e){
    $db->rollBack();
    echo "gagal menghapus ada kesalah PDOException: " . $e->getMessage();
  }
}
function showformcertf(){
  echo '
  <div class="kontainer-form">
    <h1>Add Certificate</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="addcertif">
      <div class="formGroup">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="source">Source:</label>
        <input type="url" id="source" name="source" required>
        <br>
        <label for="upload">Upload Image:</label>
        <input type="file" id="upload" name="upload" accept="image/*" required>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>';
}
function rolesform(): void{
echo<<<HTML
<div class="kkontainer-form">
  <div class=form-group>
    <input type="hidden" id="action" value="addroles">
    <label for="roles">roles</label>
    <input id="roles" type="text">
  </div>
  <button type="submit">submit</button>
</div> 
HTML;
} 