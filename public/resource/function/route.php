<?php

function route() {
    // Pastikan session sudah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    // Jika belum ada admin, tampilkan halaman registrasi admin
    if (!ceckadmin()) {
        // Jika POST register, proses registrasi
        if ($method === 'POST' && isset($_POST['action']) && $_POST['action'] === "register") {
            regisadmin($_POST['username'] ?? '', $_POST['password'] ?? '');
            return;
        }
        // Tampilkan form registrasi admin
        initadmin();
        return;
    }

    // Handle login action
    if ($method === 'POST' && isset($_POST['action']) && $_POST['action'] === "login") {
        loginout($_POST['username'] ?? '', $_POST['password'] ?? '');
        return;
    }

    // Handle form actions (CRUD) hanya jika sudah login
    if ($method === 'POST' && isset($_POST['action']) && isset($_SESSION['user_id'])) {
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
            deletedtable($_POST['table'] ?? '', $_POST['id'] ?? '');
        }
        return;
    }

    // Routing GET
    if ($url === '/' || $url === '/index.php') {
        homepage();
    } else if ($url === '/login') {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit();
        }
        showadmin();
    } else if ($url === '/dashboard') {
        // Jika belum login, redirect ke login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        dashboard();
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
        header("Location: /login");
        exit();
    } else {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
    }
}
