<?php

include_once("libs/tournamentUtil.php");

$view = getArg("view");

$tournamentId = getArg("tournamentId");

if(!$tournamentId)
    redirect(dirname($_SERVER["PHP_SELF"]) . "/index.php");

$tournament = getTournament($tournamentId);

if(!$tournament)
    redirect(dirname($_SERVER["PHP_SELF"]) . "/index.php");
?>

<head>
    <?php echo "<title>Shine.GG - ". $tournament["name"] ."</title>" ?>
    <link rel="stylesheet" type="text/css" href="css/tournament-list.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<?php echo $tournament["name"]; ?>