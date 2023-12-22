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
    php8-zip

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
