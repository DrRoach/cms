<?php

class Post {
    private static $_requiredFields = [
        'type',
        'title',
        'content',
        'slug'
    ];

    public static function add($params) {
        //Require `user.php` to have access to `User` methods
        require_once 'user.php';

        //Make sure that all of the required fields are given
        if (!self::requiredFieldsExist($params)) {
            throw new Exception('Please make sure that all of the required fields are given.');
        }

        //Grab the current username so we know who created the post
        $username = user::getUsername();

        //Check to make sure that a post with the given slug doesn't already exist
        $slugCheck = mysqli_query(db::$con, "SELECT id FROM posts WHERE slug='" . addslashes($params['slug']) . "'");
        $slugCheck = mysqli_fetch_assoc($slugCheck);

        //If `slugCheck` isn't null then slug already exists
        if (!is_null($slugCheck)) {
            throw new Exception('The slug that you enter must be unique.');
        }

        //If the post type is an image then save the image that's being uploaded
        if ($_POST['type'] == 'image') {
            $content = self::uploadImage($_FILES);
        }

        //Grab the time the post was added
        $datetime = date('Y-m-d H:i:s');

        //Sanitize any other data that we need
        $title   = mysqli_real_escape_string(db::$con, $_POST['title']);
        $type    = mysqli_real_escape_string(db::$con, $_POST['type']);
        $slug    = mysqli_real_escape_string(db::$con, $_POST['slug']);

        //If content is empty it hasn't been set by `uploadImage()` call
        if (empty($content)) {
            $content = mysqli_real_escape_string(db::$con, $_POST['content']);
        }

        //Add new post to the table
        mysqli_query(db::$con, "INSERT INTO posts (title, type, post, slug, posted_by, date) 
            VALUES ('$title', '$type', '$content', '$slug', '$username', '$datetime')");

        return true;
    }

    private static function requiredFieldsExist($fields) {
        foreach (self::$_requiredFields as $field) {
            if (!array_key_exists($field, $fields)) {
                return false;
            }
        }

        return true;
    }

    private static function uploadImage($data) {
        //Target directory to save the image to
        $targetDir = __DIR__ . '/images/uploads/';

        //Make sure that the target directory exists
        if (!is_dir($targetDir)) {
            throw new Exception('The directory ' . $targetDir . ' does not exist');
        }

        //The final image directory and image name
        $targetDest = $targetDir . basename($data['fileUpload']['name']);

        //Get the image filetype
        $fileType = pathinfo($targetDest, PATHINFO_EXTENSION);

        //Get the relative image path so image can be found
        $imagePath = '/' . basename(__DIR__) . '/images/uploads/' . addslashes($data['fileUpload']['name']);

        //Check to see if the image is valid
        if (!self::isValidImage($fileType)) {
            throw new Exception('Please make sure that you upload a valid image.');
        }

        //Save the uploaded image
        if (!move_uploaded_file($data['fileUpload']['tmp_name'], $targetDest)) {
            throw new Exception('There was an error when uploading the image.');
        } else {
            return $imagePath;
        }
    }

    private static function isValidImage($fileType) {
        //Array of valid image extensions
        $validExtensions = [
            'jpg',
            'jpeg',
            'png'
        ];

        return in_array($fileType, $validExtensions);
    }
}
