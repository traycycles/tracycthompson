<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/normalize.css">
    <!-- google fonts go here... below normalize and above main so that when indicated in main, it will know-->
    <link href='https://fonts.googleapis.com/css?family=Changa+One|Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?></title>
</head>
<body>
<header>
    <a href="index.php" id="logo">
        <h1>Tracy C. Thompson</h1>
        <h2>Web Developer</h2>
    </a>
    <nav>
        <ul>
<!--            <li><a href="index.php" class="--><?php //if ($section == 'portfolio'){echo 'selected';} ?><!--">Portfolio</a></li>-->
            <li><a href="index.php" class="<?php if($section == 'about'){echo 'selected';}?>">About</a></li>
            <li><a href="contact.php" class="<?php if ($section == 'contact'){echo 'selected';} ?>">Contact</a></li>
            <li><a href="blog.php" class="<?php if($section == 'blog'){echo 'selected';}?>">Blog</a></li>

        </ul>
    </nav>
</header>
<div id="wrapper">
   <!-- content here -->
<?php
/**
 * Created by PhpStorm.
 * User: tracy
 * Date: 4/10/2018
 * Time: 12:15 PM
 */