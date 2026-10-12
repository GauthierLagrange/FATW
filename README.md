# ✈️ Fly Around The World (FATW)

> **Projet de Terminale NSI — Concours National "Trophées NSI" (Avril 2023)**  
> *Premier projet web complet conçu et développé en binôme (Développement Full-Stack & Direction Artistique).*

[![Année](https://img.shields.io/badge/Année-Avril%202023-blue.svg)](.)
[![Concours](https://img.shields.io/badge/Concours-Trophées%20NSI%202023-orange.svg)](.)
[![Stack](https://img.shields.io/badge/Stack-PHP%20%7C%20MySQL%20%7C%20Vanilla%20JS%20%7C%20CSS3-green.svg)](.)

---

## 📚 Documentation & Présentations Officielles (Guides PDF)

Ce dépôt contient l'ensemble des documents originaux rédigés pour le jury des **Trophées NSI 2023**. Selon ce que vous recherchez, voici les documents de référence à consulter :

| Document | Emplacement | Description & Utilité |
| :--- | :--- | :--- |
| 📘 **Dossier de Présentation Officiel** | [`modele-2023_presentation_FATW-Chloé-Gauthier.pdf`](./modele-2023_presentation_FATW-Chlo%C3%A9-Gauthier.pdf) | **À lire pour découvrir le projet et ses objectifs.** Présente la démarche pédagogique, les rôles respectifs de Chloé (graphisme) et Gauthier (développement), ainsi que les fonctionnalités globales. |
| 🛠️ **Document Technique Complet** | [`dossier technique/doc/document technique.pdf`](./dossier%20technique/doc/document%20technique.pdf) | **À lire pour comprendre l'architecture et lancer le jeu.** Détaillé avec schémas de base de données, arborescence, algorithmes JavaScript, explications des requêtes SQL et instructions d'installation. |
| ⚡ **Fiche Résumé** | [`Résumé FATW.pdf`](./R%C3%A9sum%C3%A9%20FATW.pdf) | **Synthèse rapide en 1 page.** Présentation express du concept, des règles et des caractéristiques du jeu. |
| 🗄️ **Base de Données Initiale** | [`dossier technique/sources/db_fatw.sql`](./dossier%20technique/sources/db_fatw.sql) | Script SQL officiel pour créer la base `db_fatw`, ses tables et insérer le catalogue des avions et personnages. |

---

## 🎯 Contexte du Projet

Ce projet a été réalisé en **avril 2023** en classe de **Terminale** dans le cadre de la spécialité **NSI (Numérique et Sciences Informatiques)**, pour concourir aux **Trophées NSI**.

Il s'agissait d'un projet mené en **binôme complémentaire** :
- **Développement Full-Stack (Gauthier)** : Conception de l'architecture logicielle, moteur de jeu en JavaScript Vanilla, communication asynchrone AJAX (jQuery), backend en PHP procédural/PDO et gestion de la base de données relationnelle MySQL.
- **Direction Artistique & Graphisme (Chloé)** : Création originale de l'ensemble des assets graphiques au format `.png` (sprites des avions aux multiples coloris, personnages "Ernest", "Poppy", "Asher", météorites, cœurs de vie, décors de fond).

### 💡 Un apprentissage autodidacte sur le tas
Ce projet constituait mon **tout premier projet web**. Réalisé sans framework ni moteur de jeu externe, tout a été découvert et conçu en autodidacte :
- Manipulation dynamique du DOM et animations CSS (`@keyframes`).
- Premières requêtes asynchrones en **AJAX** pour synchroniser les scores et achats sans recharger la page.
- Découverte du backend avec **PHP**, de la gestion des sessions utilisateur et de la modélisation relationnelle avec **MySQL**.

---

## 🕹️ Objectif & Gameplay

**Fly Around The World** est un jeu d'arcade 2D rétro où le joueur pilote un avion au-dessus de la Terre :

1. **Mécanique de jeu** :
   - Le joueur navigue sur **3 couloirs horizontaux** (Haut, Milieu, Bas).
   - Des **météorites** apparaissent de manière aléatoire sur ces trajectoires et avancent vers l'appareil.
   - Le joueur doit esquiver les obstacles pour survivre le plus longtemps possible.
2. **Contrôles** :
   - <kbd>↑</kbd> (Flèche Haut) : Monter d'un couloir de vol.
   - <kbd>↓</kbd> (Flèche Bas) : Descendre d'un couloir de vol.
   - <kbd>Échap</kbd> : Menu pause (reprendre, favoris, redémarrer, statistiques, boutique, quitter).
3. **Points de vie & Défaite** :
   - Le joueur dispose de **3 cœurs**. Chaque collision en retire un (avec effet sonore d'explosion `explosion.mp3`).
   - À 0 cœur : Fin de partie (**Game Over**) et transmission automatique du score au serveur.
4. **Vitesse & Difficulté progressive (Formule Mathématique)** :
   - La vitesse des météorites progresse selon une fonction affine :
     $$f(x) = 10 + 25 \times \frac{x}{100}$$
   - Des **vagues d'accélération temporaires** basées sur des polynômes du second degré ($a(x - x_S)^2 + y_S$) surviennent à intervalles aléatoires pour créer des pics d'intensité.
5. **Économie de jeu (Flycoins 🛩️)** :
   - À chaque partie terminée : $\text{Flycoins gagnés} = \text{Score} \times 5$.

---

## ✨ Fonctionnalités Clés

* **Authentification & Profil** :
  * Inscription avec choix de la nationalité, mot de passe chiffré (`password_hash` BCRYPT) et pack de bienvenue offert (100 Flycoins, un avion et un personnage par défaut).
  * Connexion sécurisée et gestion de session PHP.
* **Superposition dynamique Pilote / Cockpit** :
  * Grâce à une gestion précise des calques CSS (`z-index`), le personnage sélectionné apparaît directement installé dans le cockpit de son avion.
* **Boutique & Entrepôt (Shop)** :
  * Achat d'avions (ex : *La Pointe de Feuille*, *Le Blanc*, *Étoile du Ciel*, *Harpie*) et de personnages (*Ernest*, *Poppy*, *Asher*).
  * Sélection de véhicules et personnages favoris.
  * Changement d'équipement en direct depuis la boutique ou en pleine partie via le menu pause.
* **Thèmes Graphiques (Mode Sombre / Mode Clair)** :
  * Feuilles de style dédiées pour adapter l'ambiance visuelle du jeu selon les préférences du joueur (`page-jeu-clair1.css`, `page-jeu-sombre1.css`).
* **Tableau de Bord & Statistiques (SQL Avancé)** :
  * Métriques personnelles : nombre de parties, moyenne, record et score minimum.
  * **Podium Top 3** : Affichage visuel du skin et de l'avion des 3 meilleurs joueurs mondiaux.
  * **Top Pays** : Classement par nations basé sur la moyenne des scores par nationalité avec fonctions de fenêtrage SQL (`RANK() OVER (...)`).

---

## 🚀 Installation & Démarrage Rapide

Pour un guide pas à pas illustré, consultez le [document technique.pdf](./dossier%20technique/doc/document%20technique.pdf).

### 1. Prérequis
- Un serveur web local avec PHP et MySQL (ex : **XAMPP**, **WampServer**, ou **Laragon**).

### 2. Configuration de la Base de Données
1. Lancez votre serveur MySQL et ouvrez **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Créez une base de données nommée `db_fatw` avec l'encodage `utf8mb4_general_ci`.
3. Cliquez sur **Importer** et sélectionnez le fichier :  
   👉 `dossier technique/sources/db_fatw.sql`

### 3. Déploiement des Sources
1. Copiez le contenu du dossier `dossier technique/sources/` dans le répertoire web de votre serveur local :
   - XAMPP : `C:\xampp\htdocs\FATW\`
   - WampServer : `C:\wamp64\www\FATW\`
2. Ouvrez votre navigateur et accédez à :  
   👉 `http://localhost/FATW/index.php`

---

## 📁 Architecture des Dossiers

Le projet complet est structuré ainsi :

```text
FATW/
├── README.md                                          # Présentation globale & guide rapide
├── modele-2023_presentation_FATW-Chloé-Gauthier.pdf  # Dossier de présentation officielle (Concours)
├── Résumé FATW.pdf                                   # Synthèse du projet en 1 page
├── dossier technique/
│   ├── doc/
│   │   └── document technique.pdf                     # Manuel technique complet & guide d'installation
│   └── sources/                                       # Code source exécutable du projet
│       ├── db_fatw.sql                                # Dump SQL complet de la base de données
│       ├── index.php                                  # Page d'accueil du jeu
│       ├── css/                                       # Feuilles de style (mode clair, sombre, shop...)
│       ├── javascript/                                # Moteur de jeu & requêtes AJAX
│       └── php/                                       # Pages PHP, API interne & assets (img, sons)
```

---

## 👥 Auteurs
- **Développement Full-Stack** : [Gauthier](https://github.com/gauthier) — *Terminale NSI (Avril 2023)*
- **Graphismes & Direction Artistique** : Chloé — *Trophées NSI (Avril 2023)*

