<?php

include_once "libs/tournamentUtil.php";
include_once "libs/matchUtil.php";
include_once "libs/userUtil.php";
include_once "libs/systemUtil.php";

$tournamentId = getArg("tournamentId");
$matchId = getArg("matchId");

if(!$tournamentId || !$matchId) {
    redirect(dirname($_SERVER["PHP_SELF"]) . "/index.php");
}

$matchFinished = isMatchFinished($matchId);
$matchFilled = isMatchFilled($matchId);

if($matchFinished || !$matchFilled)
    redirect(dirname($_SERVER["PHP_SELF"]) . "/index.php?view=tournament-view&tournamentId=" . $tournamentId);

$tournament  = getTournament($tournamentId);
$match = getMatch($matchId);

?>

<head>
    <title>Shine.GG - match</title>
    <link rel="stylesheet" type="text/css" href="css/match.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400&display=swap" rel="stylesheet">
</head>

<!-- <a href="" id="return-button"> Retour </a> -->

<form action="controller/tournamentController.php">
<div id="match-container">
   

    <?php echo "<input type=\"hidden\" name=\"matchId\"  value=\"$matchId\">" ?>
    <?php echo "<input type=\"hidden\" name=\"tournamentId\"  value=\"$tournamentId\">" ?>

    <?php
        $firstPlayer = getUserData($match["player1_id"]);
        $secondPlayer = getUserData($match["player2_id"]);

        echo "<div class=\"card-first\">";
        echo    "<span class=\"card-score\">" . $match["player1_score"] . "</span>";
        echo    "<span class=\"card-name\">" . $firstPlayer["name"] . "</span>";
        // echo "<input type=\"submit\" name=\"action\" value=\"Victoire 1\">";
        if(getSession("id") == $firstPlayer["id"] || getSession("id") == $secondPlayer["id"]) {
            echo "<input class=\"agreement\" type=\"submit\" name=\"action\" value=\"Accorder la victoire au joueur 1\">";
        }
        if($match["player1_agreement"] == 1) {
            echo "<p> Accord du joueur 1 </p>";
        }
        if($match["player2_agreement"] == 1) {
            echo "<p> Accord du joueur 2 </p>";
        }
        echo "</div>";


        echo "<div class=\"card-second\">";
        echo    "<span class=\"card-score\">" . $match["player2_score"] . "</span>";
        echo    "<span class=\"card-name\">" . $secondPlayer["name"] . "</span>";
        // echo "<input type=\"submit\" name=\"action\" value=\"Victoire 2\">";
        if(getSession("id") == $firstPlayer["id"] || getSession("id") == $secondPlayer["id"]) {
            echo "<input class=\"agreement\" type=\"submit\" name=\"action\" value=\"Accorder la victoire au joueur 2\">";
        }if($match["player1_agreement"] == 2) {
            echo "<p> Accord du joueur 1 </p>";
        }
        if($match["player2_agreement"] == 2) {
            echo "<p> Accord du joueur 2 </p>";
        }
        echo "</div>";
    ?>

    <?php
        // echo "id:" . $match["player1_id"] . " agree:" . $match["player1_agreement"] . " score:" . $match["player1_score"];
        // echo "<br>";
        // echo "id:" . $match["player1_id"] . " agree:" . $match["player1_agreement"] . " score:" . $match["player1_score"];
    ?>


</div>
</form>