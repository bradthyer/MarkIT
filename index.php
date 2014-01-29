<?php

/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 * For more versions (one-file, advanced, framework-like) visit http://www.php-login.net
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

//Check minimum version of PHP
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}

//Include database connection file
require_once("config/db.php");

//Load the login class
require_once("classes/Login.php");

//Create a login object, this handles all the entire login process
$login = new Login();

//Check if user is logged in
if ($login->isUserLoggedIn() == true) {
    //Allow the user to access the site
    include("views/logged_in.php");
} else {
    //If user is not logged in, redirect to login page
    include("views/not_logged_in.php");
}
