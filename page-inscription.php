<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>FATW-Inscrition</title>
	<link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<link rel="stylesheet"href="../css/page-inscription-connection.css">
	<style>body{background-image: url("img/Decor/fond_register.jpg");background-size: 100%;}</style>
	</head>

<body>
<center>
	<h2>
		Bienvenue sur <u style='font-size:40px;'>Fly around the world</u>,<br> un jeu d'aviation dont le but est d'esquiver des météorites. <br>
		Crée ton propre profil pour jouer et suivre ta progression et ton classement au fil du temps :
	</h2><br>

	<form name="form1" method="post" action="page-inscription.php">

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
	<center><input type="submit" name="envoi" value="Valider"  >
	<input type="reset" value="Annuler" /></center>	
</center>
	<?php
	if(isset($_POST['envoi'])){ // Si le visiteur appuie sur le bouton valider
		// Si les champs sont tous remplis
		if(!empty($_POST['Pseudo']) AND !empty($_POST['Mail']) AND !empty($_POST['MDP']) AND !empty($_POST['Nationalite'])){
			include_once 'bibliotheques/inscription-connection_fonction.php';
			inscription($bdd,$_POST['Pseudo'],$_POST['Mail'],$_POST['MDP'],$_POST['Nationalite']);
		}
		// il n'a pas rempli tous les champs alors il doit compléter
		else{echo "<center><br><h3>Veuillez renseigner tous les champs...🤦‍♂‍</h3></center>";}
	}
	
	?>		
</body>