<?php require_once 'partials/header.php'; ?>

<?php
$id = $_GET['id'];
$query = mysqli_query(db::$con, "SELECT * FROM posts WHERE id='".addslashes($id)."'");
$post = mysqli_fetch_assoc($query);

if(empty($post['id'])) {
    $message = "Unable to find the post that you were looking for";
}

if(isset($_POST['submit'])) {
    try {
        if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['slug'])) {
            throw new Exception('Please make sure that you fill all fields', 400);
        }
        //Check to make sure that the post title doesn't already exist
        if($_POST['title'] != $post['title']) {
            $titleCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE title='".addslashes($_POST['title'])."'");
            $titleCheck = mysqli_fetch_assoc($titleCheck);
            if(!empty($titleCheck['id'])) {
                throw new Exception('There is already a post with that title', 400);
            }
        }
        //Check to make sure that the post slug doesn't already exist
        if($_POST['slug'] != $post['slug']) {
            $slugCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE slug='".addslashes($_POST['slug'])."'");
            $slugCheck = mysqli_fetch_assoc($slugCheck);
            if(!empty($slugCheck['id'])) {
                throw new Exception('There is already a post with that slug', 400);
            }
        }

        //Update the post
        mysqli_query(db::$con, "UPDATE posts SET title='".addslashes($_POST['title'])."', post='".addslashes($_POST['content'])."', slug='".addslashes($_POST['slug'])."' WHERE id='".addslashes($id)."'");
        header('Location: posts.php');
        exit;
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

    <div class="col-xs-12">
        <a href="posts.php"><button class="col-sm-2 col-sm-offset-4 col-xs-12 btn btn-success marginButton"><i class="fa fa-caret-square-o-left"></i> Back to posts</button></a>
        <a href="index.php?logout=true"><button class="col-xs-12 col-sm-2 btn btn-danger marginButton"><i class="fa fa-sign-out"></i> Logout</button></a>

        <?php if(!empty($message)) : ?>
            <div class="alert alert-danger col-sm-offset-4 col-xs-12 col-sm-4" role="alert"><?=$message?></div>
        <?php endif; ?>

        <form action="" method="post" class="col-sm-offset-4 col-xs-12 col-sm-4">
            <div class="form-group">
                <label for="postTitle">Post Title</label>
                <input type="text" class="form-control" id="postTitle" placeholder="Post Title" name="title" value="<?=(!empty($post['title']) ? $post['title'] : '')?>">
            </div>

            <div class="form-group">
                <label for="postType">Post Type</label>
                <select name="type" class="form-control">
                    <option value="text" <?=($post['type'] == 'text' ? 'selected' : '')?>>Text</option>
                    <option value="image" <?=($post['type'] == 'image' ? 'selected' : '')?>>Image</option>
                </select>
            </div>

            <div class="form-group">
                <label for="postPost">Post Content</label>
                <textarea id="textarea" class="form-control" name="content"><?=(!empty($post['post']) ? $post['post'] : '')?></textarea>
            </div>

            <div class="form-group">
                <label for="postSlug">Post Slug</label>
                <input type="text" class="form-control" id="postSlug" placeholder="Post Slug" name="slug" value="<?=(!empty($post['slug']) ? $post['slug'] : '')?>">
            </div>

            <div class="form-group">
                <input type="submit" value="Update" class="btn btn-success col-xs-12" name="submit">
            </div>
        </form>
    </div>

<?php require_once 'partials/footer.php'; ?>