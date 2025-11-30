<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
$fetchdata = function($table) {
    global $sql;
    $stmt = $sql->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};
function getTechIcon($techName) {
    $techName = strtolower(trim($techName));
    $icons = [
        // Languages
        'javascript' => 'fab fa-js-square',
        'js' => 'fab fa-js-square',
        'python' => 'fab fa-python',
        'php' => 'fab fa-php',
        'java' => 'fab fa-java',
        'html' => 'fab fa-html5',
        'html5' => 'fab fa-html5',
        'css' => 'fab fa-css3-alt',
        'css3' => 'fab fa-css3-alt',
        'c++' => 'fas fa-code',
        'c#' => 'fas fa-code',
        'go' => 'fas fa-code',
        'rust' => 'fas fa-code',
        'typescript' => 'fas fa-code',
        'swift' => 'fab fa-swift',
        'kotlin' => 'fas fa-mobile-alt',
        
        // Frameworks & Libraries
        'react' => 'fab fa-react',
        'vue' => 'fab fa-vuejs',
        'angular' => 'fab fa-angular',
        'laravel' => 'fab fa-laravel',
        'symfony' => 'fab fa-symfony',
        'django' => 'fas fa-code',
        'flask' => 'fas fa-flask',
        'express' => 'fab fa-node-js',
        'nodejs' => 'fab fa-node-js',
        'node.js' => 'fab fa-node-js',
        'bootstrap' => 'fab fa-bootstrap',
        'tailwind' => 'fas fa-wind',
        'jquery' => 'fas fa-code',
        'spring' => 'fas fa-leaf',
        'codeigniter' => 'fas fa-fire',
        'yii' => 'fas fa-code',
        'cakephp' => 'fas fa-birthday-cake',
        'nextjs' => 'fas fa-arrow-right',
        'nuxtjs' => 'fas fa-mountain',
        'gatsby' => 'fas fa-rocket',
        
        // Databases
        'mysql' => 'fas fa-database',
        'postgresql' => 'fas fa-database',
        'mongodb' => 'fas fa-leaf',
        'sqlite' => 'fas fa-database',
        'redis' => 'fas fa-memory',
        'oracle' => 'fas fa-database',
        'mariadb' => 'fas fa-database',
        'firebase' => 'fas fa-fire',
        'supabase' => 'fas fa-bolt',
        
        // Cloud & DevOps
        'aws' => 'fab fa-aws',
        'azure' => 'fab fa-microsoft',
        'gcp' => 'fab fa-google',
        'docker' => 'fab fa-docker',
        'kubernetes' => 'fas fa-dharmachakra',
        'jenkins' => 'fas fa-cog',
        'nginx' => 'fas fa-server',
        'apache' => 'fas fa-server',
        'heroku' => 'fas fa-cloud',
        'netlify' => 'fas fa-globe',
        'vercel' => 'fas fa-triangle',
        
        // Tools & Others
        'git' => 'fab fa-git-alt',
        'github' => 'fab fa-github',
        'gitlab' => 'fab fa-gitlab',
        'bitbucket' => 'fab fa-bitbucket',
        'npm' => 'fab fa-npm',
        'yarn' => 'fab fa-yarn',
        'webpack' => 'fas fa-cube',
        'vite' => 'fas fa-bolt',
        'sass' => 'fab fa-sass',
        'less' => 'fas fa-code',
        'figma' => 'fab fa-figma',
        'adobe' => 'fab fa-adobe',
        'photoshop' => 'fas fa-image',
        'illustrator' => 'fas fa-pen-nib',
        'wordpress' => 'fab fa-wordpress',
        'shopify' => 'fab fa-shopify',
        'magento' => 'fas fa-shopping-cart',
        'api' => 'fas fa-plug',
        'rest' => 'fas fa-exchange-alt',
        'graphql' => 'fas fa-project-diagram',
        'json' => 'fas fa-brackets-curly',
        'xml' => 'fas fa-code',
        'linux' => 'fab fa-linux',
        'ubuntu' => 'fab fa-ubuntu',
        'windows' => 'fab fa-windows',
        'mac' => 'fab fa-apple',
        'android' => 'fab fa-android',
        'ios' => 'fab fa-apple'
    ];
    
    return isset($icons[$techName]) ? $icons[$techName] : 'fas fa-tag';
}
function getProjectsWithTags() {
    global $sql;
    try {
        $querry = "SELECT p.*, 
                       l.name as lang_name, l.color as lang_color,
                       f.name as framework_name, f.color as framework_color,
                       d.name as data_name, d.color as data_color
                FROM pro p
                LEFT JOIN language l ON p.id = l.project_id
                LEFT JOIN framework f ON p.id = f.project_id
                LEFT JOIN data d ON p.id = d.project_id
                ORDER BY p.created_at DESC";
        
        $stmt = $sql->query($querry);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $projects = [];
        foreach ($results as $row) {
            $projectId = $row['id'];
            
            if (!isset($projects[$projectId])) {
                $projects[$projectId] = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'repo' => $row['repo'],
                    'demo' => $row['demo'],
                    'imglink' => $row['imglink'],
                    'deskrip' => $row['deskrip'],
                    'tags' => []
                ];
            }
            
            // Add language tags
            if (!empty($row['lang_name'])) {
                $projects[$projectId]['tags'][] = [
                    'tag' => $row['lang_name'],
                    'color' => $row['lang_color'],
                    'icon' => getTechIcon($row['lang_name'])
                ];
            }
            
            // Add framework tags
            if (!empty($row['framework_name'])) {
                $projects[$projectId]['tags'][] = [
                    'tag' => $row['framework_name'],
                    'color' => $row['framework_color'],
                    'icon' => getTechIcon($row['framework_name'])
                ];
            }
            
            // Add data tags
            if (!empty($row['data_name'])) {
                $projects[$projectId]['tags'][] = [
                    'tag' => $row['data_name'],
                    'color' => $row['data_color'],
                    'icon' => getTechIcon($row['data_name'])
                ];
            }
        }
        
        return array_values($projects);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}
$getfile = function (string $name) : void {
    global $sql,$crypto;
require_once __DIR__ . "/resource/function/$name.php";
};
$getfile("navbar");
$getfile("database");
$getfile("form");
$getfile("validatedata");
$getfile("about");
$getfile("route");

