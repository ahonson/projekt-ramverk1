<?php

use artes\Login\Login;

/**
 * Supply the basis for the navbar as an array.
 */
$navbarloggedout = [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Q&A",
            "url" => "question",
            "title" => "Samtliga frågor"
        ],
        [
            "text" => "Tags",
            "url" => "tag",
            "title" => "Info om taggarna.",
        ],
        [
            "text" => "Users",
            "url" => "user",
            "title" => "Info om användarna",
        ],
        [
            "text" => "About",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Login",
            "url" => "login",
            "title" => "Login.",
        ],
    ],
];

$navbarloggedin = [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Profile",
            "url" => "profile",
            "title" => "Din profil.",
        ],
        [
            "text" => "Q&A",
            "url" => "question",
            "title" => "Samtliga frågor"
        ],
        [
            "text" => "Tags",
            "url" => "tag",
            "title" => "Info om taggarna.",
        ],
        [
            "text" => "Users",
            "url" => "user",
            "title" => "Info om användarna",
        ],
        [
            "text" => "About",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Logout",
            "url" => "login",
            "title" => "Login.",
        ],
    ],
];

// $session->get("userLoginStatus")->isLoggedIn()

if (!isset($_SESSION["userLoginStatus"])) {
    $_SESSION["userLoginStatus"] = new Login();
}

$loggedin = $_SESSION["userLoginStatus"]->isLoggedIn() ?? null;

if ($loggedin) {
    return $navbarloggedin;
}
return $navbarloggedout;
