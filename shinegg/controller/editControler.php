<?php
session_start();
	include_once "../libs/sqlUtil.php";
	include_once "../libs/systemUtil.php";
	include_once "../libs/userUtil.php";
	include_once "../libs/matchUtil.php";
	include_once "../libs/tournamentUtil.php";
	include_once "../config.php";

	$id = $_SESSION['id'];
	$tabQs = array(); 


	
	if ($view = getArg("view")) {
		//$qs = "view=$view";
		$tabQs["view"] = $view;
	  }

	if ($action = getArg("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";

		switch($action)
		{
			
			// Edition //////////////////////////////////////////////////
			case "Editer le profil" :
				if ($pseudo = getArg("pseudo")) {
					changeNameUser($id, $pseudo);
				}

                if ($bio = getArg("bio")) {
					changeBioUser($id, $bio);
				}

                if ($pdp = getArg("pdp")) {
				changePDPUser($id, $pdp);
				}

                if ($password = getArg("password")) {
					if($lastpassword = getArg("lastpassword")) {
						changePasswordUser($id, $password, $lastpassword);
					}
				}

				if ($team = getArg("team")) {
					changeTeamUser($id, $team);
				}

				if ($main = getArg("main")) {
					changeMainUser($id, $main);
				}
				
				$tabQs['view'] = "account-info";
			break;
		}
	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

    echo $view;

	$urlBase = dirname($_SERVER["PHP_SELF"]);

	$urlBase = str_replace("controller", "index.php", $urlBase);

	redirect($urlBase, $tabQs, false);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>