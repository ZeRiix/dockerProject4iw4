## Documentation de l'image Docker Adminer

### Objectif

L'image Docker Adminer est conçue pour fournir une interface web conviviale pour la gestion de bases de données. Elle est basée sur l'image **z4riix/php8-alpine** et inclut les outils nécessaires pour interagir avec différentes bases de données.

Dockerfile
```dockerfile
FROM z4riix/php8-alpine

# Installez les outils nécessaires
RUN apk --no-cache add \
    curl \
    php8-session \
    php8-pdo \
    php8-pdo_mysql \
    php8-mysqli \
    php8-pdo_pgsql \
    php8-pgsql

# Copiez Adminer
WORKDIR /var/www/html
RUN curl -o adminer.php -L https://www.adminer.org/latest.php

# Redirection vers Adminer
RUN touch /var/www/html/index.php
RUN echo "<?php header('Location: adminer.php'); ?>" >> /var/www/html/index.php

# Copiez les fichiers nécessaires depuis l'image z4riix/composer
COPY --from=z4riix/composer /usr/local/bin/composer /usr/local/bin/composer
COPY --from=z4riix/composer /docker-entrypoint.sh /docker-entrypoint.sh

# Ajustez les permissions
RUN chmod +x /usr/local/bin/composer /docker-entrypoint.sh

# Activer le pilote PostgreSQL pour PHP
RUN echo "extension=pdo_pgsql.so" > /etc/php8/conf.d/00_pdo_pgsql.ini
RUN echo "extension=pgsql.so" > /etc/php8/conf.d/01_pgsql.ini

# Démarrez PHP-FPM
CMD ["/usr/sbin/php-fpm8", "-F"]
```
### Explication
#### 1 - Base sur z4riix/php8-alpine :

- L'image est construite à partir de l'image **z4riix/php8-alpine** qui fournit un environnement PHP 8 sur Alpine Linux.
#### 2 - Installation des Outils :

- Les outils nécessaires tels que curl et les extensions PHP pour la gestion des bases de données (MySQL, PostgreSQL) sont installés.
#### 3 - Téléchargement et Installation d'Adminer :

- Adminer, une interface web de gestion de bases de données, est téléchargé depuis le site officiel et placé dans le répertoire web.
#### 4 - Redirection vers Adminer :

- Un fichier **index.php** est créé pour rediriger automatiquement vers Adminer lors de l'accès à la racine du serveur.
#### 5 - Copie des Fichiers Composer :

- Les fichiers Composer nécessaires sont copiés depuis l'image **z4riix/composer** pour faciliter l'installation de dépendances dans des projets PHP.
#### 6 - Activation du Pilote PostgreSQL pour PHP :

- Les extensions PHP pour le support PostgreSQL sont activées dans la configuration PHP.
#### 7 - Démarrage de PHP-FPM :

La commande CMD démarre PHP-FPM en mode "foreground" pour une exécution continue dans le conteneur.
#### Utilisation
- L'image Docker Adminer peut être utilisée pour accéder et gérer des bases de données via une interface web. L'accès à Adminer se fait en visitant la racine du serveur où le fichier **index.php** redirige automatiquement vers Adminer.

#### Notes
- Assurez-vous de personnaliser la configuration PHP en fonction des besoins spécifiques de votre application.
- L'image inclut des outils Composer pour faciliter l'installation de dépendances dans des projets PHP.