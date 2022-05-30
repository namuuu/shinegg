<?php

include_once "sqlUtil.php";

function getTournaments() {
    $SQL = "SELECT id, tournament_name, owner_id, tournament_picture, region, online, price, debut_date, max_participants FROM tournaments";

    return parcoursRs(SQLSelect($SQL));
}

// function getFutureTournaments() {
//     $SQL = "SELECT id, tournament_name, owner_id, tournament_picture, region, online, price, debut_date, max_participants FROM tournaments
//     WHERE debut_date > ";

//     return parcoursRs(SQLSelect($SQL));
// }

function getTournament($id) {
    $SQL="SELECT id, tournament_name AS 'name', owner_id, tournament_picture AS 'picture', region, online, price, debut_date, max_participants FROM tournaments WHERE id='$id'";

	$Request = parcoursRs(SQLSelect($SQL))[0];
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect

    if (!$Request) {
		return false;
	} 

    return $Request;
}

function getTournamentEntrants($id) {
    $SQL = "SELECT users.id, users.name, users.region, users.profile_picture FROM tournaments
    JOIN entry ON tournaments.tournament_id = entry.tournament_id
    JOIN users ON entry.player_id = users.id";

    return parcoursRs(SQLSelect($SQL));
}

function getAllMatches() {
    $SQL = "SELECT * FROM matches";

    return parcoursRs(SQLSelect($SQL));
}


?>