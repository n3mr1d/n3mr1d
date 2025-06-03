322f<?php 


// validatte php 
//
function addcry($name,$addre,$icon=""){
global $db;
  try {
  $sqladd ="INSERT INTO cry(name,addre,icon) VALUES(:name, :addre, :icon)";
  $stmt = $db->prepare($sqladd);
  $stmt->bindParam(':name',$name);
  $stmt->bindParam(':addre', $addre);
  $stmt->bindParam(':icon',$icon);
  $stmt->execute();
  }catch(Exception $e){
    echo"Fatal error : " . $e->getMessage();
  }
}
function fetchskill(){
  global $db;
  $sql = "SELECT * FROM skill";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
function fetchsertif(){
  global $db;
  $sql = "SELECT * FROM certification";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
function addroles(string $value):void{

  global $db;
  try{
      $db->beginTransaction();
  $sql = "INSERT INTO roles(role) VALUES(:role)";
  $stmt= $db->prepare($sql);
  $stmt->bindParam(":rile",$value);
  $stmt->execute();
                  $db->commit();
    $_SESSION['error'] = "upload berhasil";
      echo "<script>window.location.href = '/dashboard';</script>";
}catch(PDOException $e){
  $db->rollBack();
  $_SESSION['error'] = "error upload $e";
}
}
function addcertif($title, $source) {
    global $db;

        $tmpName = $_FILES['upload']['tmp_name'];
        $originalName = basename($_FILES['upload']['name']);
        $uploadDir = __DIR__ . '/uploads/';
 
        $uniqueName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);
        $targetPath = $uploadDir . $uniqueName;
        $relativePath = 'uploads/' . $uniqueName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            try {
                $db->beginTransaction();
                $sqladd = "INSERT INTO certification(title, path_image, source) VALUES(:title, :path_img, :source)";
                $stmt = $db->prepare($sqladd);
                $stmt->bindParam(":title", $title);
                $stmt->bindParam(":source", $source);
                $stmt->bindParam(":path_img", $relativePath);
                $stmt->execute();
                $db->commit();
                $_SESSION['error'] = "Berhasil menambahkan sertifikat";
            } catch (Exception $e) {
                $db->rollBack();
                echo "Fatal error: " . $e->getMessage();
            }
        } else {
            echo "Gagal mengupload file gambar.";
        }
    
}
