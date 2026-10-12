<?php  
  session_start();
  include_once 'bibliotheques/fonctions_requetes_sql.php';
  $idUser=$_SESSION['idUser'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
      if(isset($_POST['score'])){
          $score=$_POST['score'];
          enregistreScore($score);
      }
      if(isset($_POST['srcImg'])){
        $srcImg=$_POST['srcImg'];
        $Theme=$_POST['Theme'];
        equipe($srcImg,$Theme);
      }

      if(isset($_POST['fonction'])){
        changeTheme($idUser);
      }
    };
$recupThemeJeu=$bdd->query("SELECT theme_jeu FROM user_data WHERE idUser=$idUser")->fetch(PDO::FETCH_ASSOC)['theme_jeu'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FATW-Game</title>
  <?php if($recupThemeJeu==1){ /* Permet de choisir la feuille de style à prendre selon le thème (1=clair,2=sombre) */
    echo "	<link rel='stylesheet' href='../css/page-jeu-clair1.css'>";
    }
    else{
    echo "<link rel='stylesheet' href='../css/page-jeu-sombre1.css'>";
    }
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="../javascript/page-jeu.js" defer></script>

  <style type="text/css"> #coeur1,#coeur2,#coeur3{width:80px;height:80px;}</style> 
</head>
<body>
  
<audio id="bruitage" src="explosion.mp3"></audio>


<div id= "barre_de_vie" style="visibility: hidden; position: relative;width:30%;text-align:center;">
<ul style="  list-style-type: none;">
  <li style="text-decoration: underline; font-size: 25px;" id="pseudo"><?php echo $_SESSION['pseudo'];?></li>
  <li><img src="img/Decor/coeur.png" id="coeur1"><img src="img/Decor/coeur.png" id="coeur2"><img src="img/Decor/coeur.png" id="coeur3"></li>
  <li><p id="score" style="font-size: 30px;"></p></li>
</ul>
</div>

<div id="conteneur" style="	position:absolute;top:18vh;left:45vw;">
  <div id='personnage_Equipe' ><?php afficheImageEquipe($bdd,'personnage',$idUser); ?></div>
  <div id='vehicule_Equipe'   ><?php afficheImageEquipe($bdd,'vehicule',$idUser); ?></div>
</div>

<div id="meteorites" style='left:100vw;position:absolute; visibility: hidden; position:absolute; right:0px; width:10vw; height:10vw; top:18vh;'></div>

<button id="start" style="z-index:1; position:absolute; border-radius:20px; height:10vh; width:10vw; top:60vh; left:45vw;" onclick="start()">START</button>
  
<div id="terre" style="position: absolute; width:40vw; height:40vw; bottom:-25vw; left:30vw;"></div>
  
<div id="bouton_parametre" style="width:35px; height:35px; position:absolute; left:1%; cursor:pointer; bottom:1%;" onclick="pause(obj)"></div>



<!-- Partie non visible par défaut -->

<div id="listes_jeu" 	style="visibility: hidden; position:absolute; top:60vh; height:40vh; width:55vw; left:22.5vw; border-radius:30px;">
  <br>
  <div id="liste_perso" style="">
    <?php
    afficheDansJeu($bdd,'personnage');
    ?>
  </div><br>
  <div id="liste_vehicule">
    <?php
    afficheDansJeu($bdd,'vehicule');
    ?>
  </div>
  <br>
</div>

<div  id="parametre" style="visibility:hidden;z-index: 3; position:absolute; bottom:10vh; left:2vw; border-radius:20px; padding:10px;" >
  <h2 onclick="pause(obj)">                                                        Reprendre</h2>
  <h2 onclick="document.getElementById('listes_jeu').style.visibility = 'visible'">Favoris</h2>
  <h2 onclick="window.location.reload();">                                         Rejouer</h2>
  <h2><a href="statistiques.php" style="text-decoration:none;color:black;">        Statistiques</a></h2>
  <h2><a href="info_perso.php" style="text-decoration:none;color:black;">          Mon profil</a></h2>
  <h2><a href="shop.php" style="text-decoration:none;color:black;">                Boutique</a></h2>
  <h2 onclick="document.getElementById('commandes').style.visibility = 'visible'">Commandes</h2>
  <h2 onclick="changeTheme()">                                                    Changer de thème</h2>
  <h2><a href="../index.php" style="text-decoration:none;color:black;">            Quitter</a></h2> 
</div>

<div id="commandes" style="visibility: hidden; position:absolute; z-index:3; width:30vw; height:50vh; top:40%; right:5%; transform:translate(0,-50%); text-align:center; font-size:15px;" >
  <h1><u>Commandes</u></h1>
  <ol>
  <li>Monter:   <img style="width:5vw;height:5vw;" src="img/icones/fleche_haut.png"></li>
  <li>Descendre:<img style="width:5vw;height:5vw;" src="img/icones/fleche_bas.png"></li>
  <li>Pause:    <img style="width:5vw;height:5vw;" src="img/icones/echap.png"></li>
  </ol>
  <br>
  <button style="font-size:20px;"onclick="this.parentNode.style.visibility='hidden'">Compris !</button>
</div>


</body>
</html>