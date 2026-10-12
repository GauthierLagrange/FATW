<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>FATW-Inscrition</title>
	<link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet"href="../css/page-inscription-connection1.css">
	<style>body{overflow: hidden; position: absolute; width: 100%; height: 100%; margin: 0; padding: 0; background-image: url("img/Decor/fond_autre_page.jpg");background-size: 100vw 100vh ;}</style>
	</head>

<body>
<center>
	<h2 style="color:white;">
		Bienvenue sur <u style='font-size:40px;'>Fly around the world</u><br><br><br>
		Crée ton profil pour jouer et suivre ta progression au fil du temps :
	</h2>

	<form name="form1" method="post" action="page-inscription.php">
  <label for="Pseudo">Pseudo :</label>
  <input type="text" name="Pseudo" required minlength="4" maxlength="8" size="30" autocomplete="off"/><br>
  <label for="Mail">Mail :</label>
  <input type="text" name="Mail" required size="37" autocomplete="off"/><br>
  <label for="MDP">Mot de passe :</label>
  <input type="password" name="MDP" id="MDP" required minlength="4" maxlength="15" size="17" autocomplete="off"/>
  <button type="button" id="showPassword">Afficher le mot de passe</button><br>
  <label for="Nationalite">Nationalité :</label>
  <select name="Nationalite">
    <option value="">Nationalité</option>
    <option value="fr">Français</option>
    <option value="nl">Espagnol</option>
    <option value="en">Anglais</option>
    <option value="it">Italien</option>
    <option value="autre">Autre</option>
  </select><br>
  <div style="text-align:center;">
    <input type="submit" name="envoi" value="Valider" >
    <input type="reset" value="Annuler" />
  </div>
</form>

<script>
$(document).ready(function() {
  $('#showPassword').click(function() {
    var x = $('#MDP');
    if (x.attr('type') === 'password') {
      x.attr('type', 'text');
      $('#showPassword').text('Cacher le mot de passe');
    } else {
      x.attr('type', 'password');
      $('#showPassword').text('Afficher le mot de passe');
    }
  });
});
</script>
	<?php
	if(isset($_POST['envoi'])){ // Si le visiteur appuie sur le bouton valider
		// Si les champs sont tous remplis
		if(!empty($_POST['Pseudo']) AND !empty($_POST['Mail']) AND !empty($_POST['MDP']) AND !empty($_POST['Nationalite'])){
			include_once 'bibliotheques/inscription-connection_fonction.php';
			inscription($bdd,$_POST['Pseudo'],$_POST['Mail'],$_POST['MDP'],$_POST['Nationalite']);
		}
		// il n'a pas rempli tous les champs alors il doit compléter
		else{echo "<center><br><h3 style='color:white;'>Veuillez renseigner tous les champs...🤦‍♂‍</h3></center>";}
	}
	
	?>		
</body>