<?php require_once 'partials/header.php'; ?>

<?php
    if(isset($_POST['login'])) {
        require_once getcwd().'/user.php';
        try {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                throw new Exception('Missing username or password', 400);
            }
            $passwordData = mysqli_query(db::$con, 'SELECT salt,password,username,admin FROM users WHERE username = "'.addslashes($_POST['username']).'"');
            while($row = mysqli_fetch_assoc($passwordData)) {
                if($row['password'] == user::generatePassword($row['salt'], $_POST['password'])) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['admin'] = $row['admin'];
                    header('Location: index.php');
                    exit;
                }
            }
            throw new Exception('Invalid username or password', 400);
        } catch(Exception $e) {
            $message = $e->getMessage();
        }
    }
?>

<div id="imageOverlay"></div>
<div id="loginImage"></div>

<div id="loginForm" class="col-xs-12">
    <h1>Login</h1>
    <?php if(!empty($message)) : ?>
        <div role="alert" class="col-sm-2 col-xs-12 col-sm-offset-5 alert alert-danger"><?=$message?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group col-sm-4 col-xs-12 col-sm-offset-4">
            <input type="text" class="form-control" placeholder="Username" name="username">
        </div>
        <div class="form-group col-sm-4 col-xs-12 col-sm-offset-4">
            <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="form-group col-sm-4 col-xs-12 col-sm-offset-4">
            <input type="submit" class="form-control btn btn-success" name="login">
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>