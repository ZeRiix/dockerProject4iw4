## Documentation de l'image Docker PHP

### Objectif

L'image Docker PHP est conçue pour prendre en charge les applications Laravel, offrant un environnement prêt à l'emploi avec PHP, PHP-FPM, et diverses extensions nécessaires.

### Configuration

Dockerfile
```dockerfile
# Utilisez une image Alpine avec PHP et Node.js
FROM alpine:3.15

RUN echo "http://mirrors.aliyun.com/alpine/v3.15/community" >> /etc/apk/repositories

# Installez PHP et les extensions nécessaires
RUN apk --no-cache add \
    php8 \
    php8-fpm \
    php8-mysqli \
    php8-json \
    php8-openssl \
    php8-curl \
    php8-zlib \
    php8-xml \
    php8-phar \
    php8-intl \
    php8-dom \
    php8-xmlreader \
    php8-ctype \
    php8-mbstring \
    php8-gd \
    php8-tokenizer \
    php8-fileinfo \
    php8-simplexml \
    php8-xmlwriter \
    php8-bz2 \
    php8-zip \
    php8-session \
    php8-pdo_pgsql \
    php8-pdo

# Configurez PHP-FPM
COPY php-fpm.conf /etc/php8/php-fpm.conf
COPY www.conf /etc/php8/php-fpm.d/www.conf

# Créez le répertoire pour les scripts PHP
RUN mkdir -p /var/www/html

# Ajustez les permissions du répertoire de logs
RUN mkdir -p /var/log/php8 \
    && chmod -R 777 /var/log/php8 \
    && chown -R nobody:nogroup /var/log/php8

# Créez le répertoire pour le fichier PID de PHP-FPM
RUN mkdir -p /run/php-fpm8 \
    && chmod -R 777 /run/php-fpm8 \
    && chown -R nobody:nogroup /run/php-fpm8

# Démarrez PHP-FPM
CMD ["/usr/sbin/php-fpm8", "-F"]
```
php-fpm.conf
```bash
[global]
pid = /run/php-fpm8/php-fpm.pid
error_log = /var/log/php8/error.log

include=/etc/php8/php-fpm.d/*.conf
```
www.conf
```bash
[www]
user = nobody
group = nogroup

listen = 9000

pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

catch_workers_output = yes

```

### Explication
#### 1 - Base Alpine Linux avec PHP 8 et extensions :

- L'image est basée sur Alpine Linux 3.15 pour la légèreté.
- PHP 8 est installé avec diverses extensions nécessaires pour Laravel.
#### 2 - Configuration de PHP-FPM :

- Les fichiers php-fpm.conf et www.conf sont copiés pour personnaliser la configuration de PHP-FPM.
- **pm.max_children**, **pm.start_servers**, **pm.min_spare_servers**, et **pm.max_spare_servers** sont ajustés pour optimiser les performances de PHP-FPM.
#### 3 - Gestion des Permissions et des Répertoires :

- Des répertoires sont créés et configurés pour les logs, les fichiers PID et les scripts PHP.
- Les permissions sont ajustées pour garantir l'accès aux utilisateurs appropriés.
#### 4 - Démarrage de PHP-FPM :

- La commande CMD démarre PHP-FPM en mode "foreground" pour une exécution continue dans le conteneur.
#### Utilisation
- L'image Docker PHP est prête à être utilisée avec des applications Laravel. Elle fournit un environnement prêt à l'emploi pour l'exécution de scripts PHP via PHP-FPM.

#### Notes
- Assurez-vous d'ajuster les paramètres de configuration en fonction des besoins spécifiques de votre application Laravel. Vous pouvez personnaliser davantage la configuration en modifiant les fichiers **php-fpm.conf** et **www.conf** selon vos besoins.