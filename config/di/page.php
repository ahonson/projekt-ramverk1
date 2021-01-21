<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "page" => [
            "shared" => true,
            "callback" => function () {
                $page = new \Anax\Page\Page();
                $page->setDI($this);

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("page.php");
                $file = $config["file"] ?? null;
                $navbaritems = $config["config"]["views"][2]["data"]["navbarConfig"]["items"];
                array_shift($navbaritems);
                $navbarcount = count($navbaritems);
                if (isset($_SERVER['REQUEST_URI'])) {
                    $currenturl = $_SERVER['REQUEST_URI'];
                } else {
                    $currenturl = "blablabla"; // for the sake of the tests
                }
                $flag = false;
                for ($i=0; $i < $navbarcount; $i++) {
                    if (strpos($currenturl, "htdocs/" . $navbaritems[$i]["url"])) {
                        $config["config"]["views"][2]["data"]["navbarConfig"]["items"][$i + 1]["class"] = "selectednavbar";
                        $flag = true;
                    } else {
                        $config["config"]["views"][2]["data"]["navbarConfig"]["items"][$i + 1]["class"] = "";
                    }
                }
                if (!$flag) {
                    $config["config"]["views"][2]["data"]["navbarConfig"]["items"][0]["class"] = "selectednavbar";
                }

                // Add all views from configuration
                $views = $config["config"]["views"] ?? [];
                foreach ($views as $view) {
                    $page->add($view);
                }

                $layout = $config["config"]["layout"] ?? null;
                if (!$layout) {
                    throw new Exception("Missing configuration for layout in file '$file', its needed.");
                }
                $page->addLayout($layout);
                return $page;
            }
        ],
    ],
];
