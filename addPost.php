<?php require_once 'partials/header.php'; ?>

<?php
    if(isset($_POST['submit'])) {
        try {
            if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['slug'])) {
                throw new Exception('Please make sure that you fill all fields', 400);
            }
            //Check to see if a post with that name exists
            /**
             * TODO: Is this really needed?
             */
            $titleCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE title='".addslashes($_POST['title'])."'");
            while($row = mysqli_fetch_assoc($titleCheck)) {
                throw new Exception("A post with that name already exists", 400);
            }
            //Check to see if a post with that slug already exists
            $slugCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE slug='".addslashes($_POST['slug'])."'");
            while($row = mysqli_fetch_assoc($slugCheck)) {
                throw new Exception("A post with that slug already exists", 400);
            }
            //Everything has passed, add it
            mysqli_query(db::$con, "INSERT INTO posts (title, post, slug, posted_by, date) VALUES ('".addslashes($_POST['title'])."', '".addslashes($_POST['content'])."', '".addslashes($_POST['slug'])."', '".addslashes($_SESSION['username'])."', '".date('Y-m-d H:i:s')."')");
            header('Location: posts.php');
            exit;
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    }
?>

<div class="col-xs-12">
    <a href="posts.php"><button class="col-sm-2 col-sm-offset-4 col-xs-12 btn btn-info marginButton"><i class="fa fa-caret-square-o-left"></i> Back to posts</button></a>
    <a href="index.php?logout=true"><button class="col-xs-12 col-sm-2 btn btn-danger marginButton"><i class="fa fa-sign-out"></i> Logout</button></a>

    <?php if(!empty($message)) : ?>
    <div class="alert alert-danger col-sm-offset-4 col-xs-12 col-sm-4" role="alert"><?=$message?></div>
    <?php endif; ?>

    <form action="" method="post" class="col-sm-offset-4 col-xs-12 col-sm-4">
        <div class="form-group">
            <label for="postTitle">Post Title</label>
            <input type="text" class="form-control" id="postTitle" placeholder="Post Title" name="title" value="<?=(!empty($_POST['title']) ? $_POST['title'] : '')?>">
        </div>

        <div class="form-group">
            <label for="postPost">Post Content</label>
            <textarea id="textarea" class="form-control" name="content"><?=(!empty($_POST['content']) ? $_POST['content'] : '')?></textarea>
        </div>

        <div class="form-group">
            <label for="postSlug">Post Slug</label>
            <input type="text" class="form-control" id="postSlug" placeholder="Post Slug" name="slug" value="<?=(!empty($_POST['slug']) ? $_POST['slug'] : '')?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Post" class="btn btn-success col-xs-12" name="submit">
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>