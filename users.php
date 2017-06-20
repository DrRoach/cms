<?php require_once 'partials/header.php'; ?>

<?php
    $users = mysqli_query(db::$con, "SELECT id,username FROM users ORDER BY id DESC");
?>

<div class="col-xs-12">
    <a href="addUser.php"><button class="col-sm-2 col-xs-12 btn btn-success marginButton"><i class="fa fa-plus"></i> Add User</button></a>

    <a href="posts.php"><button class="col-sm-2 col-xs-12 col-sm-offset-6 btn btn-info marginButton"><i class="fa fa-caret-square-o-left"></i> Back to Posts</button></a>
    <a href="index.php?logout=true"><button class="col-xs-12 col-sm-2 btn btn-danger marginButton"><i class="fa fa-sign-out"></i> Logout</button></a>

    <?php if(!empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger col-xs-12" role="alert"><?=$_SESSION['error']?></div>
    <?php
        unset($_SESSION['error']);
        endif;
    ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($users)) : ?>
            <tr>
                <td><?=$row['id'];?></td>
                <td><?=$row['username'];?></td>
                <td><a href="index.php?deleteUser=true&id=<?=$row['id']?>"><button class="btn btn-danger col-xs-12 "><i class="fa fa-times"></i> Delete</button></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
