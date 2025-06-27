<?php

// auto load file 
require __DIR__ . "/config.php";
require __DIR__ . "/autoload.php";




// function component html page
function print_start(string $title): void {
    $title = ucfirst($title);

    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nemraid - {$title}</title>
    <link rel="stylesheet" href="resource/css/global.css">
    <link rel="icon" href="resource/src/logo/logo.svg" type="image/svg+xml">
</head>
<body>
HTML;

    echo navbar(); 
    echo '<script src="/resource/js/notif.js"></script>';
}
function print_end(): void {
    global $socialLinks;

    $year = date('Y');

    echo '
    <script src="https://kit.fontawesome.com/790ed5a49f.js" crossorigin="anonymous"></script>
    <script src="resource/js/bootstrap.bundle.js"></script>
    <footer class="text-light py-5 mt-5">
        <div class="container">
            <div class="row g-4">

                <!-- About Section -->
                <div class="col-lg-6 col-md-12">
                    <div class="footer-section">
                        <h3 class="text-primary mb-3 fw-bold">
                            <i class="fas fa-user-circle me-2"></i>About Me
                        </h3>
                        <p class="text-light opacity-75 lh-lg">
                            I\'m a passionate Full-Stack Developer currently expanding my skills in both frontend and backend development. While I\'m still in the learning phase, I have hands-on experience with technologies such as:
                        </p>
                        <ul class="list-inline text-light opacity-75 small">
                            <li class="list-inline-item me-3"><i class="fab fa-php text-primary me-1"></i> PHP</li>
                            <li class="list-inline-item me-3"><i class="fab fa-laravel text-danger me-1"></i> Laravel</li>
                            <li class="list-inline-item me-3"><i class="fab fa-html5 text-warning me-1"></i> HTML5</li>
                            <li class="list-inline-item me-3"><i class="fab fa-linux text-light me-1"></i> Linux</li>
                            <li class="list-inline-item me-3"><i class="fas fa-server text-muted me-1"></i> Nginx</li>
                            <li class="list-inline-item me-3"><i class="fas fa-spider text-success me-1"></i> Web Scraping</li>
                        </ul>
                    </div>
                </div>

                <!-- Social Media Section -->
                <div class="col-lg-5 col-md-12">
                    <div class="footer-section">
                        <h3 class="text-primary mb-3 fw-bold">
                            <i class="fas fa-share-alt me-2"></i>Connect with Me
                        </h3>
                        <div class="social-links">';

    foreach ($socialLinks as $platform => $data) {
        $name = ucfirst($platform);
        $url = htmlspecialchars($data['url'], ENT_QUOTES, 'UTF-8');
        $icon = htmlspecialchars($data['icon'], ENT_QUOTES, 'UTF-8');

        echo '
            <a href="' . $url . '" class="btn btn-outline-light btn-social me-2 mb-2" target="_blank" rel="noopener">
                <i class="fab ' . $icon . ' me-2"></i>' . $name . '
            </a>';
    }

    echo '
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 opacity-25">

            <!-- Credit Section -->
            <div class="row">
                <div class="col-12 text-center">
                    <div class="credit-section">
                        <p class="mb-0 text-light opacity-75">
                            <a href="https://github.com/n3mr1d"><i class="fab fa-github text-primary me-2"></i></a>
                            Made with 
                            <i class="fas fa-heart text-danger mx-1 heartbeat"></i> 
                            by 
                            <a href="https://github.com/n3mr1d" class="text-primary text-decoration-none fw-bold">Nameraid</a>
                        </p>
                        <small class="text-muted">© ' . $year . ' All rights reserved.</small>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>';
}

// dashboard load function
function dashboard() {
  
    print_start("Dashboard");
    echo '<script src="resource/js/dashboard.js"></script>';

    echo <<<HTML
    <div class="container-fluid bg-dark min-vh-100" data-bs-theme="dark">
        <!-- Dashboard Header -->
        <div class="row">
            <div class="col-12">
                <div class="bg-gradient bg-primary text-white p-4 mb-4">
                    <div class="container">
                        <h1 class="display-4 fw-bold mb-2">
                            <i class="bi bi-speedometer2 me-3"></i>Admin Dashboard
                        </h1>
                        <p class="lead mb-0">Manage your projects, certifications, skill, and crypto coins</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-1">
            <ul class="nav nav-pills nav-fill" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active bg-primary text-white"
                            id="projects-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#projects"
                            type="button"
                            role="tab"
                            aria-controls="projects"
                            aria-selected="true">
                        <i class="fa-solid fa-folder-plus me-2"></i>Projects
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-secondary text-white ms-2"
                            id="crypto-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#crypto"
                            type="button"
                            role="tab"
                            aria-controls="crypto"
                            aria-selected="false">
                        <i class="fa-brands fa-bitcoin me-2"></i>Crypto Coins
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-secondary text-white ms-2"
                            id="certifications-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#certifications"
                            type="button"
                            role="tab"
                            aria-controls="certifications"
                            aria-selected="false">
                        <i class="fa-solid fa-award me-2"></i>Certifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-secondary text-white ms-2"
                            id="skill-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#skill"
                            type="button"
                            role="tab"
                            aria-controls="skill"
                            aria-selected="false">
                        <i class="fa-solid fa-gear me-2"></i>Skill
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="dashboardTabsContent">
            <!-- Projects Tab -->
            <div class="tab-pane fade show active"
                 id="projects"
                 role="tabpanel"
                 aria-labelledby="projects-tab">
HTML;
    // Display project form
    showproform();

    echo <<<HTML
            </div>
            <div class="tab-pane fade"
                 id="crypto"
                 role="tabpanel"
                 aria-labelledby="crypto-tab">
HTML;
    // Display crypto form
    showcrypto();

    echo <<<HTML
            </div>
            <div class="tab-pane fade"
                 id="certifications"
                 role="tabpanel"
                 aria-labelledby="certifications-tab">
HTML;
    // Display certifications form
    showcertif();

    echo <<<HTML
            </div>
            <div class="tab-pane fade"
                 id="skill"
                 role="tabpanel"
                 aria-labelledby="skill-tab">
HTML;
    // Display skill form
    showskill();

    echo <<<HTML
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="bi bi-folder-plus display-4 mb-2"></i>
                            <h5 class="card-title">Projects</h5>
                            <p class="card-text">Manage your portfolio projects</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <i class="bi bi-currency-bitcoin display-4 mb-2"></i>
                            <h5 class="card-title">Crypto Coins</h5>
                            <p class="card-text">Add cryptocurrency wallets</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="bi bi-award display-4 mb-2"></i>
                            <h5 class="card-title">Certifications</h5>
                            <p class="card-text">Showcase your achievements</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('#dashboardTabs button[data-bs-toggle="pill"]');
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function(e) {
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-primary');
                    btn.classList.add('bg-secondary');
                });
                e.target.classList.remove('bg-secondary');
                e.target.classList.add('bg-primary');
            });
        });
    });

    // Form validation script
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function(form) {
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

    // Tampilkan tabel data di bawah dashboard
    echo '<div class="container mt-4">';
    showtable('skill');   // Untuk tabel skill
    showtable('crypto');  // Untuk tabel crypto
    showtable('certif');  // Untuk tabel certif
    showtable('pro');     // Untuk tabel pro
    echo '</div>';

    print_end();
}

// function home page

function homepage(){
    global $socialLinks,$educationHistory,$fetchdata;
    $project = getProjectsWithTags();
    $skill = $fetchdata('skill');
    $certif= $fetchdata('certif');
    print_start("Home");
    echo"<link href='resource/css/home.css' rel='stylesheet'>";
    echo <<<HTML
    <div class="kontainer-hero">
        <div class="kontainer-photo">
            <img src="resource/src/nameraid.png" alt="Profile Picture">
        </div>
        <div class="kontainer-text">
            <div class="animation-text">
                <div id="text"><span>|</span></div>
                <span id="autotext1"></span><span id="cursor">|</span>
                <div class="kontainer-subtitle">
                    <div class="kontainerbox">
                        <span class="subtitle" id="roleText"></span>
                    </div>
                </div>
            </div>
            <div class="kontainer-social">
                <span class="title-social">Connect With Me</span>
                <div class="social-links">
  HTML;

    // Generate social media links dynamically
    foreach ($socialLinks as $platform => $data) {
      echo '<a href="' . htmlspecialchars($data['url']) . '" class="social-icon" target="_blank"><i class="' . htmlspecialchars($data['icon']) . '"></i></a>';
    }
  
    echo <<<HTML
                </div>
            </div>
        </div>
    </div>
     <section class="about-section" id="uwu">
        <h2 class="section-title text-primary mb-4">
            <i class="fas fa-info-circle me-2"></i>About Me
        </h2>
        <div class="kontainer-isitext">
            <div class="profile-img-wrapper">
                <img src="resource/src/whoamii.jpeg" alt="Placeholder Image" class="profile-img">
                <span id="role" class="badge-role">Noob</span>
            </div>

             <div class="content-wrapper">
                 <p class="desc">
                     I'm a passionate Full-Stack Developer currently expanding my skills in both frontend and backend development. While I'm still in the learning phase, I have hands-on experience with:
                 </p>
        
                 <ul class="skills-list">
                     <li><i class="fab fa-php text-primary"></i> PHP</li>
                     <li><i class="fab fa-laravel text-danger"></i> Laravel</li>
                     <li><i class="fab fa-html5 text-warning"></i> HTML5</li>
                     <li><i class="fab fa-linux text-light"></i> Linux</li>
                     <li><i class="fas fa-server text-muted"></i> Nginx</li>
                     <li><i class="fas fa-spider text-success"></i> Web Scraping & Crawling</li>
                     <li><i class="fas fa-globe text-info"></i> Website Hosting</li>
                 </ul>
        
                 <p class="desc">
                     In addition to technical skills, I'm also capable in:
                 </p>
        
                 <ul class="skills-list secondary">
                     <li><i class="fas fa-pen-nib text-info"></i> Copywriting</li>
                 <li><i class="fas fa-edit text-warning"></i> Article Rewriting</li>
                 <li><i class="fas fa-keyboard text-secondary"></i> Copy Typing</li>
             </ul>

             <p class="desc">
                 I believe that <strong>hard work</strong>, <strong>good communication</strong>, and <strong>continuous improvement</strong> are the keys to success in freelancing.
             </p>
         </div>
     </div>
     </section>


    <section class="github-section">
        <h2 class="section-title text-primary "><i class="px-2 fab fa-github"></i>GitHub Profile</h2>
        <div class="kontainer-github">
            <img src="https://placehold.co/200x200" alt="GitHub Avatar" id="github-avatar">
  
            <div id="info-git">
                <div class="user-flex">
                    <span class="label">Name:</span>
                    <div id="username" class="info-value"></div>
                </div>
                
                <div class="kontainer-git">
                    <div class="block-git">
                        <span class="label">Followers</span>
                        <div id="followers" class="info-count"></div>
                    </div>
                    <div class="block-git">
                        <span class="label">Following</span>
                        <div id="following" class="info-count"></div>
                    </div>
                    <div class="block-git">
                        <span class="label">Repos</span>
                        <div id="repo" class="info-count"></div>
                    </div>
                </div>
                
                <div class="user-flex">
                    <span class="label">Bio:</span>
                    <div id="bio" class="info-value"></div>
                </div>
                
                <div class="button-git">
                    <a id="urlgit" class="button-github" href="" target="_blank">
                        <i class="fab fa-github"></i> View Profile <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <h3 class="text-primary section-title "><i class="fa fa-wave-pulse"></i> Contribution Activity</h3>
        <div  id="kontainer-contributions">
          <span >Total Contributions</span>
          <span id="total-contributions"></span>
          
        </div>
        <div id="contribution-calendar" class="contribution-calendar"></div>
    </section>
    <section class="section-history">
        <h2 class="section-title text-primary"><i class="fa-solid fa-school"></i> Graduate</h2>
        <div class="history-container">
            <div class="timeline" id="education-timeline">
  HTML;
  

    if (!empty($educationHistory) && is_array($educationHistory)) {
        foreach ($educationHistory as $isi) {
            echo '<div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">' . htmlspecialchars($isi['name']) . '</h3>
                        <h4 class="timeline-institution">' . htmlspecialchars($isi['school_name']) . '</h4>
                        <p class="timeline-date">' . htmlspecialchars($isi['academic_year']) . '</p>
                        <p class="timeline-description">' . htmlspecialchars($isi['description']) . '</p>
                    </div>
                </div>';
        }
    } else {
        echo '<div class="timeline-item"><div class="timeline-content"><p>No education history available.</p></div></div>';
    }
  
    echo '
            </div>
        </div>
    </section>
  
    <section class="skills-section">
        <div class="section-header">
            <h2 class="section-title text-primary"><i class="fa-solid fa-terminal"></i> My Skills</h2>
        </div>
        <div class="container-box">
    ';
  
    if (!empty($skill) && is_array($skill)) {
        foreach ($skill as $key) {
            $skill_name = htmlspecialchars($key['title']);
            $percentage = intval($key['persentase']);
  
            // Icon logic
            $iconHtml = '';
            if (!empty($key['icon'])) {
                $iconHtml = '<i class="fab ' .$key['icon'] . '"></i>';
            }else {
                $iconHtml = '<img src="https://placehold.co/90x90?text=' . urlencode($skill_name) . '" alt="Skill Icon">';
            }
  
            echo '
                <div class="skill-item">
                    <div class="skill-icon">' . $iconHtml . '</div>
                    <div class="skill-info">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span class="title-skill" style="font-weight:600;font-size:1.1rem;">' . $skill_name . '</span>
                            <span class="title-present" style="font-size:1rem;color:#3b82f6;">' . $percentage . '%</span>
                        </div>
                        <div class="skill-bar" style="background:#222;height:8px;border-radius:4px;margin-top:8px;">
                            <div class="skill-progress" style="width:' . $percentage . '%;background:#3b82f6;height:100%;border-radius:4px;"></div>
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        echo '<div class="skill-item"><p>No skills available.</p></div>';
    }
  
    echo '
        </div>
    </section>
  
   <section class="section-certification">
    <div class="section-header">
        <h2 class="section-title text-primary">
            <i class="fas fa-trophy"></i> Certifications
        </h2>
    </div>
    <div class="container-box">';
        if (!empty($certif) && is_array($certif)) {
            foreach ($certif as $certifs) {
                // Escape output to prevent XSS
                $imgSrc = htmlspecialchars($certifs['imglink'] ?? '', ENT_QUOTES, 'UTF-8');
                $title = htmlspecialchars($certifs['title'] ?? '', ENT_QUOTES, 'UTF-8');
                $source = htmlspecialchars($certifs['source'] ?? '', ENT_QUOTES, 'UTF-8');
                
                echo "<div class='box-serifikat'>
                        <img src='{$imgSrc}' alt='Certification Image' loading='lazy'>
                        <h3 class='title-sertif'>
                            <i class='fa-duotone fa-seal-exclamation'></i> {$title}
                        </h3>
                        <div class='linkhref'>
                            <a href='{$source}' target='_blank' rel='noopener noreferrer'>
                                view more <i class='fa fa-arrow-circle-right'></i>
                            </a>
                        </div>
                      </div>";
            }
        } else {
            echo '<div class="skill-item">
                    <p>No certification available.</p>
                  </div>';
        }
        echo'
    </div>
</section>';
    echo '</div></section>
   
<section class="projects-section" id="projects">
    <h2 class="section-title text-primary">
        <i class="fas fa-list-check"></i> Featured Projects
       
    </h2>

    <div class="projects-container">';
        if (!empty($project) && is_array($project)) {
            foreach($project as $row) {
                $imgSrc = !empty($row['imglink']) ? htmlspecialchars($row['imglink']) : 'https://placehold.co/300x200?text=No+Image';
                $githubLink = !empty($row['repo']) ? '<a href="' . htmlspecialchars($row['repo']) . '" target="_blank" rel="noopener"><i class="fab fa-github"></i>Github</a>' : '';
                $demoLink = !empty($row['demo']) ? '<a href="' . htmlspecialchars($row['demo']) . '" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i>Demo</a>' : '';
                
                $tagsHtml = '';
                if (!empty($row['tags']) && is_array($row['tags'])) {
                    // Remove duplicate tags
                    $uniqueTags = [];
                    foreach ($row['tags'] as $tagObj) {
                        $tagName = trim($tagObj['tag']);
                        if ($tagName !== '' && !isset($uniqueTags[$tagName])) {
                            $uniqueTags[$tagName] = $tagObj;
                        }
                    }
                    
                    foreach ($uniqueTags as $tagObj) {
                        $color = !empty($tagObj['color']) ? htmlspecialchars($tagObj['color']) : '#ccc';
                        $tagName = htmlspecialchars($tagObj['tag']);
                        $icon = !empty($tagObj['icon']) ? $tagObj['icon'] : 'fas fa-tag';
                        $tagsHtml .= '<span class="tag" style="background-color:' . $color . '"><i class="' . $icon . '"></i>' . $tagName . '</span>';
                    }
                }
                
                echo '
                <div class="project-card">
                    <div class="project-image">
                        <div class="showlink">' . $githubLink . $demoLink . '</div>
                        <img src="' . $imgSrc . '" alt="' . htmlspecialchars($row['title']) . ' Project Image" loading="lazy">
                    </div>
                    <div class="project-info">
                        <h3>' . htmlspecialchars($row['title']) . '</h3>
                        <p>' . htmlspecialchars($row['deskrip'] ?? 'No description available.') . '</p>';
                
                if (!empty($tagsHtml)) {
                    echo '
                        <span class="project-tags-label"><i class="fas fa-tags"></i> Tags:</span>
                        <div class="project-tags">' . $tagsHtml . '</div>';
                }
                
                echo '
                    </div>
                </div>';
            }
        } else {
            echo '<div class="skill-item"><p>No projects available.</p></div>';
        }
       
 echo'   </div>
       
<div class="kontainer-info">
        <h3 class="text-primary text-center">
        <i class="fas fa-info-circle "></i> Info
        </h3>
   <div class="color-group">
    <div class="dot-wrap">
        <span class="dot-color language-color"></span>
        <div class="label">Language</div>
    </div>
    <div class="dot-wrap">
        <span class="dot-color framework-color"></span>
        <div class="label">Framework</div>
    </div>
    <div class="dot-wrap">
        <span class="dot-color data-color"></span>
        <div class="label">Database</div>
    </div>
</div>

</div>

</section>';  
  echo'<script src="resource/js/home.js"></script>';

    print_end();
}

// function donate page
function donatepahe(){
    global $fetchdata;
    $crypto = $fetchdata("crypto");

    print_start("Donate");
        echo <<<HTML
        
        
        <div class="container-fluid">
            <div class="container">
                <div class="w-100">
                    <div class="donate-container">
                        <!-- Header Section -->
                        <div class="donate-header">
                            <h1><i class="fas fa-heart me-2"></i>Donate</h1>
                            <p>Support our project with secure cryptocurrency donations</p>
                        </div>
                        
                        <!-- Cryptocurrency Options -->
                        <div class="crypto-grid row g-3">

    HTML;
    foreach($crypto as $crypto2) {
        $inputId = "address-" . md5($crypto2['address']);
        $icon = $crypto2['icon'];
        $name = $crypto2['name'];
        $address = $crypto2['address'];
        echo <<<HTML
            <div class="col-sm-6 col-lg-4">
                <div class="coin-card">
                    <div class="coin-header">
                        <div class="coin-icon">
                            <i class="fab {$icon}"></i>
                        </div>
                        <h4 class="coin-name">{$name}</h4>
                    </div>
                    <div class="address-container">
                        <input type="text" class="form-control crypto-address" id="{$inputId}" value="{$address}" readonly>
                        <button class="copy-btn" onclick="copyAddress(this, '{$address}')">
                            <i class="fas fa-copy"></i> Copy Address
                        </button>
                    </div>
                </div>
            </div>
        HTML;
    }
    
        echo <<<HTML
                        </div>
                        
                        <!-- FAQ Section -->
                        <div class="faq-section">
                            <h3 class="faq-title">Frequently Asked Questions</h3>
                            <div class="accordion" id="donationFAQ">
                                <div class="accordion-item">
                                    <h2 class="accordion-header ">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            <i class="fas fa-question-circle me-2"></i>How are donations used?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#donationFAQ">
                                        <div class="accordion-body">
                                            Your donations directly support server costs, development, and new features. We are committed to transparency and responsible use of all contributions.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"data-bs-target="#faq2">
                                            <i class="fas fa-file-invoice-dollar me-2"></i>Are donations tax-deductible?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#donationFAQ">
                                        <div class="accordion-body">
                                            Please consult with your tax advisor regarding the tax deductibility of your donation, as tax laws vary by jurisdiction.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"   data-bs-target="#faq3">
                                            <i class="fas fa-user-secret me-2"></i>Can I donate anonymously?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#donationFAQ">
                                        <div class="accordion-body">
                                            Yes, cryptocurrency donations can be made anonymously. Blockchain transactions provide privacy while maintaining transparency.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thank You Section -->
                        <div class="thank-you-section">
                            <h2><i class="fas fa-star me-2"></i>Thank You For Your Support!</h2>
                            <p>Every donation, no matter the size, makes a difference to our project and helps us continue improving.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="resource/js/donate.js"></script>
    HTML;
    
        print_end();
    
}


function showtable($table_name){
    global $fetchdata;
    $data = $fetchdata($table_name);
    
    echo "<div class='container-fluid py-4 '>
        <div class='row justify-content-center'>
            <div class='col-12 col-lg-10'>
                <div class='card shadow-lg border-0'>
                    <div class='card-header bg-primary text-white'>
                        <h5 class='card-title mb-0'>
                            <i class='fas fa-table me-2'></i>
                            Data " . ucfirst($table_name) . "
                        </h5>
                    </div>
                    <div class='card-body p-0'>
                        <div class='table-responsive'>
                            <table class='table table-hover table-striped mb-0'>
                                <thead class='table-dark'>
                                    <tr>
                                        <th scope='col' class='text-center' style='width: 80px;'>No</th>
                                        <th scope='col'>Title</th>
                                        <th scope='col' class='text-center' style='width: 120px;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";
    
  
    
    $noitem = 0;
    
    echo "<form action='' method='POST' enctype='multipart/form-data'>";
    
    if(empty($data)) {
        echo "<tr>
                <td colspan='3' class='text-center py-4 text-muted'>
                    <i class='fas fa-inbox fa-2x mb-2'></i>
                    <p class='mb-0'>No data available</p>
                </td>
              </tr>";
    } else {
        foreach($data as $item) {
            $noitem += 1;
            
            $title_field = '';
            switch($table_name) {
                case 'skill':
                case 'certif':
                case 'pro':
                    $title_field = $item['title'] ?? 'N/A';
                    break;
                case 'crypto':
                    $title_field = $item['name'] ?? 'N/A';
                    break;
                default:
                    $title_field = $item['title'] ?? $item['name'] ?? $item['id'] ?? 'N/A';
            }
            
            echo "<tr>
                    <td class='text-center align-middle'>
                        <span class='badge bg-secondary'>{$noitem}</span>
                    </td>
                    <td class='align-middle'>
                        <strong style='color:white;'>{$title_field}</strong>
                    </td>
                    <td class='text-center align-middle'>
                        <input type='hidden' name='table' value='{$table_name}'>
                        <input type='hidden' name='id' value='{$item['id']}'>
                        <input type='hidden' name='action' value='deleted'>
                        <button type='submit' name='delete' class='btn btn-outline-danger btn-sm' 
                                onclick='return confirm(\"Are you sure you want to delete this item?\")'>
                            <i class='fas fa-trash-alt'></i>
                        </button>
                    </td>
                  </tr>";
        }
    }
    
    echo "              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class='card-footer bg-light text-muted text-center'>
                        <small>Total Records: <strong>{$noitem}</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>";
}
function logout() {
  

    // Hapus semua data session
    $_SESSION = [];

    // Hapus cookie sesi jika ada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Hancurkan session
    session_destroy();
}
