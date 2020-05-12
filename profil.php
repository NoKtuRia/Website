<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=membres', 'root', 'root');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare("SELECT * FROM membre_inscris WHERE id = ?");
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/styles.css">
        <title>Profil</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="header" align="center">
                <h1 class="h-title">Profil de <?php echo $userinfo['pseudo'];?></h1>
                <p class="h-para">Modifier dès a présent votre profil</p>
            </div>
        </header>

        <!-- Menu Navigation -->
        <nav class="nav">
            <ul>
                <li class="n-item"><a href="index.html">Acceuil</a></li>
                <li class="n-item"><a href="#">Nouveautés</a></li>
                <li class="n-item"><a href="#">A propos</a></li>
                <li class="n-item"><a href="inscription.php">Inscription</a></li>
            </ul>
        </nav>

        <!-- Profil -->
        <div align="center" class="formulaire" style="height: 700px;">
            <h2>Profil de <?php echo $userinfo['pseudo'];?></h2>
            <br/><br/>
            Pseudo = <?php echo $userinfo['pseudo'];?>
            <br />
            Mail = <?php echo $userinfo['mail'];?>
            <a href="editionprofil.php">Éditer mon profil</a>
            <br />
            <?php
            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
            {
            ?>
            <br />
            <a href="editionprofil.php">Éditer mon profil</a>
            <a href="deconnection.php">Se déconnecter</a>
            <?php
            }
            ?>
        </div>
    </body>
</html>
<?php
}

?>