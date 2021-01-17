<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

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
            "text" => "Login",
            "url" => "login",
            "title" => "Login.",
        ],
    ],
];
