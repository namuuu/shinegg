<?php

include_once("libs/tournamentUtil.php");
include_once("libs/matchUtil.php");

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
    <link rel="stylesheet" type="text/css" href="css/tourney.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<div id="tournament-header">
<?php 
echo "<img src=\"". $tournament["tournament_picture"] ."\" alt=\"tournament_picture\">";
echo "<h1>" . $tournament["tournament_name"] . "</h1>";
?>
</div>





<?php
if(getSession("id")) {
    echo "<form style=\"display:inline; margin: 1% 0 3% 0\" action=\"controller/tournamentController.php\">";
    echo "<input type=\"hidden\" name=\"tournamentId\" value=\"$tournamentId\">";
    echo "<input type=\"hidden\" name=\"userId\" value=\"" . getSession("id") . "\"\">";
    if(isUserRegistered($tournamentId, getSession("id"))) {
        if($tournament["status"] == 0)
            echo "<input id=\"button\" style=\"margin: 0 1% 0 2%\" name=\"action\" type=\"submit\" value=\"Quitter le tournoi\">";
    } else {
        if($tournament["status"] == 0)
            echo "<input id=\"button\" style=\"margin: 0 1% 0 2%\" name=\"action\" type=\"submit\" value=\"S'enregistrer\">";
    }
    
    echo "</form>";
}
if(getSession("id") == $tournament["owner_id"] && $tournament["status"] == 0) {
    echo "<form style=\"display:inline; margin: 1% 0 3% 0\" action=\"controller/tournamentController.php\">";
    echo "<input type=\"hidden\" name=\"tournamentId\" value=\"$tournamentId\">";
    echo "<input id=\"button\" name=\"action\" style=\"margin: 0 1% 0 2%\" type=\"submit\" value=\"Lancer le tournoi\">";
    echo "</form>";
}


if($tournament["status"] != 0) {
    $entrantsNb = getTournamentEntrantsNb($tournament["id"]);
    $base = getBaseTournamentNumber($entrantsNb);

    

    echo "<div id=\"bracket\">";
    echo "<div style=\"display:inline-block; background-color: #C93246; width: 10px; height: auto; margin-right: 10px\"></div>";
    for($i = 1; $i <= log($base, 2); ++$i)
    {
        echo "<div>";
        foreach(getMatchesRound($tournamentId, "WR" . $i) as $match) {
            matchPreview($match["match_id"]);
        }
        echo "</div>";
    }
    echo "</div>";
}

?>
