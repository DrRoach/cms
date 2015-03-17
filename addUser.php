<?php require_once 'partials/header.php'; ?>
<?php require_once 'user.php'; ?>

<?php
if(isset($_POST['submit'])) {
    try {
        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confPassword'])) {
            throw new Exception('Please make sure that you fill all fields', 400);
        }

        /**
         * TODO: Logic for adding user
         */
        //Check to make sure that the passwords match
        if($_POST['password'] != $_POST['confPassword']) {
            throw new Exception("Please make sure that your passwords match", 400);
        }

        //Check to make sure that a user with that username doesn't already exist
        $usernameCheck = mysqli_query(db::$con, "SELECT id FROM users WHERE username='".addslashes($_POST['username'])."'");
        $usernameCheck = mysqli_fetch_assoc($usernameCheck);
        if(!empty($usernameCheck['id'])) {
            throw new exception("Sorry that username is already in use", 400);
        }

        //Create new user
        //Generate salt
        $salt = user::generateSalt();
        $hash = user::generatePassword($salt, $_POST['password']);
        //Insert new user
        mysqli_query(db::$con, "INSERT INTO users (username, password, salt, admin) VALUES ('".addslashes($_POST['username'])."', '".$hash."', '".$salt
            ."', 0)");
        header('Location: users.php');
        exit;
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

    <div class="col-xs-12">
        <a href="users.php"><button class="col-sm-2 col-sm-offset-4 col-xs-12 btn btn-info marginButton"><i class="fa fa-caret-square-o-left"></i> Back to Users</button></a>
        <a href="index.php?logout=true"><button class="col-xs-12 col-sm-2 btn btn-danger marginButton"><i class="fa fa-sign-out"></i> Logout</button></a>

        <?php if(!empty($message)) : ?>
            <div class="alert alert-danger col-sm-offset-4 col-xs-12 col-sm-4" role="alert"><?=$message?></div>
        <?php endif; ?>

        <form action="" method="post" class="col-sm-offset-4 col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?=(!empty($_POST['username']) ? $_POST['username'] : '')?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <div class="form-group">
                <label for="confPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confPassword" placeholder="Confirm Password" name="confPassword">
            </div>

            <div class="form-group">
                <input type="submit" value="Add" class="btn btn-success col-xs-12" name="submit">
            </div>
        </form>
    </div>

<?php require_once 'partials/footer.php'; ?>