<?php

class user
{
    public static function generateSalt()
    {
        return md5(microtime());
    }

    public static function generatePassword($salt, $password)
    {
        return sha1($salt . $password . 'TEHIBFE234_32ccdekIJ');
    }

    public static function loggedIn()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            return true;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        unset($_SESSION['loggedIn']);
        unset($_SESSION['username']);
        unset($_SESSION['admin']);
        header('Location: login.php');
        exit;
    }
}
