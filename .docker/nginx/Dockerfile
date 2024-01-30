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
