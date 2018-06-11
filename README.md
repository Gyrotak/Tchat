# Tchat

Réalise en 4h

## Pre-requis

- PHP 5.6
- Apache2
- Mysql / MariaDB

## Installation

Le script SQL porte le nom de : database.sql

Pour configurer le T'Chat avec la base de donnée, vous pouvez modifier les valeurs dans les fichiers Models/Credential.php et Models/Chat.php

La configuration de Apache doit pointer sur le fichier index.php qui est à la racine.

## Liste des Routes

Les routes du Tchat sont les suivants :
- "/" qui correspond a l'index
- "/?section=chat" qui correspond a la page de communication entre les membres
- "/?section=?" tout autre mot pouvant aller dans section sera redirige sur la page 404

## Fonctionnalité

- Connexion/Inscription Automatique
- T'Chat avec d'autres membres connecté
- Liste de tous les messages
- Listes de tous les utilisateurs actuellement connecté


Réalisé par William Lejault alias Gyrotak
