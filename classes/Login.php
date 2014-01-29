<?php

//Handles the user login and logout process
class Login
{
    //Database connection object
    private $db_connection = null;
    //Array of error messages
    public $errors = array();
    //Collection of success messages
    public $messages = array();

    //Function starts whenever a login class object is created
    public function __construct()
    {
        //Creates a session
        session_start();

        //If the user selects logout option
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        //If users submits login form which uses POST
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    //Use the POST data from the login form to login
    private function dologinWithPostData()
    {
        //Check the login form details
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            //Create a database connection, using constant DB connection file and check for errors
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            //If there are no errors then database connected
            if (!$this->db_connection->connect_errno) {
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                //Get the information from the database for the selected user
                //User can login using their username or email
                $sql = "SELECT user_name, user_email, user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                //If the user exists in the database
                if ($result_of_login_check->num_rows == 1) {

                    //Get the results
                    $result_row = $result_of_login_check->fetch_object();

                    //Function to check if password provided fits the hash of the user's password and create session
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    //Logout function, delete the users session and notify the user
    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";

    }

    //Return the users current login state
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}