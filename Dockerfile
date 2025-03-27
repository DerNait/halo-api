FROM php:8.2-cli

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del proyecto (esto se hace en tiempo de build, pero usamos volume en runtime)
COPY ./app /var/www/html

# Instala dependencias de Laravel
RUN composer install

# Da permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

CMD php artisan serve --host=0.0.0.0 --port=8000

