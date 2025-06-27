<?php
// function ceck admin
function ceckadmin(){
    global $sql;
    $querry  = "SELECT * FROM users";
    $stmt = $sql->prepare($querry);
    $stmt->execute();
    $resualt = $stmt->fetchAll();
    if($resualt==null){
        return false;
    }else{
        return true;
    }
}

// logic login check database
function loginout(string $username, string $password)
{
    global $sql;


    // Validasi input
    if (trim($username) === '' || trim($password) === '') {
        $_SESSION['errors'] = "Username dan password tidak boleh kosong";
        echo '<script>window.location.href="/login"</script>';
        exit();
    }

    try {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['password']) && password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['username'];
            // Optional: unset error jika sebelumnya ada
            unset($_SESSION['errors']);
            echo '<script>window.location.href="/dashboard"</script>';
            exit();
        } else {
            $_SESSION['errors'] = "Password atau username salah";
            echo '<script>window.location.href="/login"</script>';
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = "Terjadi kesalahan, silakan coba lagi";
        echo '<script>window.location.href="/login"</script>';
        exit();
    }
}

// logic input add crypto tto database

function  cryptoadd($name,$address,$icon){
    global $sql ;
    try{
        $stmt = $sql->prepare("INSERT INTO crypto(name,address,icon) VALUE (:name, :add, :icon)");
        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":add",$address);
        $stmt->bindParam(":icon",$icon);
        if($stmt->execute()){
            $_SESSION['success']="success add coin to database";
            echo'<script>window.location.href="/dashboard"</script>';
exit();
        }else{
            $_SESSION['error'] = "ERROR add coin to databases";
            echo'<script>window.location.href="/dashboard"</script>';

            exit();
        }

    }catch(Exception $e){
        echo "error message" . $e->getMessage();
       ;
                    exit();


    }
}

//logic input certification

function addcertif($title, $imglink, $source) {
    global $sql;
try{
    $query = "INSERT INTO certif(title,imglink,source) VALUES(:title, :imglink, :source)";
    $stmt = $sql->prepare($query);
    $stmt->bindParam(":title",$title);
    $stmt->bindParam(":imglink",$imglink);
    $stmt->bindParam(":source",$source);
   if($stmt->execute()){
    $_SESSION['success']="success add certif title : $title to database ";
    echo'<script>window.location.href="/dashboard"</script>';

    exit();

   }else{
    $_SESSION['errors']="Failed add certif to database";
    echo'<script>window.location.href="/dashboard"</script>';

    exit();
   }
}catch(PDOException $e){
      $_SESSION['errors']="Failed add certif to database $e";
      echo'<script>window.location.href="/dashboard"</script>';

    exit();
}

}


// logic project and tag

function project(string $title, string $demo, string $repo, string $imglink,string $deskrip)
{
    global $sql;

    try {
        // Insert project
        $query = "INSERT INTO pro (title, repo, demo, imglink,deskrip) VALUES (:title, :repo, :demo, :imglink,:deskrip)";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":repo", $repo);
        $stmt->bindParam(":demo", $demo);
        $stmt->bindParam(":deskrip",$deskrip);
        $stmt->bindParam(":imglink", $imglink);

        if ($stmt->execute()) {
            $project_id = $sql->lastInsertId();

            // Tag insert logic
            if (isset($_POST['tag']) && is_array($_POST['tag'])) {
                $tags = $_POST['tag'];

                foreach ($tags as $key => $value) {
                    $raw = is_array($value) ? ($value[0] ?? '') : $value;

                    if (empty($raw)) continue;

                    $items = explode(',', $raw);

                    // Tentukan tabel tujuan
                    if ($key === "framework") {
                        $table = "framework";
                    } elseif ($key === "database") {
                        $table = "data";
                    } elseif ($key === "language") {
                        $table = "language";
                    } else {
                        continue;
                    }

                    $stmtTag = $sql->prepare("INSERT INTO $table (name, project_id) VALUES (?, ?)");

                    foreach ($items as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            $stmtTag->execute([$item, $project_id]);
                        }
                    }
                }
            }

            $_SESSION['success'] = 'Success Add project to database title: ' . $title;
            echo'<script>window.location.href="/dashboard"</script>';

        } else {
            $_SESSION['errors'] = 'Failed to add project to database';
            echo'<script>window.location.href="/dashboard"</script>';

        }

    } catch (PDOException $e) {
        $_SESSION['errors'] = 'Database error: ' . $e->getMessage();
        echo'<script>window.location.href="/dashboard"</script>';

    }
}
// function add skil into database 
function addskill($name,$icon,$persen){
    global $sql;
try{
    $stmt = $sql->prepare("INSERT INTO skill(title,persentase,icon) VALUES(?, ?, ? )");
   if($stmt->execute([$name,$persen,$icon])){
    $_SESSION['success']= "success add skill $name to database";
    echo'<script>window.location.href="/dashboard"</script>';
    }else{
        $_SESSION['errors'] = "failed";
        echo'<script>window.location.href="/dashboard"</script>';

    }
   }catch(PDOException $e){
    $_SESSION['errors'] = "failed $e";
    echo'<script>window.location.href="/dashboard"</script>';

    
    }
}

// functiion deleted 
function delete($table,$id){
    global $sql;
try{
$stmt = $sql->prepare("DELETE  FROM $table where id = :id");
$stmt->bindParam(":id",$id);
if($stmt->execute()){
$_SESSION['success']= "deleted $id success";
echo'<script>window.location.href="/dashboard"</script>';

}else{
   $_SESSION['errors']= "deleted $id failed";
   echo'<script>window.location.href="/dashboard"</script>';


}
}catch(PDOException $e){
   $_SESSION['errors']= "error : $e ";
   echo'<script>window.location.href="/dashboard"</script>';

}
}
function regisadmin($username,$password){
    global $sql;
    $resault = password_hash($password,PASSWORD_DEFAULT);
    $query = "INSERT INTO users(username,password) VALUES(?,?)";
    $stmt= $sql->prepare($query);
    if($stmt->execute([$username,$resault])){
        echo'<script>window.location.href = "/"</script>';
    }else{
        $_SESSION['errors']= "Register failed";
        echo'<script>window.location.href="/dashboard"</script>';

    }
    
}