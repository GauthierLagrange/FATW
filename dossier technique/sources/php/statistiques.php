<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FATW-Statistiques</title>
    <style>body{background-image:url('img/Decor/liege.jpg')} thead,td{background-color: beige;width:80px;height:25px;text-align:center;}table{background-color: black;}</style>
	<link rel="stylesheet"href="../css/page-statistiques1.css">
</head>
<body>
<?php 
 session_start();

try{
    // On se connecte à MySQL  PDO = L'extension PHP Data Object
    $bdd = new PDO('mysql:host=localhost;dbname=db_fatw;charset=utf8', 'root', '');
    }
catch(Exception $e){
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur de connection à la base de donnée : '.$e->getMessage());
    };

    // Tous les utilisateurs
    $rendu = $bdd->query("SELECT Pseudo,Nationalite FROM user_data");

    // Performance individuel
    $idActuelUser=$_SESSION['idUser'];
    $Performance_individuel = $bdd->query("SELECT COUNT(Score) AS Nb, ROUND(AVG(Score),1) AS Moy,MAX(Score) AS Max,MIN(SCORE) AS Min FROM total_games WHERE idPlayer=$idActuelUser");

    //TOP 10
    $TOP10 = $bdd->query("SELECT RANK() OVER (ORDER BY total_games.Score DESC) AS Classement, user_data.Pseudo, total_games.Score, user_data.Money
                          FROM user_data
                          INNER JOIN total_games ON user_data.idUser = total_games.idPlayer
                          WHERE total_games.Score > 0
                          GROUP BY user_data.Pseudo
                          ORDER BY total_games.Score DESC
                          LIMIT 10;");

    //TOP 3
    //Première étape : récupérer le pseudo des 3 premiers utilisateurs et leur idUser

    // Première étape sélectionner les 3 meilleurs joueurs
    $TOP3_idUser = $bdd->query("SELECT DISTINCT idUser, Pseudo FROM user_data 
                                JOIN total_games ON total_games.idPlayer = user_data.idUser 
                                ORDER BY Score DESC LIMIT 3;");
    include_once 'bibliotheques/fonctions_requetes_sql.php';
    $compteur=1;
    ?>
    <div id="conteneur">
        <?php while($row = $TOP3_idUser->fetch(PDO::FETCH_ASSOC)) : ?>
            <?php $idUser = $row['idUser']; ?>
            <div id="top-<?php echo $compteur; ?>">
                
                <div id="personnage_Equipe-<?php echo $compteur; ?>"><p style="font-size: 30px;">|<?php echo $compteur; ?>|</p><?php afficheImageEquipe($bdd,'personnage',$idUser); ?></div>
                <div id="vehicule_Equipe-<?php echo $compteur; ?>"><?php afficheImageEquipe($bdd,'vehicule',$idUser); ?></div>
                <center><h3 id="pseudo"><?php echo htmlspecialchars($row['Pseudo']); ?></h3>
                </center>
            </div>
            <?php $compteur++; ?>
        <?php endwhile; ?>
    </div>
<?php 
//TOP PAYS
$TOPPAYS = $bdd->query("SELECT RANK() OVER (ORDER BY ROUND(AVG(Score),2) DESC) AS Classement, Nationalite AS Camps,ROUND(AVG(Score),2) AS Moyennes FROM total_games INNER JOIN user_data ON total_games.idPlayer = user_data.idUser GROUP BY Nationalite ORDER BY AVG(Score) DESC;");
    
?>

<a href='jeu.php'><h3 style='background-color:grey; width:70px;height:30px;border-bottom-right-radius:10px;'>Retour</h3></a>

    <h1>Liste des joueurs</h1>
<form method="POST" action="">
  <label for="tri" style="font-size:20px;">Trier par :</label>
  <select name="tri" id="tri">
    <option value="pseudo_asc">Pseudo (A-Z)</option>
    <option value="pseudo_desc">Pseudo (Z-A)</option>
    <option value="nationalite_asc">Nationalité (A-Z)</option>
    <option value="nationalite_desc">Nationalité (Z-A)</option>
  </select>
  <button type="submit">Trier</button>
</form>

<table>
  <thead>
    <tr>
      <th>Pseudo</th>
      <th>Nationalité</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $tri = '';
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tri = $_POST['tri'];
      }

      $query = "SELECT Pseudo,Nationalite FROM user_data";

      switch ($tri) {
        case 'pseudo_asc':
          $query .= " ORDER BY pseudo ASC";
          break;
        case 'pseudo_desc':
          $query .= " ORDER BY pseudo DESC";
          break;
        case 'nationalite_asc':
          $query .= " ORDER BY nationalite ASC";
          break;
        case 'nationalite_desc':
          $query .= " ORDER BY nationalite DESC";
          break;
      }

      $resultat = $bdd->query($query);

      while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['Pseudo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Nationalite']) . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>

<br><br>

    <h1>Performance individuelle : <?php  echo $_SESSION['pseudo']; ?> </h1>
    <table>
        <thead>
            <tr>
            <th>Nombre de parties</th>
            <th>Moyenne</th>
            <th>Maximum</th>
            <th>Minimum</th>
            <th>Progrès</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $Performance_individuel->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
        <td><?php echo htmlspecialchars($row['Nb']); ?></td>
        <td><?php echo htmlspecialchars($row['Moy']); ?></td>
        <td><?php echo htmlspecialchars($row['Max']); ?></td>
        <td><?php echo htmlspecialchars($row['Min']); ?></td>
        <td><?php echo '+'.(int)htmlspecialchars($row['Max'])-(int)htmlspecialchars($row['Min']); ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

<div style="position:absolute;right:35vw;top:0px;">
<h1>TOP 10</h1>
<table >
    <thead>
        <tr>
        <th>Classement</th>
        <th>Pseudo</th>
        <th>Score</th>
        <th>Monnaie 🛩️</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $TOP10->fetch(PDO::FETCH_ASSOC)) : ?>
    <tr>
    <td><?php echo htmlspecialchars($row['Classement']); ?></td>
    <td><?php echo htmlspecialchars($row['Pseudo']); ?></td>
    <td><?php echo htmlspecialchars($row['Score']); ?></td>
    <td><?php echo htmlspecialchars($row['Money']); ?></td>

    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>


<div style="position:absolute;right:5vw;top:0px">
<h1>TOP MONDIAL</h1>
<table >
    <thead>
        <tr>
        <th>Classement</th>
        <th>Pays</th>
        <th>Scores Moyens</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $TOPPAYS->fetch(PDO::FETCH_ASSOC)) : ?>
    <tr>
    <td><?php echo htmlspecialchars($row['Classement']); ?></td>
    <td><?php echo htmlspecialchars($row['Camps']); ?></td>
    <td><?php echo htmlspecialchars($row['Moyennes']); ?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>

</body>
</html>
