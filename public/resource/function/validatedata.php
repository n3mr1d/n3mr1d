<?php
// Cek apakah sudah ada admin di tabel users
function ceckadmin() {
    global $sql;
    $query = "SELECT COUNT(*) FROM users";
    $stmt = $sql->prepare($query);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

// Login logic: cek username dan password
function loginout(string $username, string $password) {
    global $sql;
    if (trim($username) === '' || trim($password) === '') {
        $_SESSION['errors'] = "Username dan password tidak boleh kosong";
        header("Location:/login");
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
            unset($_SESSION['errors']);
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = "Password atau username salah";
            header("Location:/login");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = "Terjadi kesalahan, silakan coba lagi";
        header("Location:/login");
        exit();
    }
}

// Tambah data crypto ke database
function cryptoadd($name, $address, $icon) {
    global $sql;
    try {
        $stmt = $sql->prepare("INSERT INTO crypto(name, address, icon) VALUES (:name, :address, :icon)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":icon", $icon);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Berhasil menambah coin ke database";
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = "Gagal menambah coin ke database";
            header("Location:/dashboard");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = "Terjadi error: " . $e->getMessage();
        header("Location:/dashboard");
        exit();
    }
}

// Tambah sertifikat ke database
function addcertif($title, $imglink, $source) {
    global $sql;
    try {
        $query = "INSERT INTO certif(title, imglink, source) VALUES(:title, :imglink, :source)";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":imglink", $imglink);
        $stmt->bindParam(":source", $source);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Berhasil menambah sertifikat: $title ke database";
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = "Gagal menambah sertifikat ke database";
            header("Location:/dashboard");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Gagal menambah sertifikat ke database: " . $e->getMessage();
        header("Location:/dashboard");
        exit();
    }
}

// Tambah project dan tag ke database
function project(string $title, string $demo, string $repo, string $imglink, string $deskrip) {
    global $sql;
    try {
        $query = "INSERT INTO pro (title, repo, demo, imglink, deskrip) VALUES (:title, :repo, :demo, :imglink, :deskrip)";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":repo", $repo);
        $stmt->bindParam(":demo", $demo);
        $stmt->bindParam(":imglink", $imglink);
        $stmt->bindParam(":deskrip", $deskrip);

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

            $_SESSION['success'] = 'Berhasil menambah project ke database: ' . $title;
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = 'Gagal menambah project ke database';
            header("Location:/dashboard");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = 'Database error: ' . $e->getMessage();
        header("Location:/dashboard");
        exit();
    }
}

// Tambah skill ke database
function addskill($name, $icon, $persen) {
    global $sql;
    try {
        $stmt = $sql->prepare("INSERT INTO skill(title, persentase, icon) VALUES(?, ?, ?)");
        if ($stmt->execute([$name, $persen, $icon])) {
            $_SESSION['success'] = "Berhasil menambah skill $name ke database";
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = "Gagal menambah skill";
            header("Location:/dashboard");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Gagal menambah skill: " . $e->getMessage();
        header("Location:/dashboard");
        exit();
    }
}

// Hapus data dari tabel tertentu berdasarkan id
function deletedtable($table, $id) {
    global $sql;
    try {
        // Validasi nama tabel agar tidak bisa di-inject
        $allowedTables = ['crypto', 'certif', 'pro', 'framework', 'data', 'language', 'skill', 'users'];
        if (!in_array($table, $allowedTables)) {
            $_SESSION['errors'] = "Tabel tidak valid";
            header("Location:/dashboard");
            exit();
        }
        $stmt = $sql->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Berhasil menghapus data id $id";
            header("Location:/dashboard");
            exit();
        } else {
            $_SESSION['errors'] = "Gagal menghapus data id $id";
            header("Location:/dashboard");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Error: " . $e->getMessage();
        header("Location:/dashboard");
        exit();
    }
}

// Registrasi admin baru
function regisadmin($username, $password) {
    global $sql;
    if (trim($username) === '' || trim($password) === '') {
        $_SESSION['errors'] = "Username dan password tidak boleh kosong";
        header("Location:/");
        exit();
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users(username, password) VALUES(?, ?)";
    $stmt = $sql->prepare($query);
    if ($stmt->execute([$username, $hash])) {
        header("Location:/");
        exit();
    } else {
        $_SESSION['errors'] = "Register gagal";
        header("Location:/");
        exit();
    }
}