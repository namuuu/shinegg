<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<head>
    <title>Shine.GG</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo_shinegg_blanc.png">
</head>

<div id="header-banner">
    <ul id="header-list-left">
        <li> <a href="index.php?view=accueil"> Home </a> </li>
        <li> <a href="index.php?view=tournament-list" style="font-size: 2.5vh; padding-top: 0;"> Liste des <br> tournois</a> </li>
    </ul>

    <img id="header-image" src="img/logo_shinegg_blanc.png" alt="Logo ShineGG">

    <ul id="header-list-right">
        <?php
            if(getSession("id")) {
                echo "<li> <form action=\"controller/connexionController.php\"> <input type=\"submit\" name=\"action\" value=\"Se déconnecter\"> </form></li>";
                echo "<li> <a href=\"index.php?view=account-info\"> Mon compte </a> </li>";
            } else {
                echo "<li> <a href=\"index.php?view=account-login\" style=\"font-size: 2.5vh; padding-top: 0;\"> S'inscrire <br> Se connecter </a> </li>";
            }
        ?>
        
        
    </ul>
</div>