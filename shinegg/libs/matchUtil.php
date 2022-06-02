<?php

include_once "sqlUtil.php";
include_once "userUtil.php";

// Permet d'afficher une preview d'un match, c'est à dire la petite bannière depuis l'affichage du bracket.
function matchPreview($tournamentId, $matchId)
{ 
    $match = getMatch($matchId);
    $matchFinished = isMatchFinished($matchId);
    $matchFilled = isMatchFilled($matchId);

    if(!$matchFinished && $matchFilled)
        echo "<a href=\"index.php?view=match-view&tournamentId=$tournamentId&matchId=$matchId\">";
    echo "<div class=\"matchPreview\">";
    echo "<div>";
    echo "<div class=\"matchName\">" . getUserName($match["player1_id"]) . "</div>";
    echo "<div class=\"matchScore\">". $match["player1_score"] . "</div>";
    echo "</div>";
    echo "<div>";
    echo "<div class=\"matchName\">" . getUserName($match["player2_id"]) . "</div>";
    echo "<div class=\"matchScore\">". $match["player2_score"] ."</div>";
    echo "</div>";
    echo "</div>";
    if(!$matchFinished && $matchFilled)
        echo "</a>";
}









// TODO : tester
function createMatch($tourneyId, $location) 
{
    $id = SQLGetChamp("SELECT MAX(match_id)
                      FROM matches");

	$id++;

    $sql = "INSERT INTO matches(match_id, tournament_id, location, score_max)
	        VALUES ('$id', '$tourneyId', '$location', 3);";

    SQLInsert($sql);

    return parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$id'"))[0];
}

// TODO : tester
function enableMatch($matchId, $playerId)
{
    $match = parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];

    if($match["player1_id"] == $playerId || $match["player2_id"] == $playerId) {
        return $match;
    }

    $check = "SELECT player1_id FROM matches WHERE match_id = '$matchId'";

    $check = SQLGetChamp($check);

    if(!$check) {
        $sql = "UPDATE matches
                SET player1_id = '$playerId', player1_score = 0, player1_agreement = 0 
                WHERE match_id = '$matchId'";

        SQLUpdate($sql);
    } else {
        $sql = "UPDATE matches
                SET player2_id = '$playerId', player2_score = 0, player2_agreement = 0 
                WHERE match_id = '$matchId'";

        SQLUpdate($sql);
    }

    return parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];
}

function getMatches($tourneyId)
{
    $SQL = "SELECT * FROM matches WHERE tournament_id=$tourneyId";

    return parcoursRs(SQLSelect($SQL));
}

function getMatch($matchId)
{
    $SQL = "SELECT * FROM matches WHERE match_id = $matchId";

    return parcoursRs(SQLSelect($SQL))[0];
}

function winMatch1($tournamentId, $matchId)
{
    $match = getMatch($matchId);
    $round = substr($match["location"], 2, 1);
    $round++;

    $number = substr($match["location"], -1);
    $number = $number / 2 + ($number%2)*0.5;

    $SQL = "SELECT match_id FROM matches 
    WHERE location='WR$round-$number' 
    AND tournament_id = '$tournamentId'";

    $newMatchId = SQLGetChamp($SQL);


    $SQL = "SELECT player1_id FROM matches WHERE match_id='$matchId'";

    $playerId = SQLGetChamp($SQL);

    enableMatch($newMatchId, $playerId);
}

function winMatch2($tournamentId, $matchId)
{
    $match = getMatch($matchId);
    $round = substr($match["location"], 2, 1);
    $round++;

    $number = substr($match["location"], -1);
    $number = $number / 2 + ($number%2)*0.5;

    $SQL = "SELECT match_id FROM matches 
    WHERE location='WR$round-$number' 
    AND tournament_id = '$tournamentId'";

    $newMatchId = SQLGetChamp($SQL);


    $SQL = "SELECT player2_id FROM matches WHERE match_id='$matchId'";

    $playerId = SQLGetChamp($SQL);

    enableMatch($newMatchId, $playerId);
}

function agree($matchId, $aggreeingPlayer, $agreement)
{
    $SQL = "UPDATE matches
            SET player" . $aggreeingPlayer . "_agreement = $agreement WHERE match_id = '$matchId'";

    SQLUpdate($SQL);
}

// Update le score si les deux joueurs sont d'accord
function matchAgreeCheck($matchId)
{
    $match = parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];

    echo $match["player1_agreement"] . " " . $match["player2_agreement"] . "<br>";

    // Si les deux joueurs sont d'accords pour que 1 gagne
    if($match["player1_agreement"] == 1 && $match["player2_agreement"] == 1) {

        echo "Increase player1 score <br>";

        // Ajoute 1 au score de joueur 1
        $newScore = $match["player1_score"] + 1;

        SQLUpdate("UPDATE matches SET player1_score = ". $newScore ." WHERE match_id = '$matchId'");

        // Reset les accords des deux joueurs
        SQLUpdate("UPDATE matches SET player1_agreement = 0 WHERE match_id = '$matchId'");
        SQLUpdate("UPDATE matches SET player2_agreement = 0 WHERE match_id = '$matchId'");
    }

    // Si les deux joueurs sont d'accords pour que 2 gagne
    if($match["player1_agreement"] == 2 && $match["player2_agreement"] == 2) {

        // Ajoute 1 au score de joueur 2
        $newScore = $match["player2_score"] + 1;

        SQLUpdate("UPDATE matches SET player2_score = ". $newScore ." WHERE match_id = '$matchId'");

        // Reset les accords des deux joueurs
        SQLUpdate("UPDATE matches SET player1_agreement = 0 WHERE match_id = '$matchId'");
        SQLUpdate("UPDATE matches SET player2_agreement = 0 WHERE match_id = '$matchId'");
    }

}

// If either player has the max_score, makes him win
function maxScoreCheck($matchId)
{
    $match = parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];

    if($match["player1_score"] == $match["score_max"]) {
        winMatch1($match["tournament_id"], $matchId);
    }

    if($match["player2_score"] == $match["score_max"]) {
        winMatch2($match["tournament_id"], $matchId);
    }
}

// check if a players has reached the max_score
function isMatchFinished($matchId)
{
    $match = parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];

    if($match["player1_score"] == $match["score_max"]) {
        return true;
    }

    if($match["player2_score"] == $match["score_max"]) {
        return true;
    }

    return false;
}

// Check if there's two players
function isMatchFilled($matchId)
{
    $match = parcoursRs(SQLSelect("SELECT * FROM matches WHERE match_id = '$matchId'"))[0];

    if($match["player1_id"] && $match["player2_id"]) {
        return true;
    }

    return false;
}

?>