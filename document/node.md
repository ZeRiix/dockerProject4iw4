## Documentation de l'image Docker Node.js

### Objectif

L'image Docker Node.js est conçue pour fournir un environnement léger avec Node.js et npm installés. Elle est basée sur l'image **alpine:3.15**.

### Configuration

Dockerfile
```dockerfile
FROM alpine:3.15

RUN echo "http://mirrors.aliyun.com/alpine/v3.15/community" >> /etc/apk/repositories

# Installez Node.js directement avec APK
RUN apk --no-cache add nodejs npm

WORKDIR /app

CMD ["node"]
```

### Explication
#### 1 - Base sur alpine:3.15 :
- L'image est construite à partir de l'image **alpine:3.15** qui fournit une base légère pour les applications.
#### 2 - Installation de Node.js et npm :
- Node.js et npm sont installés directement à l'aide de l'outil de gestion de paquets APK.
#### 3 - Configuration du Répertoire de Travail :
- Le répertoire de travail est défini sur **/app**.
#### 4 - Commande par Défaut :
- La commande par défaut est configurée pour exécuter **node**. Cela signifie que lorsqu'aucune commande spécifique n'est fournie au démarrage du conteneur, Node.js sera lancé.
### Utilisation
- Vous pouvez utiliser cette image Docker pour exécuter des applications Node.js. Assurez-vous de monter votre code source dans le répertoire **/app** du conteneur.
