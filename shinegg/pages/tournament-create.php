<head>
    <title>Shine.GG - Register</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<div id="form">
<h1> Créer un serveur </h1>

<form action="controller/tournamentController.php" method="GET">  

    <label for="name">Nom du tournoi</label> <br>
    <input name="name" id="name" type="text"> <br>

    <label for="numberPlayers">Nombre de participants</label> <br>
    <input name="numberPlayers" id="numberPlayers" type="number"> <br>

    <label for="date">Date</label> <br>
    <input name="date" id="date" type="date"> <br>

    <label for="image">Image du tournoi</label> <br>
    <input name="image" id="image" type="text"> <br>

    <input type="submit" name="action" id="button-register" value="Créer un tournoi">
</form>

<img id="sheik_img" src="img/sheik_register.png" alt="Sheik Register">
<img id="pichu_img" src="img/pichu_taunt.png" alt="Pichu Register">
</div>