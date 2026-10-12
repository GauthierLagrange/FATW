<?php
      try {
        $bdd = new PDO('mysql:host=localhost;dbname=db_fatw;charset=utf8', 'root', '');
    } catch(Exception $e) {
        die('Erreur de connection à la base de donnée : '.$e->getMessage());
    }
    session_start();

    // Fonction d'inscription 
    function inscription($bdd, $Pseudo, $Mail, $MDP, $Nationalite) {
        $requete_Pseudo = $bdd->prepare("SELECT * FROM user_data WHERE Pseudo = :Pseudo");
        $requete_Pseudo->bindParam(':Pseudo', $Pseudo);
        $requete_Pseudo->execute();
        $requete_Mail = $bdd->prepare("SELECT * FROM user_data WHERE Mail = :Mail");
        $requete_Mail->bindParam(':Mail', $Mail);
        $requete_Mail->execute();

        // Vérification de l'existence du pseudo ou du mail
        if ($requete_Pseudo->rowCount() == 1 || $requete_Mail->rowCount() == 1) {
            echo "<center><h3 style='background-color:white;color:red;width:650px'> Ce compte existe déjà, veuillez en utiliser un autre ou alors 
                            tu fais déjà parti de la famille et tu ne t'en souviens peut-être plus ?🤔<br>
                            Clique ici pour te <a href='page-connection.php'>connecter</a>.
                            </h3></center>";
        }
        // Si pas déjà existant alors on l'ajoute à la base de donnée et on lui attribut les avions et le personnage par défaut disponibles.
        else { 
            $MDP_crypte = password_hash($MDP, PASSWORD_BCRYPT);// password_hash est une fonction qui permet de crypter le mot de passe de l'utilisateur à insérer dans la base de données 
            $requete_insertion = $bdd->prepare("INSERT INTO user_data (Pseudo, Mail, MDP, Nationalite, Money, theme_jeu) VALUES (:Pseudo, :Mail, :MDP, :Nationalite, 100, 1)");
            $requete_insertion->bindParam(':Pseudo', $Pseudo);
            $requete_insertion->bindParam(':Mail', $Mail);
            $requete_insertion->bindParam(':MDP', $MDP_crypte);
            $requete_insertion->bindParam(':Nationalite', $Nationalite);
            $requete_insertion->execute();
            $idUser= $bdd->lastInsertId();
            $_SESSION['idUser']=$idUser;
            $_SESSION['autorise']='oui';
            include_once 'bibliotheques/fonctions_requetes_sql.php';
            achete('BluePlane');
            equipe('img/Plane/BluePlane1.png', 'defaut');
            met_ou_retireFav('BluePlane');
            achete('PurplePlane');
            achete('GreenPlane');
            achete('OrangePlane');
            achete('RedPlane');
            achete('Purple');
            achete('Green');
            achete('Orange');
            achete('Red');
            achete('Blue');
            equipe('img/Personnage/Blue.png', 'defaut_perso');
            met_ou_retireFav('Blue');


            $_SESSION['autorise']='non';// Crée une variable qui permettre de vérifier par la suite si l'utilisateur c'est authentifier avant de pouvoir naviguer sur les pages
            echo "<br>";
            echo "<center><h3 style='background-color:white; position: absolute; top:50%;left:50%;transform:translate(-50%,-70%);border:solid 3px;border-radius:30px; font-size:30px;')>Bienvenue parmi nous, te voilà maintenant des nôtres, aviateur $Pseudo.👨‍✈️<br>
                        Je compte sur toi pour relever le niveau de ton pays.<br>
                        Clique ici pour te <a href='page-connection.php'>connecter</a>.
                        </h3></center>";
            
            
        }
    }
    // Fonction de connection
    function connection($bdd, $ID, $MDP){
        $selection = $bdd->prepare("SELECT * FROM user_data WHERE Pseudo = :ID OR Mail = :ID");
        $selection->bindParam(':ID', $ID);
        $selection->execute();

    
        if ($selection->rowCount() == 1) {
            $donnees = $selection->fetch();
            $MDP_hash = $donnees['MDP'];

            if (password_verify($MDP, $MDP_hash)) {
                $_SESSION['pseudo'] = $donnees['Pseudo'];
                $_SESSION['idUser'] = $donnees['idUser'];
                $_SESSION['mail'] = $donnees['Mail'];
                $_SESSION['money'] = $donnees['Money'];
                $_SESSION['autorise'] = 'oui';
                header('Location: jeu.php');
            } 
            else {
                echo "<center><h3 style='background-color:white;color:red;width:650px'>Mot de passe invalide, veuillez vous corriger ou alors peut être que vous êtes nouveau ici ? <a href='page-inscription.php'>S'inscrire</a></h3>";
            }
        } 
        else {
            echo "<center><h3 style='background-color:white;color:red;width:650px'>Identifiant invalide, veuillez vous corriger ou alors peut être que vous êtes nouveau ici ? <a href='page-inscription.php'>S'inscrire</a></h3>";
        }
    }

?>
