<head>
    <title>Shine.GG - Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>


<div id="login">
    <h1 class="title">De retour ?</h1>

    <?php
        $result = getArg("result");
        switch($result) {
            case "success":
                echo "<div id=\"info\" class=\"info-success\"> Le compte a été créé avec succès ! </div>";
                break;
            case "error-existing":
                echo "<div id=\"info\" class=\"info-alert\"> Ce compte existe déjà ! </div>";
                break;
            case "error-login":
                echo "<div id=\"info\" class=\"info-alert\"> Les identifiants sont invalides ! </div>";
                break;
        }
    ?>

    <form action="connexionControler.php" method="GET">  

    <label for="id" class="header-input">Identifiant</label> <br>
        <input name="id" id="id" type="text" class="text-input">

        <label for="password" class="header-input">Mot de passe</label> <br>
        <input name="password" id="password" type="password"  class="text-input"> <br>

        <input type="submit" name="action" id="button-login" class="button-input" value="Se connecter">
    </form>
</div>

<div id="register">
    <h1 class="title" style="color: white;">Nouveau ici ?</h1>
    <h2 class="desc" style="color: white;"> Rejoins la communauté, et <br> participe à de nombreux tournois </h2>
    <a id="button-register" class="button-input" href="index.php?view=account-register"> S'inscrire </a>
</div>

<img id="fox-image" src="img/fox_login.png" alt="Fox Victory Pose">

// 