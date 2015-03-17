<?php

class db
{
    public static $con;

    public static function con()
    {
        self::$con = mysqli_connect('localhost', 'root', '', 'cms');
    }
}