<?php
function route(){
    $path = $_SERVER['REQUEST_URI'];
    
    if(isset($_POST['username']) && isset($_POST['login'])){
        validate($_POST['username'], $_POST['password']);
        return;
    } else if(isset($_POST['username']) && isset($_POST['register'])){
        if(isAdminsTableEmpty()){
            registeradmin($_POST['username'],$_POST['password']);
            loginform();
            exit;
        } else {
            loginform();
            return;
        }
    }
    
    $get = $_GET;
    if(isAdminsTableEmpty()){
        regis();
    } else if($path == "/index.php" || $path == "/"){
        showhome();
    } else if($path == "/login"){
        loginform();
    } else if($path == "/donate"){
        showdonate();
    } else if($path == "/logout"){
        logout();
    }
    
    // route Login
    if(isset($_SESSION['user_id'])){
        if($path == "/dashboard"){
            showManage();
        } else if($path == "/logout"){
            logout();
        } else if($path == "/add-project"){
            showaddprojectform();
        } else if($get['action'] == 'edit'){
            editingpage($get['id']);
        }
        
        if(isset($_POST['inputproject'])){
            handleProjectSubmission();
            return;
        } else if(isset($_POST['action']) && $_POST['action'] == 'delete'){
            del($_POST['id']);
        } else if(isset($_POST['action']) && $_POST['action'] == 'update'){
            update($_POST['id']);
        } else if(isset($_POST['action']) && $_POST['action'] == "addcry"){
            addcry($_POST['name'],$_POST['address'],$_POST['icon']);
        } else if(isset($_POST['action']) && $_POST['action'] == "delcry"){
            delcry($_POST['id']);
        }else if(isset($_POST['action']) && $_POST['action'] == "addcertif"){
            addcertif($_POST['title'],$_POST['source']);
        }else if(isset($_POST['action']) && $_POST['action'] == "addskill"){
            uploadskil($_POST['percentage'],$_POST['skill'],$_POST['svg_name']);
        }
    }
}
