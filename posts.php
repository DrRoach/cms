<?php require_once 'partials/header.php'; ?>

<?php
$posts = mysqli_query(db::$con, 'SELECT * FROM posts ORDER BY id DESC');
?>

<div class="col-xs-12">
    <a href="addPost.php"><button class="col-sm-2 col-xs-12 btn btn-success marginButton"><i class="fa fa-plus"></i> Add Post</button></a>

    <a href="users.php"><button class="col-sm-2 col-xs-12 col-sm-offset-6 btn btn-info marginButton"><i class="fa fa-user"></i> Users</button></a>
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
                <th>Title</th>
                <th>Post</th>
                <th>Slug</th>
                <th>By</th>
                <th>Posted On</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($posts)) : ?>
            <tr>
                <td><?=$row['id'];?></td>
                <td><?=$row['title'];?></td>
                <td><?=$row['post'];?></td>
                <td><?=$row['slug'];?></td>
                <td><?=$row['posted_by'];?></td>
                <td><?=$row['date'];?></td>
                <td><a href="editPost.php?id=<?=$row['id']?>"><button class="btn btn-info col-xs-12 "><i class="fa fa-pencil-square-o"></i> Edit</button></a></td>
                <td><a href="index.php?deletePost=true&id=<?=$row['id']?>"><button class="btn btn-danger col-xs-12 "><i class="fa fa-times"></i> Delete</button></a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>