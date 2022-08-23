FROM php:7.4.30-apache
ENV SERVER_NAME='subject-tsutsui.com'
ENV APACHE_DOCUMENT_ROOT='/var/www/app/public'
ENV DIRECTORY_INDEX='login.php'
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR ${APACHE_DOCUMENT_ROOT}/../../
COPY composer.json .
RUN apt update && apt upgrade -y\
    && apt install git -y\
    && docker-php-ext-install pdo_mysql\
    && composer install
WORKDIR ${APACHE_DOCUMENT_ROOT}