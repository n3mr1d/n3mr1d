<?php
function showabout(){
print_start("about");
echo'   
<section class="d-flex justify-content-center">
            <div class="col-lg-6 col-md-12" style="width:70%;">
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
                    </section>
                    
                    ';
            }