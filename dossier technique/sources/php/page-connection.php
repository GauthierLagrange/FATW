<!doctype html>
<html lang="fr">
<head>
	<title>FATW-Connection</title>
	<link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>body{overflow: hidden; position: absolute; width: 100%; height: 100%; margin: 0; padding: 0; background-image: url("../php/img/Decor/fond_autre_page.jpg");background-size: 100vw 100vh ;}</style>
	<link rel="stylesheet"href="../css/page-inscription-connection1.css">

</head>
<body>
<marquee behavior="alternate" direction="right">
<img src="img/Plane/BluePlane1.png">  </marquee>
<center><h2 style="background-color:white;background : transparent; background-color : transparent; color:white;
">Ceci est la page de connection de "Fly around the world"</h2><br>
<h3> Veuillez renseigner les champs suivants: </h3>
<form name="form1" method="post" action="page-connection.php">
  <center>
    Nom d'utilisateur : <input type="text" name="ID" required minlength="4" maxlength="8" autocomplete="off"/><br>
    <label for="MDP">Mot de passe : </label>
    <input type="password" name="MDP" id="MDP" required minlength="4" maxlength="15" size="17" autocomplete="off"/>
    <button type="button" id="showPassword">Afficher le mot de passe</button>
    <input type="submit" name="envoi" value="Valider" />
    <input type="reset" value="Annuler" />
  </center>
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