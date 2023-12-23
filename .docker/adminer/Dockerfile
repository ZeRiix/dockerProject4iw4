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

# redirect
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