<?php 
function navbar(){
    global $now;
    
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';
    echo '<link rel="stylesheet" href="/resource/style/navbar.css">';
    echo '
    <nav class="nav-container">
        <div class="kontainer-nav">
            <div class="kontainer hire" id="hire"><a href="https://www.freelancer.com/u/n3mr1d/" class="menu"><i class="bi bi-briefcase-fill"></i> Hire me</a></div>
            <div class="kontainer clock" id="time">
    ';
    echo '<i class="bi bi-clock-fill"></i><span class="clock"></span>';
    
    echo '
            </div>
            <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                <i class="bi bi-list"></i>
            </div>
            <div class="kontainer menu" id="main-menu">
    ';
    
    // Define menu items in an array
    $menuItems = [
        'home' => ['icon' => 'bi-house-fill', 'text' => 'Home', 'link' => '/'],
        'skill' => ['icon' => 'bi-code-slash', 'text' => 'Skill', 'link' => '#skills'],
        'about' => ['icon' => 'bi-person-fill', 'text' => 'About', 'link' => '#about'],
        'project' => ['icon' => 'bi-diagram-3-fill', 'text' => 'Project', 'link' => '#project'],
        'donate' => ['icon' => 'bi-wallet2', 'text' => 'Donate', 'link' => '/donate']
    ];
    
    // Loop through the array to generate menu items
    foreach ($menuItems as $key => $item) {
        $activeClass = ($now == $key) ? 'active' : '';
        echo '<button class="menu ' . $key . ' ' . $activeClass . '" onclick="window.location.href=\'' . $item['link'] . '\'"><i class="bi ' . $item['icon'] . '"></i> ' . $item['text'] . '</button>';
    }
    
    if(isset($_SESSION['user_id'])){
        echo '<form action="" method="post">
            <button type="submit" name="logout" class="menu log"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>';
    }else{
        echo '<button onclick="window.location.href=\'/admin\'" class="menu login"><i class="bi bi-box-arrow-in-right"></i> Login</button>';
    }
    echo '
        
            </div>
        </div>
    </nav>
    ';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Clock functionality
        function updateClock() {
            const clockElement = document.getElementById("time");
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, "0");
            const minutes = now.getMinutes().toString().padStart(2, "0");
            const seconds = now.getSeconds().toString().padStart(2, "0");
            
            if (clockElement) {
                const clockSpan = clockElement.querySelector(".clock");
                if (clockSpan) {
                    clockSpan.innerHTML = hours + ":" + minutes + ":" + seconds;
                }
            }
        }
        
        // Update clock immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);
        
        // Responsive navigation functionality
        const mobileMenuToggle = document.getElementById("mobile-menu-toggle");
        const mainMenu = document.getElementById("main-menu");
        let isMenuOpen = false;
        
        // Function to check window size and adjust menu visibility
        function checkWindowSize() {
            if (window.innerWidth <= 768) {
                mobileMenuToggle.style.display = "block";
                if (!isMenuOpen) {
                    mainMenu.style.display = "none";
                }
            } else {
                mobileMenuToggle.style.display = "none";
                mainMenu.style.display = "flex";
            }
        }
        
        // Toggle menu on mobile
        mobileMenuToggle.addEventListener("click", function() {
            isMenuOpen = !isMenuOpen;
            
            if (isMenuOpen) {
                mainMenu.style.display = "flex";
                mainMenu.style.animation = "slideDown 0.3s ease forwards";
                mobileMenuToggle.innerHTML = \'<i class="bi bi-x-lg"></i>\';
            } else {
                mainMenu.style.animation = "slideUp 0.3s ease forwards";
                setTimeout(() => {
                    mainMenu.style.display = "none";
                }, 300);
                mobileMenuToggle.innerHTML = \'<i class="bi bi-list"></i>\';
            }
        });
        
        // Reset menu state when returning to desktop view
        window.addEventListener("resize", function() {
            if (window.innerWidth > 768 && isMenuOpen) {
                isMenuOpen = false;
                mainMenu.style.animation = "";
                mainMenu.style.display = "flex";
                mobileMenuToggle.innerHTML = \'<i class="bi bi-list"></i>\';
            }
        });
        // Close menu when clicking on a menu item (for mobile)
        const menuItems = document.querySelectorAll(".menu");
        menuItems.forEach(item => {
            item.addEventListener("click", function() {
                if (window.innerWidth <= 768) {
                    isMenuOpen = false;
                    mainMenu.style.animation = "slideUp 0.3s ease forwards";
                    setTimeout(() => {
                        mainMenu.style.display = "none";
                    }, 300);
                    mobileMenuToggle.innerHTML = \'<i class="bi bi-list"></i>\';
                }
            });
        });
        
        // Add animation styles dynamically
        const style = document.createElement("style");
        style.textContent = `
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideUp {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-20px); }
            }
        `;
        document.head.appendChild(style);
        
        // Initial check and listen for window resize
        checkWindowSize();
        window.addEventListener("resize", checkWindowSize);
    });
    </script>';
}