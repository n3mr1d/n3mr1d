<?php
// inistial
// difine global variable
define("app_name", "Portfolio");
define("email", "nemraid@protonmail.com");
     $featuredProjects = [
    [
        'image' => '/resource/img/project1.jpg',
        'alt' => 'AI Analytics Dashboard',
        'title' => 'AI Analytics Dashboard',
        'description' => 'A real-time analytics platform with AI-powered insights and predictive modeling.',
        'technologies' => ['React', 'Node.js', 'TensorFlow'],
        'view'=>'https://google.com',
        'code'=>'https://github.com/n3mrid'
    ],
    [
        'image' => '/resource/img/project2.jpg',
        'alt' => 'E-Commerce Platform',
        'title' => 'E-Commerce Platform',
        'description' => 'A scalable e-commerce solution with advanced inventory management and payment processing.',
        'technologies' => ['PHP', 'MySQL', 'JavaScript'],
        'view'=>'https://google.com',
        'code'=>'https://github.com/n3mrid'
    ],
    [
        'image' => '/resource/img/project3.jpg',
        'alt' => 'IoT Smart Home System',
        'title' => 'IoT Smart Home System',
        'description' => 'An integrated IoT solution for home automation with voice control and energy monitoring.',
        'technologies' => ['Python', 'Raspberry Pi', 'MQTT'],
        'view'=>'https://google.com',
        'code'=>'https://github.com/n3mrid'
    ]
];

$skillCategories = [
'Frontend Development' => [
    ['name' => 'HTML5/CSS3', 'icon' => 'bi-filetype-html', 'percentage' => 95],
    ['name' => 'JavaScript', 'icon' => 'bi-filetype-js', 'percentage' => 90],
],
'Backend Development' => [
    ['name' => 'PHP', 'icon' => 'bi-filetype-php', 'percentage' => 92],
    ['name' => 'MySQL/MongoDB', 'icon' => 'bi-database-fill', 'percentage' => 88],
    ['name' => 'Rust', 'icon' => 'bi-gear-fill', 'percentage' => 90]
],
'Other Technologies' => [
    ['name' => 'Git/GitHub', 'icon' => 'bi-git', 'percentage' => 90],
   
]
];
//  function initial
require_once 'autoload.php';
route();
$now = "";
function start(string $title = "", string $style = "") {
    global $now;
    $now = $title;
    
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<title>' . app_name . ' | ' . $title . '</title>';
    send_header();
    echo '<link rel="stylesheet" href="/resource/style/global.css">';
    if (!empty($style)) {
        echo '<link rel="stylesheet" href="/resource/style/' . $style . '.css">';
    }
    echo '</head>';
    echo '<body>';
    navbar();
    
}


function send_header() {
    
    // Set security headers to protect against common attacks
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data:; font-src 'self' https://cdn.jsdelivr.net; connect-src 'self';");
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    
    // Set cache control headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Output complex meta tags for SEO and security
    echo '<meta charset="UTF-8">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">';
    echo '<meta name="description" content="Professional portfolio showcasing skills, projects and expertise">';
    echo '<meta name="keywords" content="portfolio, web development, programming, projects, skills">';
    echo '<meta name="author" content="' . app_name . '">';
    echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">';
    echo '<meta name="theme-color" content="#ffffff">';
    echo '<meta property="og:title" content="' . app_name . '">';
    echo '<meta property="og:description" content="Professional portfolio showcasing skills, projects and expertise">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:url" content="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . '">';
    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . app_name . '">';
    echo '<meta name="twitter:description" content="Professional portfolio showcasing skills, projects and expertise">';
    echo '<link rel="canonical" href="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . '">';
}
function showhome(){
    global $now , $featuredProjects , $skillCategories;
        // Define projects using an array
   
    start('Home','home');
    echo '<main class="kontainer-main">
        <div class="hero-section">
            <div class="tech-overlay"></div>
            <div class="hero-content">
                <h1 class="glitch-text">Welcome to My Portofolio </h1>
                <p class="typewriter">Full-Stack Developer </p>
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
                    <p>Im a passionate Full-Stack Developer currently expanding my skills in both frontend and backend development. While Im still in the learning phase, I have hands-on experience with technologies such as PHP, Laravel, HTML5, Nginx, and Linux, as well as in web scraping, web crawling, and website hosting.</p>
                    
                    <p>In addition to technical skills, Im also capable in copywriting, article rewriting, and copy typing, which support various types of digital work. With a strong willingness to learn and a commitment to delivering high-quality results, Im ready to support your projects with focus and reliability.</p>
                </div>
            </div>
        </div>

        <div class="skills-section" id="skills">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> Technical Skills <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            <div class="skills-container">';
            
            // Define skill categories and their items using arrays
           
            
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
                            <h4>' . $skill['name'] . '</h4>
                            <div class="progress-bar">
                                <div class="progress" style="width: ' . $skill['percentage'] . '%"></div>
                            </div>
                        </div>
                    </div>';
                }
                
                echo '</div>
                </div>';
            }
            
            echo '</div>
        </div>

            <div class="featured-projects" id="project">
            <div class="section-header">
                <h2><span class="tech-accent">&lt;</span> Projects <span class="tech-accent">/&gt;</span></h2>
                <div class="tech-line"></div>
            </div>
            <div class="projects-grid">';
            
        
            // Loop through each project
            foreach ($featuredProjects as $project) {
                echo '<div class="project-card">
                    <div class="project-image">
                        <img src="' . $project['image'] . '" alt="' . $project['alt'] . '">
                        <div class="project-overlay">
                            <div class="project-links">
                                <a href="'.$project['view'] . '" class="project-link"><i class="bi bi-eye-fill"></i> View</a>
                                <a href="'.$project['code'].'" class="project-link"><i class="bi bi-github"></i> Code</a>
                            </div>
                        </div>
                    </div>
                    <div class="project-info">
                        <h3>' . $project['title'] . '</h3>
                        <p>' . $project['description'] . '</p>
                        <div class="project-tech">';
                        
                // Loop through technologies for each project
                foreach ($project['technologies'] as $tech) {
                    echo '<span>' . $tech . '</span>';
                }
                        
                echo '</div>
                    </div>
                </div>';
            }
            
            echo '</div>
        </div>

      
    </main>';
    footer();

    // Add JavaScript for tech effects
    echo '<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
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
    
    echo '<script>
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
    </script>';
}
