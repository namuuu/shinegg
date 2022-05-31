<head>
    <title>Shine.GG - Liste des tournois</title>
    <link rel="stylesheet" type="text/css" href="css/tournament-list.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<?php

include_once("libs/tournamentUtil.php");

?>

<div id="main-list">
    <div id="header">
        <div id="header-left">
            Date du tournoi
        </div>
        <div id="header-middle">
            Nom du tournoi
        </div>
        <div id="header-right">
            Entrants
        </div>
    </div>

    <div id="data-list">
        <?php
        $tournamentsList = getTournaments();
        foreach($tournamentsList as $tournament) {
            $url = dirname($_SERVER["PHP_SELF"]) . "/index.php?view=tournament-view&tournamentId=" . $tournament["id"];

            echo "<a href=\"". $url ."\">  <div class=\"tournament-data\">";
            echo "<div class=\"tournament-date\">" . $tournament["debut_date"] . "</div>";
            echo "<div class=\"tournament-name\">" . $tournament["tournament_name"] . "</div>";
            echo "<div class=\"tournament-entrants\">" . getTournamentEntrantsNb($tournament["tournament_id"]) . "/" . $tournament["max_participants"] . "</div>";
            echo "</div> </a>";
        }
        ?>
    </div>
    <a href=""></a>
</div>