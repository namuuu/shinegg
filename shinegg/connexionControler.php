<?php
session_start();

	include_once "libs/sqlUtil.php";
    include_once "libs/systemUtil.php";
    include_once "libs/userUtil.php";

	//$qs = "";
	$tabQs = array(); 
	
	if ($view = getArg("view")) {
	  //$qs = "view=$view";
	  $tabQs["view"] = $view;
      echo $view;
	}

	if ($action = getArg("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...

		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case "Se connecter" :
				// On verifie la presence des champs login et passe

				if ($login = getArg("id"))
				if ($passe = getArg("password"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (connectUser($login, $passe)) {
						setcookie("login",$login , time()+60*60*24*30);
						setcookie("passe",$password, time()+60*60*24*30);
					}

				}


				// On redirigera vers la page index automatiquement
			break;

			case 'Se déconnecter' :
				// traitement métier
				session_destroy();
				$_SESSION = array();
				setcookie("login", "", time()-3600);
				setcookie("passe", "", time()-3600);
				setcookie("remember", false, time()-3600);

			break;

			case "S'inscrire" :
				
			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

    echo $view;

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments
  
    redirect($urlBase, $tabQs, false);
	//header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










