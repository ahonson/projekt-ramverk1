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
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Q&A",
            "url" => "question",
            "title" => "Samtliga frågor"
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Taggar",
            "url" => "tag",
            "title" => "Info om taggarna.",
        ],
        [
            "text" => "Användare",
            "url" => "user",
            "title" => "Info om användarna",
        ],
    ],
];
