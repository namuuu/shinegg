<?php

include_once "sqlUtil.php";

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


?>