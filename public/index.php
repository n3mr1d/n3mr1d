<?php 


// config db
define("DBHOST", getenv("DBHOST"));
define("DBNAME", getenv("DBNAME"));
define("DBPASS", getenv("DBPASS"));
define("DBUSER", getenv("DBUSER"));
$token = getenv("GITHUB_TOKEN");


// define social media link
define("github","https://github.com/n3mr1d");
define("ig","https://www.instagram.com/eid3n_4/");
define("linkid","www.linkedin.com/in/nameraid");
define("twiter","");
// config history 
$educationHistory = [
    "kindergarten" => [
        'name' => 'Taman Kanak-Kanak',
        'school_name' => 'TK KARTIKA IV & VI',
        'academic_year' => '2011/2013',
        'description' => 'Early childhood education focusing on basic learning skills and social development.'
    ],
    "elementary" => [
        'name' => 'Sekolah Dasar',
        'school_name' => 'SDN Polehan 4 Malang',
        'academic_year' => '2013/2019',
        'description' => 'Elementary education with strong foundation in mathematics, science, and language skills.'
    ],
    "junior_high" => [
        'name' => 'Sekolah Menengah Pertama',
        'school_name' => 'SMP AL-Amin Malang',
        'academic_year' => '2019/2022',
        'description' => 'Junior high school education with emphasis on academic excellence and character building.'
    ],
    "senior_high" => [
        'name' => 'Sekolah Menengah Atas',
        'school_name' => 'SMAN 1 Kota Malang',
        'academic_year' => '2022/2025',
        'description' => 'Senior high school education with focus on science and technology preparation.'
    ]
];
// autoload config function
require_once __DIR__ . '/autoload.php';
route();


function print_start(string $title, string $css=""){

  echo'  <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Portofolio | ' . $title .'</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
<link rel="icon" href="resource/src/logo/logo.svg">        
';
     
   
    if(empty($css)){
        echo'<link rel="stylesheet" href="/resource/style/global.css">';
        echo'<link rel="stylesheet" href="/font/fontawesome-free-6.7.2-web/css/all.min.css">'; 
    }else{
        echo'<link rel="stylesheet" href="/font/fontawesome-free-6.7.2-web/css/all.min.css">'; 
        echo'<link rel="stylesheet" href="/resource/style/global.css">';
        echo'<link rel="stylesheet" href="/resource/style/' . $css . '.css">'; 
    }
echo'</head>
    <body>';
    navbar();

}
function jsallow(string $name){
    global $token;

        echo'<script src="/resource/script/'. $name .'.js"> const GITHUB_TOKEN = '. $token .' </script>';
}function showhome() {
  global $educationHistory;

  // Define social media links centrally for easy management
  $socialLinks = [
    'github' => [
      'url' => github,
      'icon' => 'fab fa-github'
    ],
    'linkedin' => [
      'url' => linkid,
      'icon' => 'fab fa-linkedin'
    ],
    'instagram' => [
      'url' => ig,
      'icon' => 'fab fa-instagram'
    ]
  ];
  print_start('home', 'home');
  shownotification();

  echo <<<HTML
  <div class="kontainer-hero">
      <div class="kontainer-photo">
          <img src="/resource/src/nameraid.png" alt="Profile Picture">
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

  <section class="about-section" id="uwu" >
      <h2 class="section-title">About</h2>
      <div class="kontainer-isitext">
          <div class="border-img">
              <img src="./resource/src/whoamii.jpeg" alt="Placeholder Image">
              <span id="role">Noob</span>
          </div>
          <p>I'm a passionate Full-Stack Developer currently expanding my skills in both frontend and backend development. While I'm still in the learning phase, I have hands-on experience with technologies such as PHP, Laravel, HTML5, Nginx, and Linux, as well as in web scraping, web crawling, and website hosting.

In addition to technical skills, I'm also capable in copywriting, article rewriting, and copy typing, which support various types of digital work. With a strong willingness to learn and a commitment to delivering high-quality results, I'm ready to support your projects with focus and reliability.

I believe that hard work, good communication, and continuous improvement are the keys to success in freelancing.
</p>
      </div>
  </section>
  <section class="github-section">
      <h2 class="section-title">GitHub Profile</h2>
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
      
      <h3>Contribution Activity</h3>
      <div id="kontainer-contributions">
        <span>Total Contributions</span>
        <span id="total-contributions"></span>
        
      </div>
      <div id="contribution-calendar" class="contribution-calendar"></div>
  </section>
  <section class="section-history">
      <h2 class="section-title">Graduate</h2>
      <div class="history-container">
          <div class="timeline" id="education-timeline">
HTML;

  // Perbaikan: sanitasi output, penulisan lebih rapi, dan penanganan data kosong

  // Tampilkan riwayat pendidikan
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
      <h2 class="section-title">My Skills</h2>
      <div class="skills-container">';
  $skillku = fetchskill();
  if (!empty($skillku) && is_array($skillku)) {
      foreach($skillku as $skills){
          // Sanitasi data skill
          $skill_name = htmlspecialchars($skills['skill']);
          $percentage = intval($skills['percentage']);
          
          // Penanganan icon
          $iconHtml = '';
          if (!empty($skills['svg_content'])) {
              // Tampilkan SVG inline jika tersedia
              $iconHtml = '<div class="svg-skill-icon" style="width:90px;height:90px;">' . $skills['svg_content'] . '</div>';
          } elseif (!empty($skills['svg_name'])) {
              $icon = htmlspecialchars($skills['svg_name']);
              // Cek apakah file SVG
              if (preg_match('/\.svg$/i', $icon)) {
                  $iconHtml = '<img src="resource/function/uploads/' . $icon . '" alt="' . $skill_name . ' Icon" width="90" height="90">';
              } else {
                  // Jika bukan SVG, coba tampilkan sebagai gambar biasa
                  $iconHtml = '<img src="resource/function/uploads/' . $icon . '" alt="' . $skill_name . ' Icon" width="90" height="90">';
              }
          } else {
              // Fallback ke placeholder jika tidak ada icon
              $iconHtml = '<img src="https://placehold.co/90x90?text=' . urlencode($skill_name) . '" alt="Skill Icon">';
          }
          
          echo '<div class="skill-item">
                  ' . $iconHtml . '
                  <div class="skill-name">
                      <span class="title-skill">' . $skill_name . '</span> 
                      <span class="title-present">' . $percentage . '%</span>
                  </div>
                  <div class="skill-bar">
                      <div class="skill-progress" style="width:' . $percentage . '%"></div>
                  </div>
              </div>';
      }
  } else {
      echo '<div class="skill-item"><p>No skills available.</p></div>';
  }
  echo '</div></section>

  <section class="section-certification">
      <h2 class="section-title">Certification</h2>
      <div class="container-box">
      ';
    $certif = fetchsertif();
    foreach($certif as $certifs) {
    echo" <div class='box-serifikat'>
          <img src='resource/function/". $certifs['path_image'] ."' alt='Certification Image'>
          <h3 class='title-sertif'>" . $certifs['title'] . "</h3>
          <div class='linkhref'>
              <a href='".$certifs['source'] ."'>view more <i class='fa fa-arrow-circle-right'></i></a>
          </div>
      </div>";
 }
  echo '</div></section>
  <section class="projects-section" id="awili">
    <h2 class="section-title" >Featured Projects</h2>
      <div class="projects-container">';

  $project = project();
  if (!empty($project) && is_array($project)) {
      foreach($project as $row){
          $imgSrc = !empty($row->image) ? htmlspecialchars($row->image) : 'https://placehold.co/300x200?text=No+Image';

          $githubLink = !empty($row->github) ? '<a href="' . htmlspecialchars($row->github) . '" target="_blank"><i class="fab fa-github"></i> Github</a>' : '';
          $demoLink = !empty($row->demo) ? '<a href="' . htmlspecialchars($row->demo) . '" target="_blank"><i class="fas fa-external-link-alt"></i> Demo</a>' : '';
          $tagsHtml = '';
          if (!empty($row->tags) && is_array($row->tags)) {
              foreach ($row->tags as $tagObj) {
                  $color = !empty($tagObj->color) ? htmlspecialchars($tagObj->color) : '#ccc';
                  $tagNames = explode(',', $tagObj->tag);
                  foreach ($tagNames as $tagName) {
                      $tagName = trim($tagName);
                      if ($tagName !== '') {
                          $tagsHtml .= '<span class="tag" style="background-color:' . $color . '">' . htmlspecialchars($tagName) . '</span>';
                      }
                  }
              }
          }
                    $statusColor = ($row->statuspo === 'ongoing') ? 'red' : 'green';
          $statusTag = '<span class="tag" style="background-color:' . $statusColor . '">' . htmlspecialchars($row->statuspo) . '</span>';

          echo '
              <div class="project-card">
                  <div class="project-image">
                      <div class="showlink">'
                          . $githubLink . $demoLink .
                      '</div>
                      <img src="resource/function' . $imgSrc . '" alt="Project Image">
                  </div>
                  <div class="project-info">
                      <h3>' . htmlspecialchars($row->title) . '</h3>
                      <p>' . htmlspecialchars($row->deskrip) . '</p>
                      <div class="project-tags">'
                          . $tagsHtml . $statusTag .
                      '</div>
                  </div>
              </div>';
      }
  } else {
      echo '<div class="project-card"><div class="project-info"><p>No projects found.</p></div></div>';
  }

   echo '</div>
  </section>';

  jsallow('home');
  footerku();
  endhtml();
}
  function project(){
    global $db;
    $sql = "
        SELECT 
            p.*, 
            i.path_image AS image
        FROM project p
        LEFT JOIN (
            SELECT project_id, path_image
            FROM image
            WHERE id IN (
                SELECT MIN(id) FROM image GROUP BY project_id
            )
        ) i ON p.id = i.project_id
        ORDER BY p.uploadat DESC
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_OBJ);

    // For each project, fetch all tags
    foreach ($projects as $project) {
        $tagStmt = $db->prepare("SELECT tag, color FROM tag WHERE project_id = :pid");
        $tagStmt->bindParam(':pid', $project->id, PDO::PARAM_INT);
        $tagStmt->execute();
        $project->tags = $tagStmt->fetchAll(PDO::FETCH_OBJ);
    }

    return $projects ?: [];
}

function endhtml(){
    echo'</body></html>';
}
// function show list 

function showNotification() {
    if (!empty($_SESSION['error'])) {
        $error = htmlspecialchars($_SESSION['error']); // Mencegah XSS

        echo <<<HTML
        <div class="kontainer-notif">
            <div class="kontainer-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="kontainer-isi">
                <span class='item-isi'>{$error}</span>
            </div>
        </div>
        HTML;

        unset($_SESSION['error']); // Hapus hanya error, bukan seluruh session
    }
}


function showtable(){
global $db;
// fetch databaseLl
$dbarray = "SELECT * FROM project";
$stmt = $db->prepare($dbarray);
$stmt->execute();
  $ron = $stmt->fetchAll(PDO::FETCH_OBJ);
  if($ron){
          echo<<<HTML
           <h1>Table add project</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>action</th>
    </tr>
  HTML;

  $id = 0;
foreach($ron as $row) {
    $id++;
    echo '<tr>';
      echo '<td>' . $id . '</td>';
      echo '<td>' . htmlspecialchars($row->title) . '</td>';
      echo '<td>';
        echo '<form action="index.php" method="GET">';
          echo '<input type="hidden" name="action" value="edit">';
          echo '<input type="hidden" name="id"     value="' . $row->id . '">';
          echo '<button type="submit">Edit</button>';
        echo '</form> ';
        
        echo '<form action="" method="POST">';
          echo '<input type="hidden" name="action" value="delete">';
          echo '<input type="hidden" name="id"     value="' . $row->id . '">';
          echo '<button type="submit">Delete</button>';
        echo '</form>';
      echo '</td>';
    echo '</tr>';
}
}else{
  echo '<h1>No data</h1>';
}
};
function showdonate(){
  print_start('donate','donate');
  
  // Fetch cryptocurrency data from database
  global $db;
  $crypto_query = "SELECT * FROM cry ORDER BY name ASC";
  $stmt = $db->prepare($crypto_query);
  $stmt->execute();
  $cryptocurrencies = $stmt->fetchAll(PDO::FETCH_OBJ);
  
  jsallow('donate'); // Assuming jsallow function exists to include JS files
  
echo<<<HTML
  <section class="kontainer-donate">

    <div class="donate-options">

      <div class="tab-content active" id="crypto-tab">
        <div class="crypto-explanation">
          <h1 class="section-title">Donate</h1>
          <p>Cryptocurrency donations are secure, fast, and have lower transaction fees.</p>
        </div>
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <div class="kontainer-coin">
HTML;

  // Display cryptocurrency options
foreach($cryptocurrencies as $crypto) {
  $inputId = "address-" . md5($crypto->addre); 

  echo <<<HTML
    <div class="coin-card">
      <div class="coin-icon">
        <i class="fa {$crypto->icon}" aria-hidden="true"></i>
      </div>
      <div class="coin-details">
        <h4>{$crypto->name}</h4>
        <div class="address-container">
          <input type="text" class="crypto-address" id="$inputId" value="{$crypto->addre}" readonly>
     <button class="copy-btn" data-address="{$crypto->addre}">
  <i class="fa fa-copy"></i>
</button>
        </div>

      </div>
    </div>
HTML;
  }

echo<<<HTML
        </div>
      </div>
      

    
    <div class="donation-faq">
      <h3>Frequently Asked Questions</h3>
      <div class="faq-item">
        <div class="faq-question">How are donations used?</div>
        <div class="faq-answer">Your donations directly support server costs, development, and new features.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Are donations tax-deductible?</div>
        <div class="faq-answer">Please consult with your tax advisor regarding the tax deductibility of your donation.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Can I donate anonymously?</div>
        <div class="faq-answer">Yes, cryptocurrency donations can be made anonymously.</div>
      </div>
    </div>
    
    <div class="donation-thankyou">
      <h2>Thank You For Your Support!</h2>
      <p>Every donation, no matter the size, makes a difference to our project.</p>
    </div>
  </section>
HTML;
  endhtml();
}
function getsetting($setting){
  global $db;
  $query = "SELECT * FROM settings WHERE settings = ?";
  $stmt = $db->prepare($query);
  $stmt->execute([$setting]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
// footer function to show up
function footerku() {
  echo<<<HTML
  <footer class="kontainer-footer">
    <div class="kontainermain">
    <div class="kontainer-box"  >
     <h3 class="title-footer">About Me</h3>
       <span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi dolor cum cumque maxime doloremque quidem error recusandae. Dolorum, ab quae?</span>  
     </div> 
     <i class="sparator"></i>
       <div class="kontiner-social">
       <h3 class="title-footer">Connect with Me</h3>

HTML;
         echo'   <a href="'. github . '"><i class="fab fa-github"></i>Github</a>
            <a href="'.ig .'"><i class="fab fa-instagram"></i>Instagram</a>
            <a href="'. twiter .'"><i class="fab fa-twitter"></i>Twitter</a>
            <a href="'.linkid .'"><i class="fab fa-linkedin-in"></i>LinkID</a>';

    echo'

               </div>
               </div>
              <div class="credit-github">
             <span class="credit-text"><i class="fab fa-github"></i> Made With <i class="fa fa-heart"></i> By <a href="#">Nameraid</a></span>
            </div>
             </footer>';
}
function logout(){
  session_destroy();
  showhome();
}
function tabledonate() {
    global $db;
    try {
        $sql = "SELECT * FROM cry ORDER BY id ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        echo '<h1>Donation Table</h1>';
        if ($rows && count($rows) > 0) {
            echo '<table>';
            echo '<thead><tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Address</th>';
            echo '<th>Icon</th>';
            echo '<th>Action</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            $id = 0;
            foreach ($rows as $row) {
                $id++;
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . htmlspecialchars($row->name) . '</td>';
                echo '<td>' . htmlspecialchars($row->address) . '</td>';
                echo '<td>';
                if (!empty($row->icon)) {
                    echo '<img src="' . htmlspecialchars($row->icon) . '" alt="icon" style="width:32px;height:32px;object-fit:contain;">';
                } else {
                    echo '-';
                }
                echo '</td>';
                echo '<td>
                    <form action="" method="POST"  style="display:inline;">
                        <input type="hidden" name="action" value="delcry">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row->id) . '">
                        <button type="submit" style="background:#e74c3c;color:#fff;border:none;padding:5px 12px;border-radius:4px;cursor:pointer;">Delete</button>
                    </form>
                </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<h2>No donation data available.</h2>';
        }
    } catch (Exception $e) {
        echo '<div class="error-message">Error fetching donation data: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
/**
 * Function to display all management sections for admin dashboard
 * Handles the overall layout and organization of admin controls
 */
function showManage() {
    // Initialize page with correct title and admin template
    print_start('Dashboard', 'admin');
    
    // Display any system notifications
    showNotification();

    echo '
    <section class="kontainer-addproject">
        ' . showAddProjectForm() . '
    </section>
    
    <section class="kontainer-editproject">
        ' . showSettings() . '
    </section>
    
    <section class="kontainer-addcertif">
        ' . showformcertf() . '
    </section>
    
    <section class="kontainer-skill">
        ' . addSkillForm() . '
    </section>
    
    <section class="kontainer-table">
        ' . showTable() . '
    </section>
    
    <section class="kontainer-table">
        ' . tableDonate() . '
    </section>';
}
function addskillform() {
  echo '
    <div class="kontainer-form">
      <form action="" method="post" enctype="multipart/form-data" oninput="percentage_output.value = percentage.value">
        <div class="group">
          <input type="hidden" name="action" value="addskill">
          
          <label for="skill">Skill:</label><br>
          <input type="text" id="skill" name="skill" maxlength="255" required><br>
          
          <label for="percentage">Percentage:</label><br>
          <input type="range" id="percentage" name="percentage" min="0" max="100" value="1" required>
          <output name="percentage_output" for="percentage">1</output> <span>%</span><br>
          
          <label for="svg_name">SVG Name:</label><br>
          <input type="text" id="svg_name" name="svg_name" maxlength="255" required><br>
          
          <label for="svg_file">SVG File:</label><br>
          <input type="file" id="svg_file" name="svg_file" accept=".svg,image/svg+xml" required><br>
          
          <button type="submit" style="margin-top:10px;">Add Skill</button>
        </div>
      </form>
    </div>';
}
