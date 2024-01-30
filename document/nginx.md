## Documentation de l'image Docker Nginx
### Objectif
L'image Docker Nginx est conçue pour fournir un serveur web Nginx léger et configurable. Elle est basée sur l'image **alpine:3.15** et expose le port 80.

### Configuration
Dockerfile
```dockerfile
FROM alpine:3.15

# Installez Nginx
RUN apk --no-cache add nginx

# Copiez la configuration Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Créez les répertoires nécessaires
RUN mkdir -p /var/www/html

# Ajustez les permissions du répertoire
RUN chmod -R 755 /var/www/html

# Exposez le port 80
EXPOSE 80

# Commande pour démarrer Nginx en premier plan
CMD ["nginx", "-g", "daemon off;"]
```

nginx.conf
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

    include /etc/nginx/conf.d/*.conf;

    server {
        listen 80;
        server_name localhost;

        root /var/www/html;
        index index.html;

        location / {
            try_files $uri $uri/ /index.html;
        }

        error_page 404 /404.html;
        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
            root /usr/share/nginx/html;
        }
    }
}
```

### Explication
#### 1 - Base sur alpine:3.15 :

- L'image est construite à partir de l'image **alpine:3.15** qui fournit un système d'exploitation Alpine Linux léger.
#### 2 - Installation de Nginx :

- Nginx est installé dans l'image Alpine.
#### 3 - Copie de la Configuration Nginx :

- La configuration Nginx est copiée depuis le fichier **nginx.conf** vers le répertoire **/etc/nginx/nginx.conf** du conteneur.
#### 4 - Création des Répertoires :

- Les répertoires nécessaires sont créés, notamment **/var/www/html** pour le contenu web.
#### 5 - Ajustement des Permissions :

- Les permissions du répertoire **/var/www/html** sont ajustées pour permettre l'accès au contenu.
#### 6 - Exposition du Port 80 :

- Le port 80 est exposé pour permettre l'accès aux applications web via le serveur Nginx.
#### 7 - Commande de Démarrage Nginx :

- La commande spécifiée dans **CMD** démarre Nginx en premier plan avec l'option "daemon off;".
#### Utilisation
- L'image Docker Nginx peut être utilisée pour héberger des applications web statiques ou dynamiques en tant que serveur web principal.

#### Notes
- Vous pouvez personnaliser le fichier nginx.conf pour adapter la configuration de Nginx selon les besoins spécifiques de votre application.
- Les fichiers de configuration supplémentaires peuvent être inclus dans le répertoire **/etc/nginx/conf.d/** si nécessaire.