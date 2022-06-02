
<head>
    <title>Shine.GG - Home</title>
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<div id="content">
    <div id="recent-tournaments">
        <?php

        include_once "libs/tournamentUtil.php";

        foreach(getTournaments() as $tournament) {
            displayTournament($tournament);
        }


        function displayTournament($tournament)
        {
            echo "<div class=\"tournament-vignette\">";
            echo "<img src=\"". $tournament["tournament_picture"] ."\" alt=\"Tournament Picture\"\"> </img>";
            echo "<div>";
            echo "<h2>" . $tournament["tournament_name"] . "</h2>";
            echo "<span>" . $tournament["debut_date"] . " | " . getTournamentEntrantsNb($tournament["tournament_id"]) . "/" . $tournament["max_participants"] . "</span>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <div id="feed">
        <?php include("feed.php"); ?>
    </div>
</div>
