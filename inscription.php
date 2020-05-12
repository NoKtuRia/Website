<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=membres', 'root', 'root');

if(isset($_POST['redirect-btn'])) {
    header('Location: connexion.php');
}

if(isset($_POST['form-inscription'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])){
         $reqpseudo = $bdd->prepare("SELECT * FROM membre_inscris WHERE pseudo =?");
         $reqpseudo->execute(array($pseudo));
         $pseudoexist = $reqpseudo->rowCount();
         if($pseudoexist == 0) {
            $pseudolength = strlen($pseudo);
            if($pseudolength <= 100) {
                if($mail == $mail2) {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        $reqmail = $bdd->prepare("SELECT * FROM membre_inscris WHERE mail = ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0) {
                            if($mdp == $mdp2) {
                                $create_mbr = $bdd->prepare("INSERT INTO membre_inscris(pseudo, mail, motdepasse) VALUE(?, ?, ?)");
                                $create_mbr->execute(array($pseudo, $mail, $mdp));
                                $error = "*Votre compte à bien été créer.";
                            }
                            else {
                                $error = "Vops mot de passes ne correspondent pas.";
                            }
                        }
                        else {
                            $error = "*Adresse mail déjà utilisée.";
                        }
                    }
                    else {
                        $error = "*Votre addresse mail n'est pas valide.";
                    }
                } 
                else {
                    $error = "*Les deux addresses mails ne correspondent pas.";
                }
            } 
            else {
                $error = "*Le pseudo ne doit pas dépasser 100 caractère.";
            }
         }

    } else {
        $error = "*Tous les champs doivent être remplis.";
    }
}



?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/styles.css">
        <title>Inscription</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="header" align="center">
                <h1 class="h-title">Inscription</h1>
                <p class="h-para">Inscrivez vous pour plus de contenu</p>
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
        <div class="formulaire" style="height: 700px;">
            <h1>Formulaire d'inscription</h1><br />
            <div  class="form-inscri">
                <form method="POST" action="">
                    <table>
                        <tr>
                            <td align="center" class="form-i-items">
                                <label for="pseudo">Pseudo : </label><br />
                                <input type="text" name="pseudo" placeholder="Pseudo">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="form-i-items">
                                <label for="pseudo">Mail : </label><br />
                                <input type="email" name="mail" placeholder="Mail : example@gmail.com">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="form-i-items">
                                <label for="pseudo">Confirmation - mail : </label><br/>
                                <input type="email" name="mail2" placeholder="Confirmation">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="form-i-items">
                                <label for="pseudo">Mot de passe : </label><br />
                                <input type="password" name="mdp" placeholder="Mot de passe">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="form-i-items">
                                <label for="pseudo">Confirmation mot de passe : </label><br />
                                <input type="password" name="mdp2" placeholder="Confirmation">
                            </td>   
                        </tr>
                        <tr>
                            <td align="center" class="form-button">
                                <br />
                                <button type="submit" class="submit-btn" name="form-inscription">Inscription</button>
                            </td>
                        </tr>   
                        <tr>
                            <td align="center" class="form-button">
                                <button type="submit" class="redirect-btn" name="redirect-btn">Ou connexion</button>
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