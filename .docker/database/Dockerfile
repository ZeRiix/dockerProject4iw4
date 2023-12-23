FROM alpine:3.15

RUN echo "http://mirrors.aliyun.com/alpine/v3.15/community" >> /etc/apk/repositories

# Installez PostgreSQL et les outils nécessaires
RUN apk --no-cache add postgresql postgresql-contrib libc6-compat su-exec

#Variables d'environnement
ENV POSTGRES_USER=myuser \
    POSTGRES_PASSWORD=mypassword \
    POSTGRES_DB=mydatabase

# Initialisez la base de données PostgreSQL
RUN mkdir -p /run/postgresql && chown -R postgres:postgres /run/postgresql && \
    su-exec postgres initdb -D /var/lib/postgresql/data && \
    su-exec postgres pg_ctl -D /var/lib/postgresql/data -o "-c listen_addresses='localhost'" -w start && \
    su-exec postgres psql --command "CREATE USER $POSTGRES_USER WITH SUPERUSER PASSWORD '$POSTGRES_PASSWORD';" && \
    su-exec postgres createdb -O $POSTGRES_USER $POSTGRES_DB

# Copier les fichiers de configuration PostgreSQL
COPY ./postgresql.conf /var/lib/postgresql/data/postgresql.conf

# Modifier les autorisations des fichiers de configuration PostgreSQL
RUN chown -R postgres:postgres /var/lib/postgresql/data/postgresql.conf

# Autoriser les connexions locales/distantes sans mot de passe
RUN echo "host all  all all trust" >> /var/lib/postgresql/data/pg_hba.conf

# Exposez le port par défaut de PostgreSQL
EXPOSE 5432

# Démarrez le serveur PostgreSQL
USER postgres
CMD ["postgres", "-D", "/var/lib/postgresql/data", "-c", "config_file=/var/lib/postgresql/data/postgresql.conf"]
