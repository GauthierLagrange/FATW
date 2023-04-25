// Fonction affichant le message de confirmation d'achat
function showMessage(conteneur) {
    const money=document.body.querySelector('#money').textContent;
    console.log(money);
    const prixImg = conteneur.querySelector('#prix').textContent;
    console.log(prixImg);
    console.log('toto')

    if (money>prixImg || money==prixImg){
        // Récupérer les infos que je veux remontrer dans le message de confirmation d'achat
        const nomImg = conteneur.parentNode.querySelector('#nom').textContent;
        const sourceImg = conteneur.querySelector('img').getAttribute('src');
        
        // Met les infos voulu dans le message de confirmation
        const confirmation = document.getElementById('confirmation_achat');
        confirmation.querySelector('img').setAttribute('src', sourceImg);
        confirmation.querySelector('#nom').textContent = nomImg;
        confirmation.querySelector('#prix').textContent = prixImg;
    
    
        confirmation.style.visibility = 'visible';
    }
    else{
        console.log('pas assez');
        document.body.querySelector('.message_advert').style.visibility='visible';
    }
}   

// Fonction qui cache le message de confirmation d'achat
function cache_M(enfant){
    bloc=enfant.parentNode;
    bloc.style.visibility = 'hidden';
}
  
// Fonction qui à l'aide de requête AJAX envoie dans une variable le nom de l'image cliqué à la page php
function confir_achat(btn) {
    const confirmation = document.getElementById('confirmation_achat');
    const nomImg = btn.parentNode.querySelector("#nom").textContent;
    console.log(nomImg);
    $.ajax({
      type: 'POST',
      url: '../php/shop.php',
      data: {Nom: nomImg,fonction: 'achete'},
      success: function(response) {
          console.log(response);
          confirmation.style.visibility = 'hidden';
          console.log('achete');
          location.reload();
      },
      error: function(xhr, status, error) {
  
      }
    });
}
      
// Fonction qui envoi le nom de l'image cliqué et la fonction pour mettre en favori à exécuter à la page shop.php 
// dont on sait déjà que c'est un véhicule car les personnages n'ont pas cette fonctionnalité de mettre en favori car ils sont trop peus nombreux pour que ça soit utile
function metFav(etoile){
    var nomImg=etoile.parentNode.querySelector(".nom").textContent;
    console.log(nomImg);
    $.ajax({
      type: 'POST',
      url: '../php/shop.php',
      data: {Nom: nomImg, fonction: 'met_ou_retireFav'},
      success: function(response) {
          console.log(response);
          console.log('met_ou_retireFav');
          location.reload();
      },
      error: function(xhr, status, error) {
      }
    });
}
  
function afficheBouton(btn) {
   liste_objConcerne=btn.getAttribute("data-value")

    var liste_objConcerne=document.getElementById(liste_objConcerne)   
    var listes_objets = document.getElementById('listes_objets');
    var listes_objets_perso = document.getElementById('listes_objets_perso');
    if (liste_objConcerne.id ===  listes_objets.id ) {
      listes_objets.style.display = 'block';
      listes_objets_perso.style.display = 'none';
      document.getElementsByClassName('bouton_objets')[0].style.backgroundColor = ' rgb(100, 100, 226)';
      document.getElementsByClassName('bouton_objets_perso')[0].style.backgroundColor = 'blue';
    } 
    else {
      listes_objets.style.display = 'none';
      listes_objets_perso.style.display = 'block';
      document.getElementsByClassName('bouton_objets_perso')[0].style.backgroundColor = ' rgb(100, 100, 226)';
      document.getElementsByClassName('bouton_objets')[0].style.backgroundColor = 'blue';
    }
  }

function changeAfficheFavPerso_ou_Vehicule() {
  var vehiculeFav = document.getElementById('vehiculeFav');
  var persoFav = document.getElementById('persoFav');
  console.log(vehiculeFav.style.display)
  console.log(persoFav.style.display)
  if (vehiculeFav.style.display === 'flex') {
    vehiculeFav.style.display = 'none';
    persoFav.style.display = 'flex';
  } else {
    persoFav.style.display = 'none';
    vehiculeFav.style.display = 'flex';
  }
}