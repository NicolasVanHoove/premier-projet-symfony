# Présentation 

Ce projet a pour but de mettre en avant ce que j'ai appris sur le framework Symfony au cours de ma formation développeur web chez o'clock qui est sur le point de se terminer. 
J'ai choisi d'utiliser la version skeleton de symfony est d'installer moi-même tous les composants dont j'avais besoin (Vous trouverez la liste des composants dans le composer.json)
Réalisation selon le patron de conception MVC. Programmation Orientée Objet.

Ce projet de développement tourne autour des voitures. J'ai crée un front office qui permet l'affichage des modèles mais aussi des marques pour l'utilisateur. 
J'ai également mis en place un BackOffice permettant de gérer les données de l'application (Browse, Read, Edit, Add, Delete). 
La sécurité nécessaire par rapport à la vulnérabilité CSRF est incluse dans l'application. 
J'ai mis en place une BDD relationnelle pour stocker les données necessaires au fonctionnement de l'application. 

Ce projet n'est pas complètement terminé (consulter la section "Fonctionnalités à venir")

# Technologies Utilisées 

- Symfony
- Doctrine (ORM)
- Twig comme moteur de templates
- MariaDB pour gérer la Base De Données
- HTML, CSS et Bootstrap pour l'intégration web

# Fonctionnalités à venir

- Créer des comptes utilisateurs avec sécurisation des mots de passe grâce au 'Password Hasher' de symfony 
- Mise en place d'un système de loggin loggout
- Mis en place des ACL pour gérer l'accès aux routes en fonction des rôles attribués aux différents utilisateurs 

