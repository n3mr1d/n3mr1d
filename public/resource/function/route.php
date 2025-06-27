<?php

function route() {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    // Handle register action (untuk setup admin pertama kali)
    if (isset($_POST['action']) && $_POST['action'] === "register") {
        regisadmin($_POST['username'] ?? '', $_POST['password'] ?? '');
        return;
    } else if (!ceckadmin()) {
        // Jika belum ada admin, tampilkan halaman registrasi admin
        initadmin();
        return;
    } else if (isset($_POST['action']) && $_POST['action'] === "login") {
        // Handle login action
        loginout($_POST['username'] ?? '', $_POST['password'] ?? '');
        return;
    } else if ($url === "/dashboard" && isset($_SESSION['user_id'])) {
        // Jika user sudah login dan akses dashboard
        dashboard();
        return;
    } else if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'crypto') {
            cryptoadd($_POST['name'] ?? '', $_POST['address'] ?? '', $_POST['icon'] ?? '');
        } else if ($action === 'certif') {
            addcertif($_POST['title'] ?? '', $_POST['imglink'] ?? '', $_POST['source'] ?? '');
        } else if ($action === 'project') {
            project($_POST['title'] ?? '', $_POST['demo'] ?? '', $_POST['repo'] ?? '', $_POST['imglink'] ?? '', $_POST['deskrip'] ?? '');
        } else if ($action === 'skill') {
            addskill($_POST['title'] ?? '', $_POST['icon'] ?? '', $_POST['persen'] ?? '');
        } else if ($action === 'deleted') {
            delete($_POST['table'] ?? '', $_POST['id'] ?? '');
        }
        return;
    } else {
        // Routing GET
        if ($url === '/' || $url === '/index.php') {
            homepage();
        } else if ($url === '/login') {
            showadmin();
        } else if ($url === '/dashboard') {
            // Jika belum login, redirect ke login
            if (!isset($_SESSION['user_id'])) {
                showadmin();
            } else {
                dashboard();
            }
        } else if ($url === '/donate') {
            donatepahe();
        } else if ($url === '/about') {
            showabout();
        } else if ($url === '/api/key') {
            require_once __DIR__ . '/api.php';
        } else if ($url === '/api/github') {
            $source = __DIR__;
            $hey = dirname($source, 2);
            require_once $hey . '/curlgithub.php';
        } else if ($url === '/logout') {
            // Log out user
            session_unset();
            session_destroy();
            echo '<script>window.location.href="/login"</script>';
        } else {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
        }
    }
}


