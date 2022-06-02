<?php
    include_once('libs/userUtil.php');
    include_once('libs/tournamentUtil.php');
    $id = getArg('id');
    $i = 1;
    $win = 0;
    $lose = 0;
    $winrate = 0;
    $userdata = getUserData($id);
    $matchdata = mostRecentMatch($id);
    if ($matchdata['player2_id'] == $id) {
        $player2data = getUserData($matchdata['player1_id']);
    }
    if ($matchdata['player1_id'] == $id) {
        $player2data = getUserData($matchdata['player2_id']);
    }
    $tournamentdata = getTournament($matchdata['tournament_id']);

    //Calcul Win Rate :

    $matchuser1 = getUserMatches1($id);
    $matchuser2 = getUserMatches2($id);

    foreach ($matchuser1 as $match) {
        if ( $match['player1_score'] == $match['score_max'] ) {
            $win = $win+1;
        }
        if ( $match['player1_score'] != $match['score_max'] ) {
            $lose = $lose+1;
        }
    }

    foreach ($matchuser2 as $match2) {
        if ( $match2['player2_score'] == $match2['score_max'] ) {
            $win = $win+1;
        }
        if ( $match2['player2_score'] != $match2['score_max'] ) {
            $lose = $lose+1;
        }
    }

    $winrate = ($win/($win+$lose))*100;
?>

<head>
    <title>Shine.GG - AccountInfo</title>
    <link rel="stylesheet" type="text/css" href="css/info.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400&display=swap" rel="stylesheet">
</head>

<body>
    <div id="baseinfo">
        <?php
            echo "<img src=\"".$userdata['profile_picture']."\" alt=\"Photo de profil\" id=\"PDP\">";
            echo "<h1 id=\"name\">".$userdata['name']."<h1>";
            echo "<h1 id=\"team\">".$userdata['team']."<h1>";
        ?>
    </div>
    <div id="biomain">

        <div id="biodiv">
            <h3>Biographie</h3>
        <?php
            echo "<p id=\"bio\">".$userdata['bio']."<p>";
        ?>
        </div>

        <div id="doublediv">
            <div id="chardiv">
                <h3>Personnage principal</h3>
                <?php
                    echo "<h2>".$userdata['main_char']."<h2>";
                ?>
            </div>

            <div id="windiv">
                <h3>Winrate</h3>
                <?php
                    echo "<h2>".$winrate."%<h2>";
                ?>
            </div>
        </div>

    </div>

    <div id="connexion">
        <h3 id="connect">Connexions :</h3>
        <ul>
            <?php
                echo "<li>Twitter :   ".$userdata['twitter']."</li>";
            ?>
            <?php
                echo "<li>Discord :   ".$userdata['discord']."</li>";
            ?>
            <?php
                echo "<li>Smash.gg :   ".$userdata['smash_gg']."</li>";
            ?>
            <?php
                echo "<li>Slippi :   ".$userdata['slippi']."</li>";
            ?>
        </ul>
</div>

    <div class="recent">

        <div class="barrerouge">
        </div>

        <h3 id="recentitle">Dernier tournoi : </h3>
        <?php
            echo "<img src=\"".$tournamentdata['tournament_picture']."\" alt=\"Image du tournoi\">";
            echo "<h1 id=\"tname\">".$tournamentdata['tournament_name']." <h1>";
        ?>

    </div>

    <div class="recent" id="resultats"  >

        <div class="barrerouge">
        </div>

            <h3 id="recentitle2"> Dernier match : </h3>
            <?php
                echo "<h2>".$tournamentdata['tournament_name']." <h2>";
                echo "<h1 class=\"results\" id=\"lastname\">".$userdata['team']." ". $userdata['name']." VS ".$player2data['team']." ".$player2data['name']." <h1>";
                echo "<h1 class=\"results\">".$matchdata['player1_score']." - ".$matchdata['player2_score']." <h1>";
            ?>
            
    </div>

    <div id="edition">
    <?php
        echo "<a href=\"index.php?view=account-edition&id=".$id."\"> Editer mon profil </a>"
    ?>
    </div>

</body>

