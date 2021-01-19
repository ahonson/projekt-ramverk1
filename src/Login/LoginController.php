<?php

namespace Anax\Controller;
namespace artes\Login;

use Anax\Route\Exception\NotFoundException;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;
use artes\Createstuff\Createstuff;
use artes\Updatestuff\Updatestuff;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class LoginController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet($mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        if ($session->get("userLoginStatus")->isLoggedIn()) {
            $session->get("userLoginStatus")->logout();
            return $response->redirect("");
        }

        if ($session->get("userLoginStatus") === null) {
            $session->set("userLoginStatus", new Login());
        }

        // $success = $session->get("success") ? $session->get("success") : "";
        // $loginemail = $success ? $session->get("email") : "";
        // $warning = $session->get("warning") ? $session->get("warning") : "";
        // $username = $warning ? $session->get("username") : "";
        // $email = $warning ? $session->get("email") : "";
        // $failedlogin = $request->getPost("failedlogin") ? $request->getPost("failedlogin") : "";

        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $logindata = $this->getLogindata($session, $request);
        $session->set("warning", "");
        $session->set("success", "");
        $session->set("username", "");
        $session->set("email", "");
        // $logindata = [
        //     "warning" => $warning,
        //     "success" => $success,
        //     "email" => $email,
        //     "username" => $username,
        //     "loginemail" => $loginemail,
        //     "failedlogin" => $failedlogin
        // ];

        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("login/login", $logindata);

        return $page->render([
            "title" => "A collection of questions",
        ]);
    }

    public function getLogindata($session, $request)
    {
        $success = $session->get("success") ? $session->get("success") : "";
        $loginemail = $success ? $session->get("email") : "";
        $warning = $session->get("warning") ? $session->get("warning") : "";
        $username = $warning ? $session->get("username") : "";
        $email = $warning ? $session->get("email") : "";
        $failedlogin = $request->getPost("failedlogin") ? $request->getPost("failedlogin") : "";

        $logindata = [
            "success" => $success,
            "warning" => $warning,
            "email" => $email,
            "username" => $username,
            "loginemail" => $loginemail,
            "failedlogin" => $failedlogin
        ];

        return $logindata;
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexActionPost() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");

        if ($request->getPost("register")) {
            $password = trim($request->getPost("password1"));
            $password1 = trim($request->getPost("password2"));
            $name = trim($request->getPost("username"));
            $email = trim($request->getPost("email"));
            $warning = $this->errMsg($name, $email, $password, $password1);
            $session->set("email", $email);
            if (!$warning) {
                $createstuff = new Createstuff($this->di);
                $createstuff->saveUser($name, $email, $password);
                $success = "Ditt konto är skapat. Nu kan du logga in.";
                $session->set("success", $success);
            } else {
                $session->set("warning", $warning);
                $session->set("username", $name);
            }
            return $response->redirect("login");
        }

        // elseif ($request->getPost("login"))
        $password = $request->getPost("password");
        $email = $request->getPost("email");
        $getstuff = new Getstuff($this->di);
        $users = $getstuff->getUsers();
        $data = [
            "users" => $users,
            "email" => $email,
            "password" => $password
        ];

        if ($session->get("userLoginStatus")->loginSuccess($data)) {
            $session->set("email", $email);
            return $response->redirect("profile");
        }

        // var_dump($data);
        // die("---------------");
        $data = [
            "failedlogin" => "We did not recognize your sign in details.",
            "loginemail" => $email,
            "email" => "",
            "success" => "",
            "warning" => "",
            "username" => ""
        ];

        // $page->add("anax/v2/image/default", $data, "flash");
        $page->add("login/login", $data);

        return $page->render([
            "title" => "Min sida",
        ]);
    }

    public function errMsg($name, $email, $password, $password1, $mydi=null) : string
    {
        if ($mydi) {
            $this->di = $mydi;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid e-mail";
        } elseif (!$this->availableEmail($email)) {
            return "This e-mail address is already taken.";
        } elseif (!$name) {
            return "Invalid username";
        } elseif ($password !== $password1) {
            return "The two passwords have to match.";
        } elseif (!preg_match('~[0-9]+~', $password) || strtolower($password) === $password) {
            return "The password has to contain at least 1 numeric, 1 uppercase and 1 lowercase character.";
        } elseif (strlen($password) < 6) {
            return "The password is too short";
        }
        return "";
    }

    public function availableEmail($email) : bool
    {
        $getstuff = new Getstuff($this->di);
        $users = $getstuff->getUsers();
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]->email == $email) {
                return false;
            }
        }
        return true;
    }
}
