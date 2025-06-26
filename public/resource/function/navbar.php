<?php

function navbar() {

    $menuItems = [
        'Home'=>[
            'label'=>'Home',
            'class'=>'donate',
            'link'=>'/index.php',
            'icon'=> 'fa-home'
        ],
        'About' => [
            'label' => 'About', 
            'class' => 'iniclasicon', 
            'link' => '/about',
            'icon' => 'fa-user'
        ],
        'Project' => [
            'label' => 'Projects', 
            'class' => 'iniclasicon', 
            'link' => 'index.php#awili',
            'icon' => 'fa-code'
        ],
        'Donate' => [
            'label' => 'Donate', 
            'class' => 'donate', 
            'link' => '/donate',
            'icon' => 'fa-heart'
        ]
    ];
    
    $isLoggedIn = isset($_SESSION['user_id']);
    
    // Generate desktop navigation
    echo '<nav class="desktop-nav normal" id="desktop-nav">';
    echo '<div class="kontainer-nav">';
    echo '<a href="/" class="logo-container">';
    echo '<div class="logo-kontainer"><img class="imglogo" src="resource/src/logo/logo.svg" width="10%"><span class="titlelogo">N3mr1d.dev</span></div>';
    echo '</a>';
    echo '</div>';
    
    echo '<div class="kontainer-menu">';
    
    // Generate menu items
    foreach ($menuItems as $menu => $details) {
        $isActive = (strpos($_SERVER['REQUEST_URI'], $details['link']) !== false && $details['link'] !== '/') ? 'active' : '';

        echo '<a  class="'.$isActive.'"href="' . $details['link'] . '" data-navitem="' . strtolower($menu) . '">';
        echo '<i class="fas ' . $details['icon'] . '"></i> ';
        echo $details['label'];
        echo '</a>';
    }
    
    // Authentication links
    if ($isLoggedIn) {
        echo '<div class="user-dropdown" id="userDropdown">';
        echo '<button class="dropbtn" onclick="toggleUserDropdown()">';
        echo '<i class="fas fa-user"></i> <i class="fas fa-caret-down"></i>';
        echo '</button>';
        echo '<div class="dropdown-content" id="dropdownContent">';
        echo '<a href="/dashboard"><i class="fas fa-cog"></i> Dashboard</a>';
        echo '<a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<a class="auth-button login-btn" href="/login" id="loginBtn">';
        echo '<i class="fas fa-sign-in-alt"></i> Login';
        echo '</a>';
    }

    echo '</div>';
    echo '</nav>';
    
    // Mobile navigation
    echo '<nav class="mobile-nav" id="mobileNav">';
    echo '<div class="mobile-menu-container" id="mobileMenuContainer">';
    $isActive = (strpos($_SERVER['REQUEST_URI'], $details['link']) !== false && $details['link'] !== '/') ? 'active' : '';

    // Mobile menu items
    foreach ($menuItems as $menu => $details) {
    
        echo '<a class="mobile-menu-item '. $isActive .' " href="' . $details['link'] . '" data-navitem="' . strtolower($menu) . '">';
        echo '<i class="fas ' . $details['icon'] . '"></i> ';
        echo $details['label'];
        echo '</a>';
    }
    
    // Mobile authentication links
    if ($isLoggedIn) {
        echo '<div class="mobile-user-section">';
        echo '<a href="/dashboard" class="mobile-menu-item"><i class="fas fa-cog"></i> Dashboard</a>';
        echo '<a href="/logout" class="mobile-menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>';
        echo '</div>';
    } else {
        echo '<div class="mobile-auth-buttons">';
        echo '<a class="mobile-menu-item" href="/login" id="mobileLoginBtn"><i class="fas fa-sign-in-alt"></i> Login</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</nav>';

    echo <<<JS
    <script>
        // Enhanced dropdown functionality
        function toggleUserDropdown() {
            const dropdown = document.getElementById('dropdownContent');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#userDropdown')) {
                const dropdown = document.getElementById('dropdownContent');
                if (dropdown) {
                    dropdown.style.display = 'none';
                }
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    
                    document.querySelectorAll('[data-navitem]').forEach(navItem => {
                        navItem.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });

        // Navigation click animation
        document.querySelectorAll('[data-navitem]').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.add('nav-click-animation');
                setTimeout(() => {
                    this.classList.remove('nav-click-animation');
                }, 300);
            });
        });

        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuContainer = document.getElementById('mobileMenuContainer');
        
      

        // Mobile navigation scroll behavior
        const mobileNav = document.getElementById('mobileNav');
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                mobileNav.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                mobileNav.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });

       
    </script>
JS;
}