<?php
    include_once('libs/userUtil.php');
?>

<head>
    <title>Shine.GG - AccountEdition</title>
    <link rel="stylesheet" type="text/css" href="css/edit.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<div id="titre">
<h1> Modifier ses informations</h1>

<form action="editControler.php" method="GET">  

    <div class="red">
    <label for="pseudo">Pseudonyme</label> 
    </div>
    <input name="pseudo" type="text"> 


    <div class="red">
    <label for="Team">Team</label> 
    </div>
    <input name="team" type="text">


    <div class="red">
    <label for="Main">Personnage principal</label> 
    </div>
    <input name="main" type="text">


    <div class="red">
    <label for="pdp">Photo de profil</label> 
    </div>
    <input name="pdp" type="text"> 

    <div class="red">
    <label for="password">Mot de passe</label>
    </div>
    <input id="elmdp" name="password" type="password">
    <div class="red">
    <label for="lastpassword">Entrez l'ancien mot de passe pour changer</label>
    </div>
    <input name="lastpassword" type="password">

    <div class="red">
    <label for="bio">Biographie</label>
    </div>
    <input name="bio" type="text">

    <input type="submit" name="action" value="Editer le profil">
</form>