## Documentation de l'image Docker PostgreSQL

### Objectif

L'image Docker PostgreSQL est conçue pour fournir un serveur PostgreSQL avec des fonctionnalités de configuration personnalisées. Elle est basée sur l'image **alpine:3.15**.

### Configuration

Dockerfile
```dockerfile
FROM alpine:3.15

RUN echo "http://mirrors.aliyun.com/alpine/v3.15/community" >> /etc/apk/repositories

# Installez PostgreSQL et les outils nécessaires
RUN apk --no-cache add postgresql postgresql-contrib libc6-compat su-exec

# Copiez le script d'entrée
COPY docker-entrypoint.sh /docker-entrypoint.sh

# Copiez le fichier de configuration PostgreSQL
COPY postgresql.conf /postgresql.conf

# Autorisez l'exécution du script
RUN chmod +x /docker-entrypoint.sh

# Exposez le port par défaut de PostgreSQL
EXPOSE 5432

# Définissez le script d'entrée comme point d'entrée du conteneur
ENTRYPOINT ["/docker-entrypoint.sh"]
```
docker-entrypoint.sh
```bash
#!/bin/sh
set -e

# Fonction pour initialiser la base de données avec les variables d'environnement
initialize_database() {
    # Initialisation de la base de données PostgreSQL
    su-exec postgres initdb -D /var/lib/postgresql/data

    # Création du répertoire pour le fichier de verrouillage
    mkdir -p /run/postgresql
    chown -R postgres:postgres /run/postgresql

    # Démarrage du serveur PostgreSQL
    su-exec postgres pg_ctl -D /var/lib/postgresql/data -o "-c listen_addresses='localhost'" -w start

    # Création de l'utilisateur et de la base de données avec les variables d'environnement
    su-exec postgres psql --command "CREATE USER $POSTGRES_USER WITH SUPERUSER PASSWORD '$POSTGRES_PASSWORD';"
    su-exec postgres createdb -O $POSTGRES_USER $POSTGRES_DB
}

# Exécutez la fonction d'initialisation seulement si la base de données n'est pas déjà initialisée
if [ ! -s /var/lib/postgresql/data/PG_VERSION ]; then
    initialize_database
fi

# Copiez les fichiers de configuration PostgreSQL
cp /postgresql.conf /var/lib/postgresql/data/postgresql.conf
chown postgres:postgres /var/lib/postgresql/data/postgresql.conf

# Autorisez les connexions locales/distantes sans mot de passe
echo "host all  all all trust" >> /var/lib/postgresql/data/pg_hba.conf

# Démarrage du serveur PostgreSQL
exec su-exec postgres postgres -D /var/lib/postgresql/data -c config_file=/var/lib/postgresql/data/postgresql.conf
```
postgresql.conf
```conf
listen_addresses = '*'
```

### Explication
#### 1 - Base sur alpine:3.15 :
- L'image est construite à partir de l'image **alpine:3.15** qui fournit une base légère pour les applications.
#### 2 - Installation de PostgreSQL et des outils nécessaires :
- PostgreSQL et les outils nécessaires sont installés avec l'outil de gestion de paquets APK.
#### 3 - Copie du Script d'Entrée Docker et du Fichier de Configuration PostgreSQL :
- Le script d'entrée Docker (docker-entrypoint.sh) et le fichier de configuration PostgreSQL (postgresql.conf) sont copiés dans le conteneur.
#### 4 - Configuration des Autorisations :
- Les autorisations sont configurées pour autoriser les connexions locales/distantes sans mot de passe.
#### 5 - Exposition du Port par Défaut :
- Le port par défaut de PostgreSQL (5432) est exposé.
#### - 6 - Point d'Entrée du Conteneur :
- Le script d'entrée Docker est défini comme point d'entrée du conteneur.
#### Utilisation
- Cette image Docker peut être utilisée pour exécuter un serveur PostgreSQL prêt à l'emploi. Assurez-vous de configurer les variables d'environnement telles que **POSTGRES_USER, POSTGRES_PASSWORD et POSTGRES_DB** pour personnaliser votre instance PostgreSQL.
