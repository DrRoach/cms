<?php

namespace cms;

class Api
{
    public static function test()
    {
        echo 'Connected to cms Api';
    }

    public static function getPosts()
    {
        require_once 'db.php';
        is_null(db::$con) ? db::con() : null;

        //Get all of the posts
        $posts = mysqli_query(db::$con, "SELECT * FROM posts");
        //Turn posts into a array
        $return = [];
        while($row = mysqli_fetch_assoc($posts)) {
            $return[] = $row;
        }
        return $return;
    }

    public static function getPost($params)
    {
        require_once 'db.php';
        is_null(db::$con) ? db::con() : null;

        $where = self::generateWhere($params);
        $post = mysqli_query(db::$con, "SELECT * FROM posts " . $where);
        $post = mysqli_fetch_assoc($post);
        is_null($post) ? $post = [] : null;

        return $post;
    }

    public static function isPost($params)
    {
        require_once 'db.php';
        is_null(db::$con) ? db::con() : null;

        $where = self::generateWhere($params);
        $post = mysqli_query(db::$con, "SELECT id FROM posts " . $where);
        $post = mysqli_fetch_assoc($post);

        return is_null($post) ? false : true;
    }

    private static function generateWhere($params)
    {
        $count = 0;
        $where = 'WHERE ';
        foreach($params as $key => $param) {
            //This isn't the first param, add AND
            if($count) {
                $where .= ' AND ';
            }
            $where .= $key . '="' . $param . '"';
            $count++;
        }
        return $where;
    }
}