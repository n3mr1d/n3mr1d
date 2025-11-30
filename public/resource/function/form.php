<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Show form login page
function showadmin()
{

    print_start("login");

    if (isset($_SESSION['errors'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . 
             $_SESSION['errors'] . 
             '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
        unset($_SESSION['errors']); 
    }

    echo <<<HTML
    <div class="container-fluid  min-vh-100 d-flex align-items-center justify-content-center" data-bs-theme="dark">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-6 col-sm-8">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock me-2"></i>Admin Login
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="login">
                            
                            <!-- Username Field -->
                            <div class="mb-3">
                                <label for="username" class="form-label text-light fw-semibold">
                                    <i class="bi bi-person me-1"></i>Username
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Enter your username"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid username.
                                </div>
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label text-light fw-semibold">
                                    <i class="bi bi-key me-1"></i>Password
                                </label>
                                <input type="password" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
    print_end();
}

// show register admin apabila sudah kosong 
function initadmin(){
    

    print_start("register");

    if (isset($_SESSION['errors'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . 
             $_SESSION['errors'] . 
             '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
        unset($_SESSION['errors']); 
    }

    echo <<<HTML
    <div class="container-fluid  min-vh-100 d-flex align-items-center justify-content-center" data-bs-theme="dark">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-6 col-sm-8">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock me-2"></i>Admin Login
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="register">
                            
                            <!-- Username Field -->
                            <div class="mb-3">
                                <label for="username" class="form-label text-light fw-semibold">
                                    <i class="bi bi-person me-1"></i>Username
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Enter your username"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid username.
                                </div>
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label text-light fw-semibold">
                                    <i class="bi bi-key me-1"></i>Password
                                </label>
                                <input type="password" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
    print_end();

}

// Show form to add crypto coin
function showcrypto()
{
  

    echo <<<HTML
    <div class="container-fluid bg-dark min-vh-100 py-5" data-bs-theme="dark">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-currency-bitcoin me-2"></i>Add Crypto Coin
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="crypto">
                            
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label text-light fw-semibold">
                                    <i class="bi bi-coin me-1"></i>Coin Name
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="name" 
                                       name="name" 
                                       placeholder="e.g., Bitcoin, Ethereum"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid coin name.
                                </div>
                            </div>
                            
                            <!-- Address Field -->
                            <div class="mb-3">
                                <label for="address" class="form-label text-light fw-semibold">
                                    <i class="bi bi-wallet2 me-1"></i>Wallet Address
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="address" 
                                       name="address" 
                                       placeholder="Enter wallet address"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid wallet address.
                                </div>
                            </div>
                            
                            <!-- Icon Field -->
                            <div class="mb-3">
                                <label for="icon" class="form-label text-light fw-semibold">
                                    <i class="bi bi-image me-1"></i>Icon font-awesome
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="icon" 
                                       name="icon" 
                                       placeholder="fa-icon">
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg text-dark">
                                    <i class="bi bi-plus-circle me-2"></i>Add Crypto Coin
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
}


// Show form certification
function showcertif()
{

    echo <<<HTML
    <div class="container-fluid bg-dark min-vh-100 py-5" data-bs-theme="dark">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-award me-2"></i>Add Certification
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="certif">
                            
                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label text-light fw-semibold">
                                    <i class="bi bi-card-text me-1"></i>Certification Title
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="title" 
                                       name="title" 
                                       placeholder="Enter certification title"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid certification title.
                                </div>
                            </div>
                            
                            <!-- Source Field -->
                            <div class="mb-3">
                                <label for="source" class="form-label text-light fw-semibold">
                                    <i class="bi bi-link-45deg me-1"></i>Source URL
                                </label>
                                <input type="url" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="source" 
                                       name="source" 
                                       placeholder="https://example.com/certification"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid source URL.
                                </div>
                            </div>
                            
                            <!-- Image Link Field -->
                            <div class="mb-3">
                                <label for="imglink" class="form-label text-light fw-semibold">
                                    <i class="bi bi-image me-1"></i>Certificate Image URL (Optional)
                                </label>
                                <input type="url" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="imglink" 
                                       name="imglink" 
                                       placeholder="https://example.com/certificate.jpg">
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add Certification
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
}

// Show form to add project (already updated)
function showproform()
{

    echo <<<HTML
    <div class="container-fluid bg-dark min-vh-100 py-5" data-bs-theme="dark">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Add New Project
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="project">
                            
                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label text-light fw-semibold">
                                    <i class="bi bi-card-text me-1"></i>Project Title
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="title" 
                                       name="title" 
                                       placeholder="Enter project title"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid project title.
                                </div>
                            </div>
                            
                            <!-- Repository Field -->
                            <div class="mb-3">
                                <label for="repo" class="form-label text-light fw-semibold">
                                    <i class="bi bi-github me-1"></i>Repository URL
                                </label>
                                <input type="url" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="repo" 
                                       name="repo" 
                                       placeholder="https://github.com/username/repo"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid repository URL.
                                </div>
                            </div>
                            
                            <!-- Image Link Field -->
                            <div class="mb-3">
                                <label for="imglink" class="form-label text-light fw-semibold">
                                    <i class="bi bi-image me-1"></i>Image URL (Optional)
                                </label>
                                <input type="url" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="imglink" 
                                       name="imglink" 
                                       placeholder="https://example.com/image.jpg">
                            </div>
                             <div class="mb-3">
                                <label for="deskrip" class="form-label text-light fw-semibold">
                                    <i class="bi bi-image me-1"></i>Deskrip:
                                </label>
                                <textarea
                                       class="form-control bg-dark text-light border-secondary" 
                                       name="deskrip" ></textarea>
                            </div>
                            <!-- Demo Link Field -->
                            <div class="mb-3">
                                <label for="demo" class="form-label text-light fw-semibold">
                                    <i class="bi bi-play-circle me-1"></i>Demo URL (Optional)
                                </label>
                                <input type="url" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="demo" 
                                       name="demo" 
                                       placeholder="https://example.com/demo">
                            </div>
                            
                            <!-- Technologies Section -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="framework" class="form-label text-light fw-semibold">
                                        <i class="bi bi-gear me-1"></i>Framework
                                    </label>
                                    <input type="text" 
                                           class="form-control bg-dark text-light border-secondary" 
                                           id="framework" 
                                           name="tag[framework][]" 
                                           placeholder="e.g., React, Laravel">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="database" class="form-label text-light fw-semibold">
                                        <i class="bi bi-database me-1"></i>Database
                                    </label>
                                    <input type="text" 
                                           class="form-control bg-dark text-light border-secondary" 
                                           id="database" 
                                           name="tag[database][]" 
                                           placeholder="e.g., MySQL, MongoDB">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="language" class="form-label text-light fw-semibold">
                                        <i class="bi bi-code-slash me-1"></i>Language
                                    </label>
                                    <input type="text" 
                                           class="form-control bg-dark text-light border-secondary" 
                                           id="language" 
                                           name="tag[language][]" 
                                           placeholder="e.g., PHP, JavaScript">
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add Project
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;
}

// function show skill form

function showskill(){
    echo <<<HTML
    <div class="container-fluid bg-dark min-vh-100 py-5" data-bs-theme="dark">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">
                            <i class="bi bi-award me-2"></i>Add Skill
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST" class="needs-validation"   novalidate>
                            <input type="hidden" name="action" value="skill">
                            
                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label text-light fw-semibold">
                                    <i class="bi bi-card-text me-1"></i>Skill Name
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="title" 
                                       name="title" 
                                       placeholder="Enter Skill Name"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a valid Skill  Name.
                                </div>
                            </div>
                            
                          
                           <div class="mb-3">
                                <label for="range" class="form-label text-light fw-semibold" input>
                                    <i class="bi bi-card-text me-1"></i>Persentase Skill
                                </label>
                                <br>
                                <input type="range" 
                                       name="persen" 
                                       min="10"
                                       max="100"
                                       value="20"
                                        oninput="rangeValue.value = persen.value + '%'">
                                       <output id="rangeValue">20%</output>
                                <div class="invalid-feedback">
                                    Please provide a valid range  Name.
                                </div>
                            </div>
                            
                          
                            <div class="mb-3">
                                <label for="icon" class="form-label text-light fw-semibold">
                                    <i class="bi bi-image me-1"></i>Icon Skill 
                                </label>
                                <input type="text" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="icon" 
                                       name="icon" 
                                       placeholder="fa-icon">
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add Skill
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;

}

// Add this script at the end of your HTML document (before </body>)
function addFormValidationScript()
{
    echo <<<HTML
    <script>
    // Bootstrap form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
HTML;
}
?>
