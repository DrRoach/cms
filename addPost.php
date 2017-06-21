<?php require_once 'partials/header.php'; ?>

<?php
    if(isset($_POST['submit'])) {
        try {
            require_once 'Post.php';
            $post = Post::add($_POST);
            if ($post) {
                header('Location: posts.php');
                exit;
            }
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

    <form action="" method="post" class="col-sm-offset-4 col-xs-12 col-sm-4" enctype="multipart/form-data">
        <div class="form-group">
            <label for="postTitle">Post Title</label>
            <input type="text" class="form-control" id="postTitle" placeholder="Post Title" name="title" value="<?=(!empty($_POST['title']) ? $_POST['title'] : '')?>">
        </div>

        <div class="form-group">
            <label for="postType">Post Type</label>
            <select name="type" class="form-control">
                <option value="text">Text</option>
                <option value="image">Image</option>
            </select>
        </div>

        <div class="form-group">
            <label for="postPost">Post Content</label>

            <div id="imageContent">
                <input type="file" id="fileUpload" name="fileUpload">
                <p class="help-block">Select a file to upload.</p>
            </div>

            <textarea id="textContent" class="form-control" name="content"><?=(!empty($_POST['content']) ? $_POST['content'] : '')?></textarea>
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
