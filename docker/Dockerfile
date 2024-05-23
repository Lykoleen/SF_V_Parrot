# Utiliser l'image de base officielle PHP 8.1 avec Apache
FROM php:8.1-apache

# Ajouter le script d'installation des extensions PHP
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Installer les extensions PHP nécessaires
RUN install-php-extensions pdo_mysql intl zip

# Installer Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# Installer Node.js et npm
RUN apt update && apt install -yqq nodejs npm unzip

# Copier les fichiers de l'application
COPY . /var/www/

# Copier la configuration Apache personnalisée
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Copier le fichier .env
COPY .env /var/www/.env
COPY .env.local /var/www/.env.local

# Changer le propriétaire des fichiers pour éviter les problèmes de permission
RUN chown -R www-data:www-data /var/www

# Passer à l'utilisateur www-data pour éviter d'exécuter les commandes en tant que root
USER www-data

# Installer les dépendances PHP et JavaScript
RUN cd /var/www && \
    composer install --no-interaction --no-progress && \
    npm install --force && \
    npm run build

WORKDIR /var/www

# Revenir à l'utilisateur root pour les éventuelles commandes d'exécution
USER root

# Exposer le port 80 et démarrer Apache
EXPOSE 80
CMD ["apache2-foreground"]
