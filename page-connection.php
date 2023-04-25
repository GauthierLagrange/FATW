<!doctype html>
<html lang="fr">
<head>
	<title>FATW-Connection</title>
	<link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<style>body{background-image: url("../php/img/Decor/fond_login.jpg");background-size: 100%;}</style>
	<link rel="stylesheet"href="../css/page-inscription-connection.css">

</head>
<body>
<marquee behavior="alternate" direction="right">
<img src="img/Plane/BluePlane.png">  </marquee>
<center><h2 >Ceci est la page de connection de "Fly around the world"</h2><br>
<h3> Veuillez renseigner les champs suivants: </h3>
	<form name="form1" method="post" action="page-connection.php">
	<center>
	   👤 : <input type="text" name="ID" required
       minlength="4" maxlength="8" /><br>
	   🔒 : <input type="password" name="MDP" required
       minlength="4" maxlength="15" /><br>
	<input type="submit" name="envoi" value="Valider" />
	<input type="reset" value="Annuler" />
	</center>
	</form>
</center>

<?php		

	// S'il a appuyé sur le bouton de Validation pour s'inscrire
	if(isset($_POST['envoi'])){
		
		// Si tous les champs sont remplis
		if(!empty($_POST['ID']) AND !empty($_POST['MDP'])){
			include_once 'bibliotheques/inscription-connection_fonction.php';

			connection($bdd, $_POST['ID'], $_POST['MDP']);
			}
		else{ echo "<br><p>Veuillez renseigner tous les champs...</p>";}
		};
	?>

</body>
</html>