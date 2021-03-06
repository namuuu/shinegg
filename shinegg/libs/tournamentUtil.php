<?php

include_once "sqlUtil.php";
include_once "matchUtil.php";

// tournament status note
// 0: Not open to register
// 1: Open to register
// 2: Playing
// 3: Finished

function getTournaments() {
    $SQL = "SELECT * FROM tournaments ORDER BY debut_date ASC";

    return parcoursRs(SQLSelect($SQL));
}

// function getFutureTournaments() {
//     $SQL = "SELECT id, tournament_name, owner_id, tournament_picture, region, online, price, debut_date, max_participants FROM tournaments
//     WHERE debut_date > ";

//     return parcoursRs(SQLSelect($SQL));
// }

function getTournament($id) {
    $SQL="SELECT * FROM tournaments WHERE id='$id'";

	$Request = parcoursRs(SQLSelect($SQL))[0];
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect

    if (!$Request) {
		return false;
	} 

    return $Request;
}

function getTournamentEntrants($id) {
    $SQL = "SELECT * FROM tournaments
    JOIN entry ON tournaments.id = entry.tournament_id
    JOIN users ON entry.player_id = users.id
    WHERE tournaments.id = '$id'";

    return parcoursRs(SQLSelect($SQL));
}

function getTournamentEntrantsNb($id)
{
    $SQL = "SELECT count(*) FROM tournaments
    JOIN entry ON tournaments.id = entry.tournament_id
    WHERE tournaments.id = '$id'";

    return SQLGetChamp($SQL);
}

function getTournamentOwnerId($tourneyId)
{
    $SQL = "SELECT id FROM tournaments
            WHERE id = '$tourneyId'";
}

function getAllMatches() 
{
    $SQL = "SELECT * FROM matches";

    return parcoursRs(SQLSelect($SQL));
}

function getMatchesRound($tourneyId, $round)
{
    $SQL = "SELECT * FROM matches
            WHERE tournament_id='$tourneyId' AND location LIKE '$round%'";

    return parcoursRs(SQLSelect($SQL));
}

function getBaseTournamentNumber($participantsNb)
{
    $i = 0;
    while(pow(2, $i) < $participantsNb)
        $i++;

    return pow(2, $i);
}

function registerUser($tourneyId, $userId)
{

    $id = SQLGetChamp("SELECT MAX(entry_id)
                FROM entry");

    $id++;


    $sql = "INSERT INTO entry(entry_id, player_id, tournament_id)
	        VALUES ($id, '$userId', '$tourneyId');";
            
  	SQLInsert($sql);
}

function unregisterUser($tourneyId, $userId)
{
    $sql = "DELETE FROM entry
            WHERE tournament_id = '$tourneyId' AND player_id = '$userId'";

    SQLDelete($sql);
}

function isUserRegistered($tourneyId, $userId)
{
    $sql = "SELECT entry_id FROM entry
            WHERE tournament_id = '$tourneyId' AND player_id = '$userId'";

    $Request = SQLGetChamp($sql);

    if(!$Request)
        return false;
    return true;
}

function generateTournament($tourneyId)
{
    $tournament = getTournament($tourneyId);
    $base = getBaseTournamentNumber(getTournamentEntrantsNb($tourneyId));
    $size = $base / 2;

    for($i = 1; $i <= log($base, 2); ++$i)
    {
        for($j = 1; $j <= $size; ++$j)
        {
            createMatch($tourneyId, "WR" . $i . "-" . $j);
        }
        $size = $size / 2;
    }

    $i = 1;

    

    foreach(getTournamentEntrants($tourneyId) as $entrant) {
        $matchId = "SELECT match_id FROM matches WHERE tournament_id = '$tourneyId' AND location LIKE 'WR1-$i'";

        $matchId = SQLGetChamp($matchId);

        if($matchId) {
            enableMatch($matchId, $entrant["id"]);
            $i++;
        } else {
            $i = 1;
            $matchId = "SELECT match_id FROM matches WHERE tournament_id = '$tourneyId' AND location LIKE 'WR1-1'";

            $matchId = SQLGetChamp($matchId);
            enableMatch($matchId, $entrant["id"]);
            $i++;
        }
    }

    SQLUpdate("UPDATE tournaments
                SET status = 1
                WHERE id = $tourneyId");
}

function createTournament($name, $nbPart, $date, $image)
{
    $id = SQLGetChamp("SELECT MAX(id)
    FROM tournaments");

    $id++;

    $userId = getSession("id");

    $sql = "INSERT INTO tournaments(id, tournament_name, owner_id, tournament_picture, debut_date, max_participants)
	        VALUES ($id, '$name', '$userId', '$image', '$date', '$nbPart')";

    echo $sql . "<br>";
    
    SQLInsert($sql);
}


?>