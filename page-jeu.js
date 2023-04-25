// (jeu.php) Fonction qui envoie l'URL de l'image cliqué à la page jeu.php 
// pour ensuite dans la base de données retrouver l'image qui a cette source pour l'équipé (update equipe=1) grâce à PHP.
function equipe(img,theme){
  $.ajax({
    type: 'POST',
    url: '../php/jeu.php',
    data: {srcImg:img,Theme:theme},
    success: function(response) {
        console.log(response);
        console.log('equipe');
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
console.log(conteneurTop)
var currentLine=1;// Ligne par défaut pour le personnage dans le véhicule, celle millieu( haut=0,milieu=1,bas=2)

//Fonction pour les commandes de déplacement du conteneur et de pause
document.addEventListener("keydown", function Pressed(touche) {  
  
  if (touche.key == "Escape"){pause(obj);}
  
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
console.log(meteorite.style.left);

const barre_de_vie=[
    document.getElementById('coeur1'),
    document.getElementById('coeur2'),
    document.getElementById('coeur3')]
var id;
const position_meteorite_initiale = 1 * window.innerWidth;
const debut_de_colisionLeft = 0.55 * window.innerWidth;
const fin_de_colisionLeft = 0.45 * window.innerWidth;
const finPassageMeteorite=-0.1 * window.innerWidth; //car la largeur de ma météorite c'est 10vw
var n=3

let obj={etat_Pause:0};
//Ouvre les Paramètres
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
        id = setInterval(frame(), 0);
        break;
    }
  }

// Avance la météorite et gère les coeurs
function frame(){
  speed=f(counter); // Fonction linéaire
  console.log(niv1,niv2,niv3);
  console.log(counter);

  if(niv1<=counter && counter<(niv1+5)){
    speed=vague(niv1+2.5,5) // Fonction parabolique
    console.log('niv1');
  }
  if(niv2<=counter && counter<(niv2+10)){
    speed=vague(niv2+5,10)
    console.log('niv2');
  }
  if(niv3<=counter && counter<(niv3+15)){
    speed=vague(niv2+7.5,15)
    console.log('niv3');
  }
  console.log(speed);
  
  if(pos<finPassageMeteorite){
    pos=position_meteorite_initiale;
    clearInterval(id);
    placeMeteorite();
  }
  else {
    pos-=speed
    meteorite.style.left=pos+"px"
  }
   
  // Vérifier si le météorite touche l'conteneur
  if((parseInt(meteorite.style.left) < debut_de_colisionLeft) && (parseInt(meteorite.style.left) > fin_de_colisionLeft) && (currentLine == linemeteorites)) {
    if(n>1){
      barre_de_vie[n-1].style.visibility='hidden';
      n-=1;
      clearInterval(id);
      pos=position_meteorite_initiale;
      id = setInterval(function(){frame()},1);
    }
    else{
      console.log('mort')
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
        console.log(result);
      },
      error: function(error) {
        console.log(error);
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
  console.log('placeMeteorite()')
  document.getElementById('score').innerHTML=counter;
  counter++;
  let choix = Math.floor(Math.random()* 3)  //floor=arrondi au plus bas(1.876=1)
  switch(choix){
      case 0:
      linemeteorites=0;
      meteorite.style.top = 0 +"vh";
      id = setInterval(function(){frame()},1);
      break;
      case 1:
      linemeteorites=1;
      meteorite.style.top = 18 +"vh";
      id = setInterval(function(){frame()},1);
      break;
      case 2:
      linemeteorites=2;
      meteorite.style.top = 36 +"vh";
      id = setInterval(function(){frame()},1);
      break;
      };
  };

const niv1=Math.floor(Math.random()*7+6)
const niv2=Math.floor(Math.random()*7+18)
const niv3=Math.floor(Math.random()*7+28)
console.log(niv1,niv2,niv3)

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

// Fonction linéaire suivi tout au long de la partie représentant la vitesse de la météorite
function f(x){
  return 10+25*(x/100)
}

function vague(x,duree){
  duree=duree/2;
  const abscisse_S=x
  const ordonnee_S=f(x)+5
  const a=(-5/duree**2)

  return a*(x - abscisse_S)**2 + ordonnee_S;
}

