<?php
// define social media link
define("DBHOST", getenv("DBHOST"));
define("DBNAME", getenv("DBNAME"));
define("DBUSER", getenv("DBUSER"));
define("DBPASS", getenv("DBPASS"));
define("DBPORT", getenv("DBPORT"));
//  define("DBHOST","localhost");
//  define("DBNAME","testing");
//  define("DBUSER","root");
//  define("DBPASS","180406");
//  define("DBPORT","3364");
define("GITHUBTOKEN", getenv("GITHUB_TOKEN"));
define("GITHUB", "https://github.com/n3mr1d");
define("IG", "https://www.instagram.com/eid3n_4/");
define("LINKID", "www.linkedin.com/in/nameraid");
define("TWITER", "");
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
$socialLinks = [
    'github' => [
      'url' => GITHUB,
      'icon' => 'fab fa-github'
    ],
    'linkedin' => [
      'url' => LINKID,
      'icon' => 'fab fa-linkedin'
    ],
    'instagram' => [
      'url' => IG,
      'icon' => 'fab fa-instagram'
    ]
  ];
