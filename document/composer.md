## Documentation de l'image Docker Composer

### Objectif

L'image Docker Composer est conçue pour faciliter l'installation de dépendances dans des projets PHP en utilisant Composer. Elle est basée sur l'image **z4riix/php8-alpine** et fournit un environnement prêt à l'emploi avec Composer installé.

### Configuration

Dockefile
```dockerfile
FROM z4riix/php8-alpine AS binary-with-runtime

# Installer les dépendances nécessaires pour Composer
RUN apk --no-cache add \
    bash \
    coreutils \
    git \
    make \
    openssh-client \
    patch \
    subversion \
    tini \
    unzip \
    zip \
    curl \
    mercurial \
    p7zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php8 -- --install-dir=/usr/local/bin --filename=composer

# Copier le script d'entrée Docker
COPY docker-entrypoint.sh /docker-entrypoint.sh

WORKDIR /app

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["composer"]
```

docker-entrypoint.sh
```bash
#!/bin/bash

# Exécuter la commande Composer
/usr/bin/php8 /usr/local/bin/composer install

# Vérifier le code de retour de la commande Composer
composer_exit_code=$?

# Si la commande Composer a réussi, arrêter le conteneur
if [ "$composer_exit_code" -eq 0 ]; then
  echo "Composer install succeeded. Stopping the container."
  exit 0
else
  echo "Composer install failed."
  exit "$composer_exit_code"
fi
```

### Explication
#### 1 - Base sur z4riix/php8-alpine :

- L'image est construite à partir de l'image **z4riix/php8-alpine** qui fournit un environnement PHP 8 sur Alpine Linux.
#### 2 - Installation des Dépendances :

- Les dépendances nécessaires pour Composer, telles que bash, git, make, etc., sont installées.
#### 3 - Installation de Composer :

- Le script d'installation de Composer est téléchargé depuis le site officiel et exécuté pour installer Composer dans le répertoire **/usr/local/bin**.
#### 4 - Copie du Script d'Entrée Docker :

- Le script d'entrée Docker (docker-entrypoint.sh) est copié dans le conteneur.
#### 5 - Configuration du Répertoire de Travail :

- Le répertoire de travail est défini sur **/app**.
#### 6 - Entrée Docker et Commande par Défaut :

- L'entrée Docker est configurée pour exécuter le script **docker-entrypoint.sh**.
- La commande par défaut est définie sur **composer**, ce qui signifie que lorsqu'aucune commande spécifique n'est fournie au démarrage du conteneur, la commande **composer install** est exécutée.
#### Utilisation
- L'image Docker Composer simplifie le processus d'installation des dépendances pour les projets PHP. Vous pouvez l'utiliser en tant que conteneur autonome pour exécuter Composer.

#### Notes
- Vous pouvez personnaliser le script **docker-entrypoint.sh** pour répondre aux besoins spécifiques de votre projet.
- L'image est conçue pour arrêter automatiquement le conteneur si l'installation de Composer réussit.





