// (jeu.php) Fonction qui envoie l'URL de l'image cliqué à la page jeu.php 
// pour ensuite dans la base de données retrouver l'image qui a cette source pour l'équipé (update equipe=1) grâce à PHP.
function equipe(img,theme){
  $.ajax({
    type: 'POST',
    url: '../php/jeu.php',
    data: {srcImg:img,Theme:theme},
    success: function(response) {
        location.reload();
    },
    error: function(xhr, status, error) {
    }

    });
}

function changeTheme(){
  $.ajax({
    type: 'POST',
    url: '../php/jeu.php',
    data: {fonction:'changeTheme'},
    success: function(response) {
        location.reload();
    },
    error: function(xhr, status, error) {
    }

    });
}


//
// PARTIE DEPLACEMENT CONTENEUR (+ touche ECHAP = pause() )
//
var conteneur=document.getElementById('conteneur');
let conteneurTop=18;// le top pour la ligne du milieu (18vh = 18% de la hauteur de l'écran visible )
var currentLine=1;// Ligne par défaut pour le personnage dans le véhicule, celle millieu( haut=0,milieu=1,bas=2)

//Fonction pour les commandes de déplacement du conteneur et de pause
document.addEventListener("keydown", function Pressed(touche) {  
  
  if (touche.key == "Escape"){pause(obj)}
    
  if(touche.key == "ArrowUp") {
    // Vérifier si l'conteneur est déjà au sommet ( sommet=0)
    if(currentLine > 0) {
      conteneurTop -= 18; // 
      conteneur.style.top = conteneurTop + "vh"; // mettre à jour l'affichage du conteneur
      currentLine--; // indique la ligne du conteneur
    }
  } else if(touche.key == "ArrowDown") {
      // Vérifier si le conteneur est déjà en bas ( bas=2)
      if(currentLine < 2) {
        conteneurTop += 18;
        conteneur.style.top = conteneurTop + "vh"; // mettre à jour l'affichage du conteneur
        currentLine++; // indique la ligne du conteneur
      }
    }
    });

//
// PARTIE METEORITES
//
var linemeteorites;
var counter;
var meteorite = document.getElementById("meteorites");
meteorite.style.left = parseFloat(meteorite.style.left)/100*window.innerWidth +"px";

const barre_de_vie=[
    document.getElementById('coeur1'),
    document.getElementById('coeur2'),
    document.getElementById('coeur3')]
var id;
const position_meteorite_initiale = 1 * window.innerWidth;
const debut_de_colisionLeft = 0.55 * window.innerWidth;
const fin_de_colisionLeft = 0.35 * window.innerWidth;//Left de l'avion - la largeur de la météorite (10vw mais je prend 8 pour pas être trop stricte) :45-8=37
const finPassageMeteorite=-0.1 * window.innerWidth; //car la largeur de ma météorite c'est 10vw
var n=3

let obj={etat_Pause:0};
//Fonction qui ouvre ou ferme le menu de pause
function pause(objet) {
    var parametre=document.getElementById('parametre');
    document.getElementById('listes_jeu').style.visibility='hidden';
    switch(objet.etat_Pause) {
      case 0:
        parametre.style.visibility = 'visible';
        document.getElementById('start').style.visibility = 'hidden';
        objet.etat_Pause = 1;
        break;
      case 1:
        parametre.style.visibility = 'hidden';
        document.getElementById('start').style.visibility = 'visible';
        objet.etat_Pause = 0;
        break;
      case 2:
        parametre.style.visibility = 'visible';
        objet.etat_Pause = 3;
        clearInterval(id);
        break;
      case 3:
        parametre.style.visibility = 'hidden';
        objet.etat_Pause = 2; 
        id = setInterval(function(){frame()},1);
        break;
    }
  }

// Avance la météorite et gère les coeurs
function frame(){
  speed=0.0001*f(counter); // Fonction linéaire

  if(niv1<=counter && counter<(niv1+5)){
    speed=0.0001*vague(niv1+2.5,5) // Fonction parabolique
  }
  if(niv2<=counter && counter<(niv2+10)){
    speed=0.0001*vague(niv2+5,10)
  }
  if(niv3<=counter && counter<(niv3+15)){
    speed=0.0001*vague(niv2+7.5,15)
  }
  
  if( pos>=position_meteorite_initiale && (niv1<=counter && counter<=(niv1+5)) ){//Pour démarrer depuis la gauche je choisis en fonction du counter
    meteorite.style.transform="rotate(180deg)";
    pos=finPassageMeteorite;
    clearInterval(id);
    placeMeteorite();
  }
  /* //PAS REUSSI A FAIRE 1/2 -> GAUCHE/DROITE ou DROITE/GAUCHE
  else if(pos>=position_meteorite_initiale && counter>=10 && counter%2==0){//Pour démarrer depuis la gauche je choisis en fonction du counter
    console.log("A l'envers")
    pos=finPassageMeteorite;
    clearInterval(id);
    placeMeteorite();
  }
  */
  else if( pos<=finPassageMeteorite && ( (counter>=0 && counter<niv1) || counter>(niv1+5) ) ){
    meteorite.style.transform="rotate(0deg)";
    pos=position_meteorite_initiale;
    clearInterval(id);
    placeMeteorite();
  }
  else {// Si on est pas arrivé à une extrémité de l'écran on avance ou on recule selon le score

    /* //SUITE DE LA PARTIE ALTERNANT GAUCHE/DROITE DROITE/GAUCHE
    if(counter>=10 && counter%2==0){
      pos+=speed
      meteorite.style.left=pos+"px"
    }
    */
    if( (niv1<=counter && counter<=(niv1+5)) ){ // RECULE
    pos+=speed
    meteorite.style.left=pos+"px"
    }
    else{ // AVANCE
      pos-=speed
      meteorite.style.left=pos+"px"
    }
  }
   
  // Vérifier si le météorite touche l'conteneur
  if((parseInt(meteorite.style.left) < debut_de_colisionLeft) && (parseInt(meteorite.style.left) > fin_de_colisionLeft) && (currentLine == linemeteorites)) {
    var audio = document.getElementById("bruitage");
    audio.play();
    if(n>1){
      barre_de_vie[n-1].style.visibility='hidden';
      n-=1;
      clearInterval(id);
      pos=position_meteorite_initiale;
      id = setInterval(function(){frame()},1);
    }
    else{
      barre_de_vie[n-1].style.visibility='hidden';
      clearInterval(id);
      var score_final=counter-1;
      confirm("GAME OVER\n\n Ton score est de " + (score_final)+" et tu as gagné "+(score_final*5)+"🛩️"+"\n Réessaie encore "+document.getElementById('pseudo').innerHTML); // afficher le score
      $.ajax({
      url: '../php/jeu.php',
      method: 'POST',
      data: { 
        score: score_final 
      },
      success: function(result) {
      },
      error: function(error) {
      }
      });              
      document.getElementById('start').style.visibility='visible';
      document.getElementById('barre_de_vie').style.visibility='hidden';
      meteorite.style.visibility='hidden';
      obj.etat_Pause=0;
    }                    
  }
}; 

function placeMeteorite(){
  document.getElementById('score').innerHTML=counter;
  counter++;
  let choix = Math.floor(Math.random()* 3)  //floor=arrondi au plus bas(1.876=1)
  switch(choix){
      case 0:
      linemeteorites=0;
      meteorite.style.top = 0 +"vh";
      id = setInterval(function(){frame()},100000);
      break;
      case 1:
      linemeteorites=1;
      meteorite.style.top = 18 +"vh";
      id = setInterval(function(){frame()},100000);
      break;
      case 2:
      linemeteorites=2;
      meteorite.style.top = 36 +"vh";
      id = setInterval(function(){frame()},100000);
      break;
      };
  };

function sonColision() {
    var audio = document.getElementById("bruitage");
    audio.play();
  }


const niv1=Math.floor(Math.random()*7+6)
const niv2=Math.floor(Math.random()*7+18)
const niv3=Math.floor(Math.random()*7+28)

function start(){
  document.getElementById('barre_de_vie').style.visibility='visible';
  barre_de_vie.forEach(coeur=> coeur.style.visibility='visible');
  meteorite.style.visibility='visible';
  document.getElementById('start').style.visibility='hidden';
  n=3
  pos=position_meteorite_initiale;
  counter=0;
  var direction = 1; // la météorite va de droite à gauche 
  obj.etat_Pause=2; //Indique que le partie vient d'être lancée pour le menu de pause 
  meteorite.style.visibility='visible'; 
  placeMeteorite();
};

// Fonction affine suivi tout au long de la partie représentant la vitesse de la météorite
function f(x){
  return 10+25*(x/100)
}
// Revoir 
function vague(x,duree){
  duree=duree/2;
  const abscisse_S=x+duree
  const ordonnee_S=f(x+duree)+5
  const a=(-5/duree**2)

  return a*(x - abscisse_S)**2 + ordonnee_S; // d'après nos formules apprises en première sur les paraboles.
}

