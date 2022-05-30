<?php

    session_start();

    include_once "libs/systemUtil.php";

    // Tries to get the selected page.
    $view = getArg("view");

    // If there's no page selected, redirects to the main page.
    if (!$view) 
        $view = "home"; 

    // Importe le header
    include "pages/header.php";

    if (file_exists("pages/$view.php")) {
        include("pages/$view.php");
    } else {
        include("pages/home.php");
    }
    
?>