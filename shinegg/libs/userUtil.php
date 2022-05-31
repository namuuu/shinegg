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
    $SQL="SELECT name, main_char, team, bio, profile_picture FROM users WHERE id='$id'";

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


?>
