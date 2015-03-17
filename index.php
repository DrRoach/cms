<?php

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$url = explode('/', $_SERVER['REQUEST_URI']);
if((!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) && $url[sizeof($url)-1] != 'login.php') {
    header('Location: login.php');
    exit;
}

if(isset($_GET['logout']) && $_GET['logout'] == true) {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'user.php';
    user::logout();
}

if(isset($_GET['deletePost']) && isset($_GET['id'])) {
    require_once 'db.php';
    db::con();
    try {
        if(empty($_GET['deletePost']) || empty($_GET['id'])) {
            throw new Exception("Oops, something went wrong", 400);
        }

        //Make sure that the post exists
        $postCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE id='".addslashes($_GET['id'])."'");
        while($row = mysqli_fetch_assoc($postCheck)) {
            //Delete the post
            mysqli_query(db::$con, "DELETE FROM posts WHERE id='".addslashes($_GET['id'])."'");
            break;
        }
    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

if(isset($_GET['deleteUser']) && isset($_GET['id'])) {
    require_once 'db.php';
    db::con();
    try {
        if(empty($_GET['deleteUser']) || empty($_GET['id'])) {
            throw new Exception("Oops, something went wrong", 400);
        }

        //Make sure that the user exists
        $userCheck = mysqli_query(db::$con, "SELECT id FROM users WHERE id='".addslashes($_GET['id'])."'");
        while($row = mysqli_fetch_assoc($userCheck)) {
            //Delete the user
            mysqli_query(db::$con, "DELETE FROM users WHERE id='".$row['id']."'");
            break;
        }
        header('Location: users.php');
        exit;
    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: users.php');
        exit;
    }
}

header('Location: posts.php');
exit;