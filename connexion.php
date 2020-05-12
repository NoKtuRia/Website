<?php
session_start();

$bdd = new PDO('mysql:127.0.0.1;dbname=membres', 'root', 'root');

if(isset($_POST['formconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($_POST['mailconnect']) AND !empty($_POST['mdpconnect'])) {
        $requser = $bdd->prepare("SELECT * FROM membre_inscris WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 0) {
            $usrerinfo = $requser->fetch();
            $_SEESION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        else {
            $error = "*Mauvais identifiant ou mot de passe";
        }
    }
    else {
        $error = "*Tous les champs doivent être complets";
    }
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/styles.css">
        <title>Connexion</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
    </head>

    <body>
        <!-- Header -->
        <header>
            <div class="header" align="center">
                <h1 class="h-title">Connexion</h1>
                <p class="h-para">Connectez vous pour accéder au contenu</p>
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

        <!-- Formulaire d'inscription -->
        <div class="formulaire">
            <h1>Formulaire d'inscription</h1><br />
            <div  class="form-connect">
                <form method="POST" action="">
                    <table>
                        <tr>
                            <td align="center" class="form-c-items">
                                <label for="pseudo">Mail : </label><br />
                                <input type="email" name="mailconnect" placeholder="Mail">
                            </td>
                        </tr>

                        <tr>
                            <td align="center" class="form-c-items">
                                <label for="pseudo">Mot de passe : </label><br />
                                <input type="password" name="mdpconnect" placeholder="Mot de passe">
                            </td>
                        </tr>

                        <tr>
                            <td align="center" class="form-button">
                                <br />
                                <button type="submit" class="submit-btn" name="formconnexion">Connexion</button>
                            </td>
                        </tr>   
                        
                        <tr>
                            <td align="center" class="form-button">
                                <button type="submit" class="redirect-btn" name="redirect-btn">Ou inscription</button>
                            </td>
                        </tr>
                    </table>
                    <?php
                    echo '<br /><br /><span><font color="red">' .$error.'</font></span>'
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>