<?php

function getArg($arg) {
    if(isset($_REQUEST[$arg]) && !($_REQUEST[$arg] == "")) 	
		return proteger($_REQUEST[$arg]); 	
    
    return false; // Si la valeur n'est pas récupérable
}

function getSession($arg) {
	if(isset($_SESSION[$arg]) && !($_SESSION[$arg] == "")) 	
		return proteger($_SESSION[$arg]); 	
    
    return false; // Si la valeur n'est pas récupérable
}


/**
* Evite les injections SQL en protegeant les apostrophes par des '\'
* Attention : SQL server utilise des doubles apostrophes au lieu de \'
* ATTENTION : LA PROTECTION N'EST EFFECTIVE QUE SI ON ENCADRE TOUS LES ARGUMENTS PAR DES APOSTROPHES
* Y COMPRIS LES ARGUMENTS ENTIERS !!
* @param string $str
*/
function proteger($str)
{
	// attention au cas des select multiples !
	// On pourrait passer le tableau par référence et éviter la création d'un tableau auxiliaire
	if (is_array($str))
	{
		$nextTab = array();
		foreach($str as $cle => $val)
		{
			$nextTab[$cle] = addslashes($val);
		}
		return $nextTab;
	}
	else 	
		return addslashes ($str);
	//return str_replace("'","''",$str); 	//utile pour les serveurs de bdd Crosoft
}

function redirect($url, $tabQS="", $die=true)
{
	$qs =""; 
	// NB : tabQS est un tableau associatif 

	if (is_array($tabQS)) {
		foreach($tabQS as $nom => $val) {
			// Il faut respecter l'encodage des caractères dans les chaînes de requêtes
			$qs .= "$nom=" . urlencode($val) . "&";
		}
	}
	
	header("Location:$url?" . rtrim($qs, "&") ); // envoi par la méthode GET
	if ($die) {
  	die(""); // interrompt l'interprétation du code 
	}
}


?>