<?php

function route() {
 

    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    // Handle register action (untuk setup admin pertama kali)
    if (isset($_POST['action']) && $_POST['action'] === "register") {
        regisadmin($_POST['username'] ?? '', $_POST['password'] ?? '');
        return;
    }

    // Jika belum ada admin, tampilkan halaman registrasi admin
    if (!ceckadmin()) {
        initadmin();
        return;
    }

    // Handle login action
    if (isset($_POST['action']) && $_POST['action'] === "login") {
        loginout($_POST['username'] ?? '', $_POST['password'] ?? '');
        return;
    }

    // Jika user sudah login dan akses dashboard
    if ($url === "/dashboard" && isset($_SESSION['user_id'])) {
        dashboard();
        return;
    }

    // Handle POST action yang membutuhkan autentikasi
    if (
        $method === 'POST' &&
        isset($_POST['action']) &&
        isset($_SESSION['user_id'])
    ) {
        $action = $_POST['action'];
        switch ($action) {
            case 'crypto':
                var_dump('berhasil masuk sini');
                // cryptoadd($_POST['name'] ?? '', $_POST['address'] ?? '', $_POST['icon'] ?? '');
                break;
            case 'certif':
                addcertif($_POST['title'] ?? '', $_POST['imglink'] ?? '', $_POST['source'] ?? '');
                break;
            case 'project':
                project($_POST['title'] ?? '', $_POST['demo'] ?? '', $_POST['repo'] ?? '', $_POST['imglink'] ?? '', $_POST['deskrip'] ?? '');
                break;
            case 'skill':
                addskill($_POST['title'] ?? '', $_POST['icon'] ?? '', $_POST['persen'] ?? '');
                break;
            case 'deleted':
                delete($_POST['table'] ?? '', $_POST['id'] ?? '');
                break;
        }
        return;
    }

    // Routing GET
    switch ($url) {
        case '/':
        case '/index.php':
            homepage();
            break;
        case '/login':
            showadmin();
            break;
        case '/dashboard':
            // Jika belum login, redirect ke login
            if (!isset($_SESSION['user_id'])) {
                showadmin();
            } else {
                dashboard();
            }
            break;
        case '/donate':
            donatepahe();
            break;
        case '/about':
            showabout();
            break;
        case '/api/key':
            require_once __DIR__ . '/api.php';
            break;
        case '/api/github':
            $source = __DIR__;
            $hey = dirname($source, 2);
            require_once $hey . '/curlgithub.php';
            break;
        case '/logout':
            // Log out user
            session_unset();
            session_destroy();
            echo '<script>window.location.href="/login"</script>';
            break;
        default:
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            break;
    }
}

route();
