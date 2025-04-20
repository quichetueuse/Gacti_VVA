# Gacti VVA - Site de gestion d'activités et animations de vacances

## Présentation

Site web léger réalisé en PHP permettant la gestion d'activités et d'animations d'une chaine de village de vacances dans les Alpes. Ce projet a été réalisé dans le cadre de la validation de mon BTS SIO option SLAM.

## Conception

Les diagrammes suivants représentent la conception technique du projet :

### Diagramme des cas d'utilisation

![UseCase](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/USECASES.PNG)

### Modèle Conceptuel de Données

![MCD](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/MCD.PNG)

## Aperçu des interfaces

### Page de connexion

![Page de connexion](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/login.PNG)

### Dashboard animations et activités (vu par un encadrant)

![Dashboard animations et activités encadrant](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/vue-admin.PNG)

### Dashboard animations et activités (vu par un vacancier)

![Dashboard animations et activités vacancier](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/vue-vacancier.PNG)

### Dashboard animations et activités (vu par un utilisateur non connecté)

![Dashboard animations et activités utilisateur non connecté](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/non-connecte.PNG)

### Page d'ajout d'une activité

![Page ajout activité](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/add-act.PNG)

### Page modification activité

![page modification acivité](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/edition-act.PNG)

### Page d'ajout d'une animation

![Page ajout animation](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/add-anim.PNG)

### Page modification animation

![page modification animation](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/edit-anim.PNG)

### Page de vue des différents inscrits à une activité

![page vue inscrit](https://github.com/quichetueuse/Gacti_VVA/blob/master/ReadMeImages/vue-inscrit.PNG)

## Fonctionnalités

### Utilisateur non connecté

- Visualisation des différents activités et animations disponibles

### Vacancier

- Inscription aux activités disponibles
- Visualisation des différents activités et animations disponibles

### Encadrant

- Ajout, Modification, Suppression, visualisation des différentes activités
- Ajout, Modification, Suppression, visualisation des différentes animations

## Identifiants de connexion

**Les mots de passe utilisés ne reflètent pas les règles utilisées pour la saisie des mots de passe dans l'application.**

### Comptes Encadrant

- **identifiant**: admin.admin@gmail.com
- **Mot de passe**: azef1

- **identifiant**: daniel.montalou@free.fr
- **Mot de passe**: azef2

- **identifiant**: emmanuel.smadja@mpowerfinancing.org
- **Mot de passe**: azef4

- **identifiant**: kevin.passemoitou@yahoo.free
- **Mot de passe**: azef3

### Comptes Vacancier

- **identifiant**: theo.cabrelli@orange.fr
- **Mot de passe**: azef5

- **identifiant**: diya.addala@sfr.com
- **Mot de passe**: azef9

- **identifiant**: kylliann.balain@monlycee.net
- **Mot de passe**: azef7

- **identifiant**: william.fourcade2sn@gmail.com
- **Mot de passe**: azef8

- **identifiant**: bauchet.remy@gmx.com
- **Mot de passe**: azef6

## Configuration technique

### Prérequis

- Navigateur web (testé sur google chrome)
- Serveur LAMP (Linux Apache MySQL PHP)
- PHP 7 minimum

### Installation

1. Clonez le dépot git sur lequel vous êtes
2. Importez `gacti.sql` dans la base de données du serveur LAMP
3. Ouvrez le projet dans le navigateur
