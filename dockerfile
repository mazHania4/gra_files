# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las dependencias necesarias para compilar la extensión de MongoDB
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev pkg-config libssl-dev \
    && apt-get install -y unzip

# Instala la extensión de MongoDB mediante PECL
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código de tu proyecto a la carpeta donde Apache servirá archivos
COPY ./src/ /var/www/html/

# Instala las dependencias del proyecto desde composer.json
WORKDIR /var/www/html
RUN composer install

# Da permisos a la carpeta de trabajo
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80 para que el contenedor sea accesible desde fuera
EXPOSE 80
