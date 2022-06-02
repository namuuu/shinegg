<?php

include_once ("sqlUtil.php");

function connectUser($name, $password) 
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT name, id FROM users WHERE name='$name' AND password='$password'";

	$Request = parcoursRs(SQLSelect($SQL))[0];
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect

	if (!$Request) {
		return false;
	} 

	// echo $Request["name"];

	$_SESSION["id"] = $Request["id"];
	$_SESSION["login"] = $Request["name"];
	$_SESSION["connecte"] = true;
	$_SESSION["heureConnexion"] = date("H:i:s");

	return true;
}

function createUser($name, $password)
{
	$check = SQLGetChamp("SELECT id
                      FROM users
                      WHERE name = '$name' AND password = '$password';");

	if($check)
		return false;

	$id = SQLGetChamp("SELECT MAX(id)
                      FROM users");

	$id++;

	// crée une nouvelle conversation et renvoie son identifiant
	$sql = "INSERT INTO users(id, name, password)
	        VALUES ($id, '$name', '$password');";
  	SQLInsert($sql);

  	return SQLGetChamp("SELECT id
                      FROM users
                      WHERE name = '$name';");
}

function getUserData($id) 
{
    $SQL="SELECT * FROM users WHERE id='$id'";

    $Request = parcoursRs(SQLSelect($SQL))[0];
    // si on avait besoin de plus d'un champ
    // on aurait du utiliser SQLSelect

    if (!$Request) {
        return false;
    } 

    return $Request;
}

function getUserName($id)
{
	$SQL="SELECT name FROM users WHERE id='$id'";

    return SQLGetChamp($SQL);
}

function mostRecentMatch($id) {
	
	$SQL="SELECT player1_score, player2_score, player1_id, player2_id, tournament_id 
	FROM matches
	WHERE player1_id='$id' OR player2_id='$id'
	ORDER BY match_id DESC";

	$Request = parcoursRs(SQLSelect($SQL))[0];

	if (!$Request) {
		return false;
	} 

	return $Request;
	
}

function getUserMatches1($id) {
	
	$SQL="SELECT player1_score, score_max
	FROM matches
	WHERE player1_id='$id'
	ORDER BY match_id DESC";

	$Request = parcoursRs(SQLSelect($SQL));

	if (!$Request) {
		return false;
	} 

	return $Request;
}

function getUserMatches2($id) {
	
	$SQL="SELECT player2_score, score_max
	FROM matches
	WHERE player2_id='$id'
	ORDER BY match_id DESC";

	$Request = parcoursRs(SQLSelect($SQL));

	if (!$Request) {
		return false;
	} 

	return $Request;
}

function changeNameUser($id, $pseudo) {

	$SQL="UPDATE users
	SET name = '$pseudo' 
	WHERE id = '$id';";

SQLUpdate($SQL);
}

function changePDPUser($id, $pdp) {

	$SQL="UPDATE users
	SET profile_picture = '$pdp' 
	WHERE id = '$id';";

SQLUpdate($SQL);
}

function changeTeamUser($id, $team) {

	$SQL="UPDATE users
	SET team = '$team' 
	WHERE id = '$id';";

SQLUpdate($SQL);
}

function changeMainUser($id, $main) {

	$SQL="UPDATE users
	SET main_char = '$main' 
	WHERE id = '$id';";

SQLUpdate($SQL);
}

function changePasswordUser($id, $password, $lastpassword) {

	$SQL="SELECT password
	FROM users
	WHERE id = '$id';";

	$Request = parcoursRs(SQLSelect($SQL));

	if($Request == $lastpassword) {
		$SQL="UPDATE users
		SET password = '$password' 
		WHERE id = '$id';";

	SQLUpdate($SQL);
	}

}

function changeBioUser($id, $bio) {

	$SQL="UPDATE users
	SET bio = '$bio' 
	WHERE id = '$id';";

SQLUpdate($SQL);
}

?>
