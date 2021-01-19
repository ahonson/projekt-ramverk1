<?php

namespace Anax\Controller;
namespace artes\Profile;

use Anax\Route\Exception\NotFoundException;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Createstuff\Createstuff;
use artes\Getstuff\Getstuff;
use artes\Updatestuff\Updatestuff;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class ProfileController implements ContainerInjectableInterface
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
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];

        $page = $this->di->get("page");
        $response = $this->di->get("response");
        $session = $this->di->get("session");

        if (!$session->get("userLoginStatus")->isLoggedIn()) {
            return $response->redirect("login");
        }

        $loginid = $session->get("loginid");
        $updatemsg = $session->get("updatemsg") ? $session->get("updatemsg") : "";
        $email = $session->get("email");
        $getstuff = new Getstuff($this->di);
        $user = $getstuff->getUserExtra($email, "email");
        $userdata = [
            "user" => $user,
            "loginid" => $loginid,
            "updatemsg" => $updatemsg
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("profile/profile", $userdata);
        return $page->render([
            "title" => "User profile",
        ]);
    }

    public function indexActionPost($mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $request = $this->di->request;
        $pass = trim($request->getPost("currentpass", null));
        $pass1 = trim($request->getPost("newpass1", null));
        $pass2 = trim($request->getPost("newpass2", null));

        $session = $this->di->get("session");
        $email = $session->get("email");
        $getstuff = new Getstuff($this->di);
        $user = $getstuff->getUserExtra($email, "email");

        if ($user->email === $email && $this->checkPasswords($pass1, $pass2)) {
            $updatestuff = new Updatestuff($this->di);
            $updatestuff->editUser($user->id, $pass1);
        } else {
            $session->set("updatemsg", "Something went wrong. Try again.");
        }

        $response = $this->di->get("response");
        return $response->redirect("profile");
        // var_dump($email);
        // var_dump($name);
        // var_dump($pass);
        // var_dump($pass1);
        // var_dump($pass2);
        // die("---------------------");
    }

    public function checkPasswords($pass1, $pass2) : bool
    {
        if ($pass1 === $pass2 && strlen($pass1) > 5 && strtolower($pass1) !== $pass1 && preg_match('~[0-9]+~', $pass1)) {
            return true;
        }
        return false;
    }
}
