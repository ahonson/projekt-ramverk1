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
        $email = $session->get("email");
        $getstuff = new Getstuff($this->di);
        $user = $getstuff->getUserExtra($email, "email");
        $userdata = [
            "user" => $user,
            "loginid" => $loginid
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("profile/profile", $userdata);
        return $page->render([
            "title" => "User profile",
        ]);
    }
}
