<?php
    require_once 'config.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $url = explode('/', $_SERVER['REQUEST_URI']);
    if((!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) && $url[sizeof($url)-1] != 'login.php') {
        header('Location: login.php');
        exit;
    }

    require_once 'db.php';
?>
<?php db::con(); ?>

<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/script.js"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
</head>
<body>