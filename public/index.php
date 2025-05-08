<?php
// initial
// define global variable
define("app_name", "Portfolio");
define("email", "nemraid@protonmail.com");
define("DBUSER", "avnadmin");
define("DBPASS", "AVNS_AwANpZxyr-aGDi6V70P");
define("DBHOST", "mysql-b6cf9cf-exitings-93c2.f.aivencloud.com");
define("DBNAME", "defaultdb");
define("DBPORT", "25268");
// define("DBUSER", "root");
// define("DBPASS", "180406");
// define("DBHOST", "localhost");
// define("DBNAME", "testing");
// define("DBPORT", "3306");

try {
    $sql = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . DBPORT . ";ssl-mode=REQUIRED" , DBUSER, DBPASS);
    $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$error = '';

$skillCategories = [
'Frontend Development' => [
    ['name' => 'HTML5/CSS3', 'icon' => 'bi-filetype-html', 'percentage' => 95],
    ['name' => 'JavaScript', 'icon' => 'bi-filetype-js', 'percentage' => 40],
],
'Backend Development' => [
    ['name' => 'PHP', 'icon' => 'bi-filetype-php', 'percentage' => 92],
    ['name' => 'MySQL/MongoDB', 'icon' => 'bi-database-fill', 'percentage' => 40],
    ['name' => 'Rust', 'icon' => 'bi-gear-fill', 'percentage' => 90],
    ['name' => 'Java', 'icon' => 'bi-filetype-java', 'percentage' => 40]
],
'Other Technologies' => [
    ['name' => 'Git/GitHub', 'icon' => 'bi-git', 'percentage' => 50],
    ['name' => 'Linux', 'icon' => 'bi-terminal', 'percentage' => 80],
   
]
];
//  function initial
require_once 'autoload.php';
route();
$now = "";

function start(string $title = "", string $style = "") {
    global $now,$error;
    $now = $title;
    
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<title>' . app_name . ' | ' . $title . '</title>';
    echo '<link rel="stylesheet" href="/resource/style/global.css">';
    if (!empty($style)) {
        echo '<link rel="stylesheet" href="/resource/style/' . $style . '.css">';
    }
    echo '</head>';
    echo '<body>';
    navbar();

    
}

function showhome(){
    global $now, $skillCategories, $sql;
    // Define projects using an array
   
    start('Home', 'home');

    echo '<main class="kontainer-main">
        <div class="hero-section">
            <div class="tech-overlay"></div>
            <div class="hero-content">
                <h1 class="glitch-text">Welcome to My Space</h1>
                <p class="typewriter">Full-Stack Developer</p>
            </div>
            <div class="tech-particles" id="particles-js"></div>
        </div>

        <div class="about-section" id="about">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> About Me <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            <div class="about-content">
                <div class="profile-image">
                    <div class="image-container">
                        <img src="/resource/img/profile.jpg" alt="Developer Profile">
                        <div class="image-glitch"></div>
                    </div>
                </div>
                <div class="profile-info">
                    <p>I\'m a passionate Full-Stack Developer currently expanding my skills in both frontend and backend development. While I\'m still in the learning phase, I have hands-on experience with technologies such as PHP, Laravel, HTML5, Nginx, and Linux, as well as in web scraping, web crawling, and website hosting.</p>
                    
                    <p>In addition to technical skills, I\'m also capable in copywriting, article rewriting, and copy typing, which support various types of digital work. With a strong willingness to learn and a commitment to delivering high-quality results, I\'m ready to support your projects with focus and reliability.</p>
                </div>
            </div>
        </div>

        <div class="skills-section" id="skills">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> Technical Skills <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            <div class="skills-container">';
            
            // Loop through each skill category
            foreach ($skillCategories as $categoryName => $skills) {
                echo '<div class="skill-category">
                    <h3>' . $categoryName . '</h3>
                    <div class="skill-items">';
                
                // Loop through each skill in the category
                foreach ($skills as $skill) {
                    echo '<div class="skill-item">
                        <div class="skill-icon"><i class="bi ' . $skill['icon'] . '"></i></div>
                        <div class="skill-info">
                            <h4>' . $skill['name'] . ' | ' . $skill['percentage'] . '%</h4>
                            <div class="progress-bar">
                                <div class="progress" style="width: ' . $skill['percentage'] . '%"></div>
                            </div>
                        </div>
                    </div>';
                }
                
                echo '</div>
                </div>';
            }
            
            echo '</div>';
          // Define pagination variables
          $projectsPerPage = 6;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $projectsPerPage;
          
          try {
              // Corrected SQL query with proper ORDER BY syntax and LIMIT for pagination
              $projectQuery = "SELECT title, cover_path, deskrip, uploadby, catagory, link, createat FROM projects ORDER BY createat DESC LIMIT :offset, :limit";
              $stmt = $sql->prepare($projectQuery);
              $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
              $stmt->bindParam(':limit', $projectsPerPage, PDO::PARAM_INT);
              $stmt->execute();
              $projects = $stmt->fetchAll(PDO::FETCH_OBJ);
              
              // Count total projects for pagination
              $countQuery = "SELECT COUNT(*) as total FROM projects";
              $countStmt = $sql->prepare($countQuery);
              $countStmt->execute();
              $totalProjects = $countStmt->fetch(PDO::FETCH_OBJ)->total;
              $totalPages = ceil($totalProjects / $projectsPerPage);
          } catch(PDOException $e) {
              echo "Query failed: " . $e->getMessage();
              $projects = [];
              $totalPages = 0;
          }

        echo'
            <div class="featured-projects" id="project">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> Projects <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            <div class="projects-grid">';
            
          
            // Display projects
            if(!empty($projects)){
                foreach ($projects as $project) {
                    echo '<div class="project-card">
                        <div class="project-image">
                            <img src="' . htmlspecialchars($project->cover_path) . '" alt="' . htmlspecialchars($project->title) . '">
                            <div class="project-overlay">
                                <div class="project-links">
                                    <a href="' . htmlspecialchars($project->sample) . '" class="project-link"><i class="bi bi-eye-fill"></i> View</a>
                                    <a href="'. htmlspecialchars($project->link) .'" class="project-link"><i class="bi bi-github"></i> Code</a>
                                </div>
                            </div>
                        </div>
                        <div class="project-info">
                            <h3>' . htmlspecialchars($project->title) . '</h3>
                            <p>' . htmlspecialchars($project->deskrip) . '</p>
                            <div class="project-tech">
                                <span>' . htmlspecialchars($project->catagory) . '</span>
                                <span>By: ' . htmlspecialchars($project->uploadby) . '</span>
                                <span>' . date('d M Y', strtotime($project->createat)) . '</span>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="no-projects"><h2>Coming soon</h2></div>';
            }
            
            echo '</div>'; // Close projects-grid
            
            // Pagination controls
            if ($totalPages > 1) {
                echo '<div class="pagination">
                    <ul>';
                
                // Previous page link
                if ($page > 1) {
                    echo '<li><a href="?page=' . ($page - 1) . '#project">&laquo; Previous</a></li>';
                }
                
                // Page numbers
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $page) ? ' class="active"' : '';
                    echo '<li' . $activeClass . '><a href="?page=' . $i . '#project">' . $i . '</a></li>';
                }
                
                // Next page link
                if ($page < $totalPages) {
                    echo '<li><a href="?page=' . ($page + 1) . '#project">Next &raquo;</a></li>';
                }
                
                echo '</ul>
                </div>';
            }

      
    echo '</div></main>';
    footer();
    echo '<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>';
    echo'<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Initialize particles.js
    if (typeof particlesJS !== "undefined") {
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#0af"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                },
                "size": {
                    "value": 3,
                    "random": true,
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#0af",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    }
    
    // Typewriter effect
    const typewriterText = document.querySelector(".typewriter");
    if (typewriterText) {
        const text = typewriterText.textContent;
        typewriterText.textContent = "";
        let i = 0;
        function typeWriter() {
            if (i < text.length) {
                typewriterText.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            } else {
                // When typing is complete, start erasing after a pause
                setTimeout(eraseText, 1000);
            }
        }
        
        function eraseText() {
            if (typewriterText.textContent.length > 0) {
                typewriterText.textContent = typewriterText.textContent.slice(0, -1);
                setTimeout(eraseText, 30);
            } else {
                // Reset counter and start typing again
                i = 0;
                setTimeout(typeWriter, 500);
            }
        }
        
        typeWriter();
    }
    
    // Scroll animations
    const sections = document.querySelectorAll(".section-header, .skill-item, .project-card");
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate");
            }
        });
    }, { threshold: 0.1 });
    
    sections.forEach(section => {
        observer.observe(section);
    });
});
    </script>';
}
function footer(){
    echo '<footer class="footer-container">
        
        <div class="footer-content">
          
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="/"><i class="bi bi-chevron-right"></i> Home</a></li>
                    <li><a href="#skills"><i class="bi bi-chevron-right"></i> Skills</a></li>
                    <li><a href="#project"><i class="bi bi-chevron-right"></i> Projects</a></li>
                    <li><a href="#about"><i class="bi bi-chevron-right"></i> About</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Info</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <p>' . email . '</p>
                    </div>
       
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Follow Me</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/profile.php?id=100008617822000" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/eid3n_4/" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.freelancer.com/u/n3mr1d/" class="social-icon"><i class="bi bi-linkedin"></i></a>
                    <a href="https://github.com/n3mr1d" class="social-icon"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
        
        <div class="footer-decoration">
            <div class="tech-line"></div>
        </div>
    </footer>';
    echo'<script>
    
document.addEventListener("DOMContentLoaded", function() {
    // Footer animation
    const footerSections = document.querySelectorAll(".footer-section");
    footerSections.forEach((section, index) => {
        section.style.animationDelay = (index * 0.2) + "s";
        section.classList.add("footer-animate");
    });
    
    // Back to top functionality
    const backToTop = document.createElement("div");
    backToTop.classList.add("back-to-top");
    backToTop.innerHTML = "<i class=\"bi bi-arrow-up-circle-fill\"></i>";
    document.body.appendChild(backToTop);
    
    backToTop.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
    
    window.addEventListener("scroll", function() {
        if (window.scrollY > 300) {
            backToTop.classList.add("show");
        } else {
            backToTop.classList.remove("show");
        }
    });
});
    </script>
    </body></html>
    ';
}
if(isset($_POST['upload'])) {
upload();
}
function upload(){
    global $sql, $error;
        if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
            
            // Create directory if it doesn't exist
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($_FILES['cover']['name']);
            $target_path = $upload_dir . $file_name;
            $web_path = '/upload/' . $file_name;
            
            if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_path)) {
                // File uploaded successfully, now save to database
                $title = htmlspecialchars($_POST['title']);
                $deskrip = htmlspecialchars($_POST['deskrip']);
                $uploadby = htmlspecialchars($_POST['uploadby']);
                $category = htmlspecialchars($_POST['category']);
                $link = htmlspecialchars($_POST['link']);
                $view = htmlspecialchars($_POST['view']);
                
                try {
                    $in = "INSERT INTO projects(cover_path, title, deskrip, uploadby, catagory, link, sample) 
                           VALUES(:cover, :title, :deskrip, :uploadby, :catagory, :link, :view)";
                    $stmt = $sql->prepare($in);
                    $stmt->bindParam(':cover', $web_path);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':deskrip', $deskrip);
                    $stmt->bindParam(':uploadby', $uploadby);
                    $stmt->bindParam(':catagory', $category);
                    $stmt->bindParam(':link', $link);
                    $stmt->bindParam(':view', $view);
                    $stmt->execute();
                    
                    $error = '<div class="success-message">Project uploaded successfully!</div>';
                } catch(PDOException $e) {
                    $error = '<div class="error-message">Database error: ' . $e->getMessage() . '</div>';
                }
            } else {
                $error = '<div class="error-message">Error uploading file!</div>';
            }
        } else {
            $error = '<div class="error-message">Please select a valid image file!</div>';
        }

}