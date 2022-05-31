<?php

include_once "sqlUtil.php";
include_once "userUtil.php";

// Permet d'afficher une preview d'un match, c'est à dire la petite bannière depuis l'affichage du bracket.
function matchPreview($matchId)
{ 
    $match = getMatch($matchId);

    echo "<div class=\"matchPreview\">";
    echo "<div>";
    echo "<div class=\"matchName\">" . getUserName($match["player1_id"]) . "</div>";
    echo "<div class=\"matchScore\">". $match["player1_score"] ."</div>";
    echo "</div>";
    echo "<div>";
    echo "<div class=\"matchName\">" . getUserName($match["player2_id"]) . "</div>";
    echo "<div class=\"matchScore\">". $match["player2_score"] ."</div>";
    echo "</div>";
    echo "</div>";
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
    $check = "SELECT player1_id FROM matches WHERE match_id = '$playerId'";

    $check = SQLGetChamp($check);

    if(!check) {
        $sql = "UPDATE matches
                SET player1_id = '$playerId', player1_score = 0, player1_agreement = 0, 
                    -- player2_id = '$player2Id', player2_score = 0, player2_agreement = 0
                WHERE match_id = '$matchId'";

        SQLUpdate($sql);
    } else {
        $sql = "UPDATE matches
                SET player2_id = '$playerId', player2_score = 0, player2_agreement = 0, 
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


?>