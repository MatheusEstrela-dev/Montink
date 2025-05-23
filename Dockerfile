FROM php:8.3-fpm-alpine

# Dependências do sistema + compiladores
RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    postgresql-dev \
    gnupg \
    openssl-dev \
    pkgconfig \
    autoconf g++ make re2c libtool linux-headers

# Extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Node.js e npm
RUN apk add --no-cache nodejs npm

# Instalar Swoole (Laravel Octane)
RUN pecl install swoole && docker-php-ext-enable swoole \
    && apk del autoconf g++ make re2c libtool linux-headers

# Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www
COPY . .

# Permissões
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
