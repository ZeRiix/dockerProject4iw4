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