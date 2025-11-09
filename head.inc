<?php

$current_page = basename($_SERVER['PHP_SELF']);


$page_css = [
    'index.php'   => 'index_styles.css',
    'jobs.php'    => 'jobs_styles.css',
    'apply.php' => 'apply_styles.css',
    'about.php'   => 'about_styles.css',
    'login.php'   => 'login_styles.css',
    'manage.php' => 'manage_styles.css',
    'views_eoi.php' => 'views_eoi.css',

];


$page_titles = [
    'index.php'   => 'Home Page',
    'jobs.php'    => 'Jobs Positions',
    'apply.php' => 'Applications',
    'about.php'   => 'About Us',

    'login.php'   => 'Login',
    'manage.php' => 'Manager Page',
    'views_eoi.php' => 'EOIS Views',
];
?>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
    <meta name="keywords" content="HTML5, tags">
    <meta name="author" content="a group of students">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

    <!-- Common CSS -->
    <link href="styles/common_styles.css" rel="stylesheet">

    <!-- Page-specific CSS -->
    <?php
    echo '<link href="styles/' . htmlspecialchars($page_css[$current_page]) . '" rel="stylesheet">';
    ?>



    <!-- Dynamic Page Title -->
    <title>
        <?php
        echo htmlspecialchars($page_titles[$current_page]);
        ?>
    </title>
</head>

