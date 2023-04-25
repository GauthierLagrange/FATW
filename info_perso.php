<!doctype html>
<html lang="fr">
<head>
	<title>FATW-Informations Compte</title>
	<link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<style>body{width:100%;height:100%;}thead,td{background-color: beige;width:80px;height:25px;text-align:center;}table{background-color: black;}</style>

</head>
<body style="width:100%;height:100%">
<?php 

session_start();
if($_SESSION['autorise']!='oui'){
	header("location:login.php");
	exit();
	} 
else{
	try{
    	// On se connecte à MySQL  PDO = L'extension PHP Data Object
    	$bdd = new PDO('mysql:host=localhost;dbname=db_fatw;charset=utf8', 'root', '');
    	}
	catch(Exception $e){
	    // En cas d'erreur, on affiche un message et on arrête tout
	    die('Erreur de connection à la base de donnée : '.$e->getMessage());
	    };

	$idActuelUser=$_SESSION['idUser'];
	$rendu = $bdd->query("SELECT * FROM user_data WHERE idUser=$idActuelUser");
	}
?>
<center><h1><u>Informations du compte:<u></h1></center><br>
<a href='jeu.php'><h3 style='position:absolute; top:0;background-color:grey; width:70px;height:30px;border-bottom-right-radius:10px;'>Retour</a>
<br><br><br>
<center>
<div style="position: absolute;top:100px">
    <table >
        <thead >
            <tr>
            <th >Pseudo</th>
            <th>Mail</th>
            <th>Nationality</th>
			<th>Mot de passe</th>	
            <th>Money</th>	

            </tr>
        </thead>
        <tbody>
        <?php while($row = $rendu->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
        <td><?php echo htmlspecialchars($row['Pseudo']); ?></td>
        <td><?php echo htmlspecialchars($row['Mail']); ?></td>
        <td><?php echo htmlspecialchars($row['Nationalite']); ?></td>
		<td><?php echo htmlspecialchars($row['MDP']); ?></td>
		<td><?php echo htmlspecialchars($row['Money']); ?></td>

        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

<button onclick="document.getElementById('modif').style.display='block'; ">Modifier</button>
</div>
</center>

<div id="modif" style="position:absolute; display:none;top: 200px;left:150px; border:solid 3px black;">
<form name="form1" method="post">
Pseudo : <input type="text" name="Pseudo" required
   minlength="4" maxlength="8" size="30"/><br>
Mail : <input type="text" name="Mail" required
	size="37"/><br>
Mot de passe : <input type="password" name="MDP" required
   minlength="4" maxlength="15" size="17" /><br>
<center><select name="Nationalite">
	<option value="">Nationalité</option>
	<option valeur="fr">Français</option>
	<option valeur="nl">Espagnol</option>
	<option valeur="en">Anglais</option>
	<option valeur="it">Italien</option>
	<option valeur="it">Autre</option>

   </select></center>
<center><input type="submit" name="envoi" value="Valider" >
<input type="reset" value="Annuler" /></center>	
</center>
</div>
<?php
	if(isset($_POST['envoi'])){ // Si le visiteur appuie sur le bouton valider

		// Si les champs sont tous remplis
		if(!empty($_POST['Pseudo']) AND !empty($_POST['Mail']) AND !empty($_POST['MDP']) AND !empty($_POST['Nationalite'])){
			$Pseudo=$_POST['Pseudo'];
			$Mail=$_POST['Mail'];
			$MDP=md5($_POST['MDP']);
			$Nationalite=$_POST['Nationalite'];
			$bdd->query("UPDATE user_data
						 SET Pseudo='$Pseudo', Mail='$Mail', MDP='$MDP', Nationalite='$Nationalite'
						 WHERE idUser=$idActuelUser;");
			header('Location:info_perso.php');
		}	
		// il n'a pas rempli tous les champs alors il doit commpléter
		else{echo "<br><p>Veuillez renseigner tous les champs...🤦‍♂‍</p>";}
		
	}


?>

</body>
</html>