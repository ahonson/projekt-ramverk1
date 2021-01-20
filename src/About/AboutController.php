<?php

namespace Anax\Controller;
namespace artes\About;

use Anax\Route\Exception\NotFoundException;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AboutController implements ContainerInjectableInterface
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
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("about/aboutside", $data, "sidebar-right");
        $page->add("about/about");

        return $page->render([
            "title" => "A collection of questions",
        ]);
    }
}
