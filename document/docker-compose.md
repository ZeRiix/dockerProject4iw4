## Documentation Docker-Compose pour un Projet Laravel

### Objectif

Le fichier `docker-compose.yml` fournit une configuration Docker pour un projet Laravel, avec des services tels que PHP, Composer, Nginx, Node.js, Adminer, et PostgreSQL. Il est conçu pour faciliter le développement, l'installation de dépendances, et l'exécution du projet Laravel dans un environnement Docker.

### Configuration

#### docker-compose.yml

```yaml
version: "3.7"
services:
  php:
    restart: always
    tty: true
    image: z4riix/php8-alpine
    volumes:
      - ./laravel:/var/www/html # Vérifiez le chemin de votre projet Laravel
    command: /usr/sbin/php-fpm8 -F

  composer:
    image: z4riix/composer
    volumes:
      - ./laravel:/app
    depends_on:
      - php

  nginx:
    restart: always
    image: z4riix/nginx
    volumes:
      - ./laravel:/var/www/html
      - ./conf/nginx.conf:/etc/nginx/nginx.conf
    ports:
      - "8888:80"
    depends_on:
      - php

  node:
    image: z4riix/node
    volumes:
      - ./laravel:/app # Vérifiez le chemin de votre projet Laravel
    command: npm install
    depends_on:
      - php

  adminer:
    image: z4riix/adminer
    restart: always
    ports:
      - "8080:8080"
    command: /usr/bin/php8 -S 0.0.0.0:8080 -t /var/www/html

  postgres:
    image: z4riix/postgres
    restart: always
    environment:
      POSTGRES_USER: laravel 
      POSTGRES_PASSWORD: laravel
      POSTGRES_DB: laravel
    ports:
      - "5432:5432"
```

#### nginx.conf

```nginx
user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log;
pid /var/run/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';

    access_log /var/log/nginx/access.log main;

    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;

    include /etc/nginx/conf.d/*.conf;  # Cette ligne est importante pour inclure les configurations de virtual hosts.

    server {
        listen 80;
        server_name localhost;

        root /var/www/html/public;  # Mettez le chemin correct vers le dossier public de Laravel

        index index.php index.html index.htm;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            fastcgi_pass php:9000;  # Correspond au nom du service PHP dans docker-compose.yml
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
        }

        error_log  /var/log/nginx/error.log;
        access_log /var/log/nginx/access.log;
    }
}
```
### Explication
#### 1 - Service PHP :
- Le service PHP utilise l'image **z4riix/php8-alpine** pour exécuter PHP-FPM.
- Les fichiers du projet Laravel sont montés dans le répertoire /var/www/html.
- La commande **/usr/sbin/php-fpm8 -F** est utilisée pour démarrer PHP-FPM en premier plan.
#### 2 - Service Composer :
- Le service Composer utilise l'image **z4riix/composer** pour installer les dépendances du projet Laravel.
- Les fichiers du projet Laravel sont montés dans le répertoire **/app**.
- Ce service dépend du service PHP.
#### 3 - Service Nginx :
- Le service Nginx utilise l'image **z4riix/nginx** pour servir le projet Laravel.
- Les fichiers du projet Laravel et la configuration Nginx sont montés dans les répertoires appropriés.
- Nginx écoute sur le port **8888** et redirige vers le port **80** du conteneur.
- Ce service dépend du service PHP.
#### 4 - Service Node.js :
- Le service Node.js utilise l'image **z4riix/node** pour exécuter la commande npm install.
- Les fichiers du projet Laravel sont montés dans le répertoire **/app**.
- Ce service dépend du service PHP.
#### 5 - Service Adminer :
- Le service Adminer utilise l'image **z4riix/adminer** pour fournir une interface d'administration de base de données.
- Adminer écoute sur le port **8080**.
- Ce service ne dépend d'aucun autre.
#### 6 - Service PostgreSQL :
- Le service PostgreSQL utilise l'image **z4riix/postgres**.
- Les variables d'environnement **POSTGRES_USER, POSTGRES_PASSWORD et POSTGRES_DB** sont configurées.
- PostgreSQL écoute sur le port **5432**.
- Ce service ne dépend d'aucun autre.


### Utilisation
1. Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine.
2. Placez le fichier docker-compose.yml à la racine de votre projet Laravel.
3. Exécutez `docker-compose up -d` pour démarrer les conteneurs en arrière-plan.
4. Accédez à votre application Laravel à l'adresse [http://localhost:8888](http://localhost:8888).
5. Accédez à l'interface Adminer à l'adresse [http://localhost:8080](http://localhost:8080) pour gérer la base de données PostgreSQL.
