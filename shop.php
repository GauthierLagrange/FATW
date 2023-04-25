<!DOCTYPE html>
<html lang="en">
<head>
    <title>FATW-Boutique</title>
    <link rel="shortcut icon" href="https://www.243tech.com/logo-243tech.ico"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../javascript/page-shop.js" ></script>
    <link rel="stylesheet" href="../css/page-shop90.css">
</head>
<body>

<?php 
session_start();
include_once 'bibliotheques/fonctions_requetes_sql.php';

$Pseudo=$_SESSION['pseudo'];
$idUser=$_SESSION['idUser'];
$money = $bdd->query("SELECT Money FROM user_data WHERE idUser = $idUser")->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Nom']) && isset($_POST['fonction'])) {
        $nomSkin = $_POST['Nom'];
        $fonction = $_POST['fonction'];
        $fonction($nomSkin);
        unset($_POST['Nom']);
        };   

};

?>    
<a href='jeu.php'><h3 style='background-color:grey; width:70px;height:30px;border-bottom-right-radius:10px;'>Retour</h3></a>

<div class="liste_favori">
    <button style='position:absolute;top:0px;' onclick='changeAfficheFavPerso_ou_Vehicule()'>CHANGE</button>
    <div id='vehiculeFav' style='display: flex;'>
        <h1>Véhicules Favoris</h1>
        <?php affiche($bdd,"vehiculeFav"); ?>
    </div>
    <div id='persoFav' style='display: none;'>
        <h1>Personnages Favoris</h1>
        <?php affiche($bdd,"persoFav"); ?>
    </div>
</div>

<h1><u>Entrepôt / Boutique de Skin</u></h1>
</center>


<div id="infos"><h2><u><?php echo $Pseudo ?> : <i id='money'><?php echo $money ?></i> 🛩️ Flycoin.</u>
</h2></div>
<div id="boutons">
    <button id="onglet_vehicule" class='bouton_objets' data-value='listes_objets' onclick='afficheBouton(this)'>VEHICULES</button>
    <button id="onglet_perso" class='bouton_objets_perso' data-value='listes_objets_perso' onclick='afficheBouton(this)'>PERSONNAGES</button>
</div>


<section id="listes_objets" >
    <center><h2>Par défaut</h2></center><br>
        <div class="liste">
            <?php affiche($bdd,"defaut"); ?>
       </div>
    <center><h2>Avion</h2></center><br>
        <div class="liste">
            <?php affiche($bdd,"avion"); ?>
       </div>
    
</section>
<section id="listes_objets_perso" style='display:none;'>
    <center><h2>Personnages</h2></center><br>
       <div class="liste" >
            <?php affiche($bdd,"personnage"); ?>
       </div>
</section>
    


<!-- Partie Message -->
<div id="confirmation_achat" >
    <span class="close" onclick="cache_M(this)">&times;</span>
    <h2>Valider votre achat</h2>
    <img id="image" src="">
    <p>Êtes-vous sûr de vouloir acheter <u id="nom"></u> ?</p>
    <button class="btn" id='toto' onclick="confir_achat(this)">Acheter</button>
    <button class="btn" onclick="cache_M(this)">Annuler</button>
    <p id="prix"></p>

  </div>

<div class='message_advert'>
    <span class='close' onclick='cache_M(this)'>&times;</span>
    <h2>Vous n'avez pas assez de Flycoin.</h2>
</div>

</body>
</html> 