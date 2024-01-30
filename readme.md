# Projet Laravel Dockerisé

Ce projet propose un environnement Dockerisé pour le développement Laravel, facilitant la mise en place et la gestion des dépendances. Il utilise plusieurs conteneurs Docker, chacun dédié à un composant spécifique du projet.

## Conteneurs Docker

### [PHP](document/php.md)
- Image de base : z4riix/php8-alpine
- Environnement PHP 8 sur Alpine Linux
- Configuration PHP-FPM personnalisée
- Démarrage automatique de PHP-FPM

### [Composer](document/composer.md)
- Image de base : z4riix/php8-alpine
- Installation des dépendances Composer
- Configuration du script d'entrée Docker
- Démarrage automatique de Composer

### [Nginx](document/nginx.md)
- Image de base : alpine:3.15
- Installation de Nginx
- Configuration Nginx personnalisée
- Exposition du port 8888

### [Node](document/node.md)
- Image de base : alpine:3.15
- Installation de Node.js et npm
- Installation des dépendances Node.js du projet

### [Adminer](document/adminer.md)
- Image de base : z4riix/php8-alpine
- Interface d'administration de base de données
- Exposition du port 8080

### [PostgreSQL](document/postgres.md)
- Image de base : alpine:3.15
- Installation de PostgreSQL
- Configuration PostgreSQL personnalisée
- Exposition du port 5432

## Docker Compose

### [docker-compose.yml](document/docker-compose.md)
- Orchestrer les conteneurs Docker pour un environnement de développement Laravel
- Configuration des services PHP, Composer, Nginx, Node, Adminer et PostgreSQL

## Utilisation

1. Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine.
2. Clonez ce dépôt.
3. Placez votre projet Laravel dans le répertoire approprié.
4. Utilisez `docker-compose up -d` pour démarrer les conteneurs en arrière-plan.
5. Accédez à votre application Laravel à [http://localhost:8888](http://localhost:8888).
6. Gérez la base de données PostgreSQL avec Adminer à [http://localhost:8080](http://localhost:8080).

## Notes

- Personnalisez les configurations et scripts selon les besoins spécifiques de votre projet.
- Consultez la documentation spécifique de chaque conteneur pour plus de détails.
