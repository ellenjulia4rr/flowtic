FROM php:8.2-fpm

# Instala pacotes
RUN apt-get update && apt-get install -y \
    git zip unzip libicu-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Instala xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Copia o Composer da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia arquivos de configuração
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Define o usuário
RUN addgroup --gid 1000 appuser && \
    adduser --disabled-password --gecos '' --uid 1000 --gid 1000 appuser

USER appuser