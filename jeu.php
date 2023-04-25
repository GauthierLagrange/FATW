<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FATW-Game</title>
	<link rel="stylesheet"href="../css/page-jeu.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="../javascript/page-jeu.js" defer></script>

  <style type="text/css"> #coeur1,#coeur2,#coeur3{width:80px;height:80px;}</style> 
</head>
<body>
  <?php  
  session_start();
  include_once 'bibliotheques/fonctions_requetes_sql.php';
  $idUser=$_SESSION['idUser'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
      if(isset($_POST['score'])){
          ?><script>console.log('enregistreScore JEU-PHP')</script><?php
          $score=$_POST['score'];
          enregistreScore($score);
      }
      if(isset($_POST['srcImg'])){
        $srcImg=$_POST['srcImg'];
        $Theme=$_POST['Theme'];
        equipe($srcImg,$Theme);
      }
    };

?>


<div id= "barre_de_vie" >
  <li style="text-decoration: underline;font-size: 25px;" id="pseudo"><?php echo $_SESSION['pseudo'];?></li>
  <li><img src="img/Decor/coeur.png" id="coeur1"><img src="img/Decor/coeur.png" id="coeur2"><img src="img/Decor/coeur.png" id="coeur3"></li>
  <li><p id="score" style="font-size: 30px;"></p></li>
</div>

<div id="conteneur" >
  <div id='personnage_Equipe' ><?php afficheImageEquipe($bdd,'personnage',$idUser); ?></div>
  <div id='vehicule_Equipe'   ><?php afficheImageEquipe($bdd,'vehicule',$idUser); ?></div>
</div>

<img  id="meteorites" style='left:100vw'src="img/Decor/météorite2.png">

<button id="start" onclick="start()">START</button>
  
<img id="terre" src="img/Decor/terre.png">
  
<img style="width:35px;position:absolute;left:1%;cursor:pointer;bottom:2%;" src="img/Decor/parametre.png" onclick="pause(obj)">

<div id="listes_jeu">
  <br>
  <div id="liste_perso">
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


<div  id="parametre" style="visibility:hidden;" >
  <h2 onclick="pause(obj)">                                                        Resume</h2>
  <h2 onclick="document.getElementById('listes_jeu').style.visibility = 'visible'">Favoris</h2>
  <h2 onclick="window.location.reload();">                                         Restart</h2>
  <h2><a href="statistiques.php" style="text-decoration:none;color:black;">        Statistics</a></h2>
  <h2><a href="info_perso.php" style="text-decoration:none;color:black;">          About you</a></h2>
  <h2><a href="shop.php" style="text-decoration:none;color:black;">                Shop</a></h2>
  <h2><a href="index.php" style="text-decoration:none;color:black;">               Leave</a></h2> 
</div>


</body>
</html>