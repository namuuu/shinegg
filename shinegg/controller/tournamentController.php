<?php
include_once "../config.php";

session_start();

	include_once "../libs/sqlUtil.php";
    include_once "../libs/systemUtil.php";
    include_once "../libs/userUtil.php";
	include_once "../libs/matchUtil.php";
    include_once "../libs/tournamentUtil.php";

	//$qs = "";
	$tabQs = array(); 
	
	if ($view = getArg("view")) {
	  //$qs = "view=$view";
	  $tabQs["view"] = $view;
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
			case "S\'enregistrer" :
                $tabQs["view"] = "tournament-view";
                $tabQs["tournamentId"] = getArg("tournamentId");
                if(($userId = getArg("userId")) && ($tournamentId = getArg("tournamentId"))) {
                    registerUser($tournamentId, $userId);
                }
            break;
            case "Quitter le tournoi":
                $tabQs["view"] = "tournament-view";
                $tabQs["tournamentId"] = getArg("tournamentId");
                if(($userId = getArg("userId")) && ($tournamentId = getArg("tournamentId"))) {
                    unregisterUser($tournamentId, $userId);
                }
			break;

            case "Lancer le tournoi":
                if($tournamentId = getArg("tournamentId")) {
                    generateTournament($tournamentId);
                    $tabQs["view"] = "tournament-view";
                    $tabQs["tournamentId"] = getArg("tournamentId");
                }
				break;
			case "Victoire 1":
				$matchId = getArg("matchId");
				$tournamentId = getArg("tournamentId");
				winMatch1($tournamentId, $matchId);
			break;
			case "Victoire 2":
				$matchId = getArg("matchId");
				$tournamentId = getArg("tournamentId");
				winMatch2($tournamentId, $matchId);
            break;
			case "Accorder la victoire au joueur 1":
				$agreedPlayer = 1;
			case "Accorder la victoire au joueur 2":
				if($agreedPlayer != 1)
					$agreedPlayer = 2;

				// Détermine les données
				$matchId = getArg("matchId");
				$tournamentId = getArg("tournamentId");

				// Return si données invalides
				if(!$matchId)
					break;
				if(!$tournamentId)
					break;

				// Prévention retour à la fenêtre initiale
				$tabQs["view"] = "match-view";
				$tabQs["tournamentId"] = $tournamentId;
				$tabQs["matchId"] = $matchId;

				if(isMatchFinished($matchId)) {
					$tabQs["view"] = "tournament-view";
					break;
				}

				$match = getMatch($matchId);

				// Update l'agreement
				if(getSession("id") == $match["player1_id"] || getSession("id") == $match["player2_id"]) {
					agree($matchId, getSession("id"), $agreedPlayer);
				}

				// Update le score si l'agreement est correct
				matchAgreeCheck($matchId);

				// Finalise le match si le score_max est atteint
				maxScoreCheck($matchId);

				if(isMatchFinished($matchId))
					$tabQs["view"] = "tournament-view";

			break;
			case "Créer un tournoi":
				$$tabQs["view"] = "tournament-list";
				$id = getSession("id");
				$name = getArg("name");
				$numberPlayers = getArg("numberPlayers");
				$date = getArg("date");
				$image = getArg("image");
				if(!$id)
					break;
				if (!$name || !$numberPlayers || !$date || !$image)
					break;
				
				createTournament($name, $numberPlayers, $date, $image);

			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

    echo $view;

	$urlBase = dirname($_SERVER["PHP_SELF"]);

	$urlBase = str_replace("controller", "index.php", $urlBase);
	// On redirige vers la page index avec les bons arguments
  
    redirect($urlBase, $tabQs, false);
	//header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










