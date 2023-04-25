<?php 
    if($_SESSION['autorise']!='oui'){
        header('Location: page-inscription.php');
        } 
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=db_fatw;charset=utf8', 'root', '');
        } 
    catch(Exception $e) {
        die('Erreur de connection à la base de donnée : '.$e->getMessage());
        }


    // Fonction qui renvoie True si l'image (personnage ou véhicule) est possédé pour l'utilisateur en question sinon False
    function estPossede($bdd, $idImg) {
        $idUser=$_SESSION['idUser'];

        // Compte le nombre de ligne où l'idImg et idUser présent dans la table image_possede
        $present = $bdd->prepare("SELECT COUNT(*) FROM image_possede WHERE idUser = ? AND idImg = ?");
        $present->execute([$idUser, $idImg]);
        $result = $present->fetchColumn();
        // ainsi si un enregistrement existe cela signifie que le image en question est possédé
        // Sinon c'est égale à 0 ligne donc pas possédé.
        return ($result > 0);
    }

    // Fonction qui renvoie True si le image est favori pour l'utilisateur en question sinon False
    function estFav($bdd, $idImg){
        $idUser=$_SESSION['idUser'];

        // Compte le nombre de ligne existant pour cet utilisateur et ce image en tant que favori présent dans la table image_possede 
        $fav = $bdd->prepare("SELECT COUNT(*) FROM image_possede WHERE idUser = ? AND idImg = ? AND favori=1");
        $fav->execute([$idUser, $idImg]);
        $result = $fav->fetchColumn();
        // ainsi si un enregistrement existe cela signifie que le image en question est favori
        // Sinon c'est égale à 0 ligne donc pas favori.
        return ($result > 0);
    };

    // Fonction qui renvoie la liste de toutes les images d'un thème précis triés par prix croissant 
    function selecImg($bdd,$theme){
        $info = $bdd ->prepare("SELECT * FROM image WHERE theme = :theme ORDER BY prix");
        $info->bindParam(":theme", $theme);
        $info->execute();
        return $info;
    }

    // Fonction qui renvoie la liste des véhicules possédés favoris de l'utilisateur avec leurs informations
    function selecFavVehicule($bdd){
        $idUser=$_SESSION['idUser'];

        $Fav=$bdd->query("SELECT * FROM image JOIN image_possede ON image.idImg=image_possede.idImg WHERE image_possede.favori=1 AND idUser=$idUser AND image.theme <> 'personnage' ");
        return $Fav;
    }

    // Fonction qui renvoie la liste des images qui sont des personnages de l'utilisateur avec leurs informations
    function selecFavPerso($bdd){
        $idUser=$_SESSION['idUser'];

        $PersoFav=$bdd->query("SELECT * FROM image JOIN image_possede ON image.idImg=image_possede.idImg WHERE image_possede.favori=1 AND idUser=$idUser AND image.theme='personnage' ");
        return $PersoFav;
    }

    // Fonction qui selectionne l'image équipé pour jouer
    function selecEquipeVehicule($bdd){
        $idUser=$_SESSION['idUser'];
        $srcImageVehiculeEquipe=$bdd->query("SELECT lien_img_de_profil 
                                     FROM image 
                                     JOIN image_possede 
                                     ON image.idImg = image_possede.idImg 
                                     WHERE image_possede.equipe = 1 
                                     AND image_possede.idUser = $idUser 
                                     AND image.theme <> 'personnage';");// "<>" = "différent de"
        return $srcImageVehiculeEquipe->fetch(PDO::FETCH_ASSOC);
    }

    function selecEquipePersonnage($bdd){
        $idUser=$_SESSION['idUser'];
        $srcImagePersoEquipe=$bdd->query("SELECT lien_img_de_profil
                                     FROM image 
                                     JOIN image_possede 
                                     ON image.idImg = image_possede.idImg 
                                     WHERE image_possede.equipe = 1 
                                     AND image_possede.idUser = $idUser 
                                     AND image.theme = 'personnage';");
        return $srcImagePersoEquipe->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction qui permet d'afficher les images concernés dans la boutique (soit favoris, possédé ou à acheter)
    function affiche($bdd, $theme) {
        $idUser=$_SESSION['idUser'];

        // Récupération des images à afficher en fonction du thème ou du statut de favori
        if ($theme != 'persoFav' && $theme != 'vehiculeFav') {
            $images = selecImg($bdd,$theme);
        } else if($theme == 'persoFav'){
            $images = selecFavPerso($bdd);
        }else{
            $images = selecFavVehicule($bdd);
        }

        // Sélectionne chaque image un par un 
        foreach ($images as $image) {
            // Récupère l'identifiant du image en cours de test pour voir s'il est possédé.
            $idImg = $image['idImg'];
            
            // Si le image à afficher est possédé alors il faut le différencier de ceux à payer
            if (estPossede($bdd, $idImg)){

                
                // Affichage de l'image comme déjà possédé sans être favori
                echo "<div class='conteneur_img_possede'>";
                echo "<div class='entete'>";
                echo "<span class='nom'>". $image['nom'] ."</span>"; 
                echo "<span>🔓</span>";
                if(estFav($bdd, $idImg)){ // Pour afficher en favori l'étoile
                    echo "<span  class='etoile_pleine' onclick='metFav(this)'></span>";
                }
                else{
                    echo "<span class='etoile' onclick='metFav(this)'></span>";//juste pas mis favori le véhicule concerné
                }
                echo "</div>";
                if($theme=='personnage' || $theme=='persoFav'){
                    echo "<img id='img' src='". $image['lien_img_de_face'] ."' >";
                }else{
                    echo "<img id='img' src='". $image['lien_img_de_profil'] ."' >";
                }
                echo "</div>";
                }
            // Sinon on affiche les images avec le prix de façon a montrer qu'il faut le payer pour y avoir accès
            else{
                // Affichage du conteneur de l'image avec l'image et ses caractéristiques
                echo "<div class='conteneur_img' id='image-".$image['idImg']."' onclick='showMessage(this)'>";
                echo "<div class='entete'>";
                echo "<span id='nom'>". $image['nom'] ."</span>"; 
                echo "<span><u id='prix'>". $image['prix'] ."</u>🛩️</span>";
                echo "</div>";
                if($theme=='personnage' || $theme=='persoFav'){
                    echo "<img id='img' src='". $image['lien_img_de_face'] ."' >";
                }else{
                    echo "<img id='img' src='". $image['lien_img_de_profil'] ."' >";
                }
                echo "</div>";


                }
            }
    };

    // Fonction qui affiche les images favorites pour la page de jeu
    function afficheDansJeu($bdd,$image) {
        $idUser=$_SESSION['idUser'];
        if($image=='personnage'){
            // Récupération de la source des personnages achetés favoris
            $images = selecFavPerso($bdd);
            if ($images->rowCount() == 0) {
                echo "<center><h1>Vous n'avez actuellement pas de véhicules favoris.</h1></center>";
            } 
            else {
                // Sélectionne chaque image une par une
                foreach ($images as $image) {
                    // Affiche l'image
                    echo "<img src='" . $image['lien_img_de_face'] . "' onclick=\"equipe(this.src, 'personnage')\">";
                }
            }
        }
        else{
            // Récupération de la source des véhicules achetés favoris
            $images = selecFavVehicule($bdd);
            if ($images->rowCount() == 0) {
                echo "<center><h1>Vous n'avez actuellement pas de véhicules favoris.</h1></center>";
            } 
            else {
                // Sélectionne chaque image une par une
                foreach ($images as $image) {
                    // Affiche l'image
                    echo "<img src='" . $image['lien_img_de_profil'] . "' onclick=\"equipe(this.src,'vehicule')\">";
                }
            }
        }        
    }

    // Fonction qui permet d'afficher le image équipé pour jouer dans la page de jeu
    function afficheImageEquipe($bdd,$image,$idUser) {
        if($image=='personnage'){
            // Récupération de l'image de profil équipe de véhicule
            $srcImageEquipe = selecEquipePersonnage($bdd);
            // Affichage du image comme favori sans modifications possibles
            echo "<img src='".$srcImageEquipe['lien_img_de_profil']."' >";
        }
        else{
            // Récupération de l'image profilé du véhicule équipé
            $srcImageEquipe = selecEquipeVehicule($bdd);
            // Affichage du image comme favori sans modifications possibles
            echo "<img src='".$srcImageEquipe['lien_img_de_profil']."' >";
        }  
    }

    // Fonction permettant la transaction avec la monnaie de l'utilisateur 
    function transaction($somme){
        global $bdd;
        $idUser=$_SESSION['idUser'];
        $money = $bdd->query("SELECT Money FROM user_data WHERE idUser = $idUser")->fetchColumn();
        $nouvelleMoney= $money+$somme;
        // Déduction de la somme à l'argent de l'utilisateur dans la table user_data
        $bdd->query("UPDATE user_data SET Money = $nouvelleMoney WHERE idUser = $idUser");
    }

    // Fonction qui permet d'enregistrer le score et d'ajouter de l'argent au joueur en fonction du score pour chaque partie  
    function enregistreScore($score){
        $idUser=$_SESSION['idUser'];
        global $bdd;

        $bdd->query("INSERT INTO total_games VALUES('$idUser','$score')");
        $somme_gagne=$score*5;
        transaction($somme_gagne);
    }

    //Fonction qui remplace l'ancien image équipé de l'utilisateur par le nouveau cliqué
    function equipe($lien_img,$theme) {
        $idUser=$_SESSION['idUser'];
        global $bdd;
        // Récupère l'id de la nouvelle image à équipé à partir de la source de l'image cliquée
        $lien_img = str_replace("http://localhost/php/", "", $lien_img);
        if($theme=='personnage'){

            // Retire l'ancien personnage équipé de l'état équipé
            $bdd->query("UPDATE image_possede 
                         SET equipe =0  
                         WHERE equipe=1 AND idUser=$idUser AND idImg IN (SELECT idImg 
                                                                        FROM image 
                                                                        WHERE theme = 'personnage')");
            // Met le nouveau véhicule ou personnage cliqué en tant que équipé grâce à son lien png
            $bdd->query("UPDATE image_possede 
            SET equipe =1  
            WHERE  idUser=$idUser AND idImg IN (SELECT idImg 
                                                FROM image 
                                                WHERE lien_img_de_face = '$lien_img')");
        }
        else{
            // Retire l'ancien véhicule (=différent de thème personnage) équipé de l'état équipé
            $bdd->query("UPDATE image_possede 
                        SET equipe =0  
                        WHERE equipe=1 AND idUser=$idUser AND idImg IN (SELECT idImg 
                                                                        FROM image 
                                                                        WHERE theme <> 'personnage')");
            // Met le nouveau véhicule ou personnage cliqué en tant que équipé grâce à son lien png
            $bdd->query("UPDATE image_possede 
            SET equipe =1  
            WHERE  idUser=$idUser AND idImg IN (SELECT idImg 
                                                FROM image 
                                                WHERE lien_img_de_profil = '$lien_img')");
        }; 
          
    };

    // Fonction qui permet d'acheter le image 
    function achete($nom) {
        global $bdd;
        $idUser=$_SESSION['idUser'];

        // Récupération du prix du image
        $prix = $bdd->query("SELECT prix FROM image WHERE nom = '$nom'")->fetchColumn();

        // Récupération de l'id correspondant au nom de l'image dans la table image
        $idImg = $bdd->query("SELECT idImg FROM image WHERE nom = '$nom'")->fetchColumn();

        //Effectue l'achat
        transaction(-$prix);
        // Insertion du image dans la table image_possede pour l'utilisateur correspondant
        $bdd->query("INSERT INTO image_possede (idImg, idUser) VALUES ($idImg, $idUser)");

    };

    // Fonction qui permet de mettre ou enlever le image de l'utilisateur en favori 
    function met_ou_retireFav($nom) {

        global $bdd;
        $idUser=$_SESSION['idUser'];

        // Récupération de l'ID du image à partir de son nom
        $idImg = $bdd->query("SELECT idImg FROM image WHERE nom = '$nom'")->fetch(PDO::FETCH_ASSOC)['idImg'];

        // Si l'image de l'utilisateur est déjà en favori on le retire des favoris (=0)
        if(estFav($bdd, $idImg)){
            $bdd->query("UPDATE image_possede SET favori = 0 WHERE idUser = $idUser AND idImg = '$idImg'");
        }
        // Sinon on le met en favori (=1) s'il n'y a pas déjà 5 images favoris
        else{
            $theme=$bdd->query("SELECT theme FROM image WHERE idImg='$idImg' ")->fetch(PDO::FETCH_ASSOC)['theme'];
            if($theme=='personnage'){
                if(selecFavPerso($bdd)->rowCount()!=5){
                    $bdd->query("UPDATE image_possede SET favori = 1 WHERE idUser = $idUser AND idImg = '$idImg'");
                }
            }
            else{
                if(selecFavVehicule($bdd)->rowCount()!=5){
                    $bdd->query("UPDATE image_possede SET favori = 1 WHERE idUser = $idUser AND idImg = '$idImg'");
                }
            }
        }
    }


?>
