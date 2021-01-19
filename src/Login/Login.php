<?php

namespace artes\Login;

/**
 * A class for verification and login status.
 */
class Login
{
    private $loggedIn;

    /**
     * Constructor to initiate a login object
     *
     */

    public function __construct()
    {
        $this->loggedIn = false;
    }



    /**
     * verify login data
     * @param object $data
     * @return bool
     */
    public function loginSuccess($data)
    {
        $users = $data["users"];
        $email = $data["email"];
        $password = $data["password"];
        foreach ($users as $user) {
            if ($user->email === $email && $user->password === md5($password)) {
                $this->loggedIn = true;
                return true;
            }
        }
        return false;
    }


    /**
     * return login status
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->loggedIn;
    }


    /**
     * set login status to false
     * @return void
     */
    public function logout()
    {
        $this->loggedIn = false;
    }
}
