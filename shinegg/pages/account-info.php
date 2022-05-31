<?php
    include_once('libs/userUtil.php');
    $id = getArg('id');

    if(!$id) {
        $id = getSession("id");
        if(!$id) {
            redirect(dirname($_SERVER["PHP_SELF"]) . "/index.php");
        }
    }

    

    $userdata = getUserData($id);
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
                    <h2>0.00% (nul)</h2>
            </div>
        </div>

    </div>

    <div id="connexion">
        <h3 id="connect">Connexions :</h3>
    </div>
</body>

