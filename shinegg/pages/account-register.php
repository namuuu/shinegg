<head>
    <title>Shine.GG - Register</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<div id="form">
<h1> Rejoins-nous !</h1>

<form action="controller/connexionController.php" method="GET">  

    <label for="id">Nouvel identifiant</label> <br>
    <input name="id" id="id" type="text"> <br>

    <label for="password">Votre mot de passe</label> <br>
    <input name="password" id="password" type="password"> <br>

    <input type="submit" name="action" id="button-register" value="S'inscrire">
</form>

<img id="sheik_img" src="img/sheik_register.png" alt="Sheik Register">
<img id="pichu_img" src="img/pichu_taunt.png" alt="Pichu Register">
</div>