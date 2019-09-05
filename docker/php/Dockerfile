FROM php:7.2-fpm

ARG SYS_USER
ARG UID

RUN apt-get install -y git unzip icu-dev bash build-base autoconf; \
    docker-php-ext-install intl opcache; \
    pecl install xdebug-stable; \
    docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && \
    apt-get install -my vim

RUN useradd -m --uid=${UID} ${SYS_USER}

WORKDIR /var/www/html

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN apt-get install -y ruby && \
    apt-get install -y zip && \
    apt-get install libzip-dev -y && \
    apt-get install poppler-utils -y

RUN pecl install zlib zip
RUN docker-php-ext-install -j$(nproc) zip

RUN chown ${SYS_USER} /var/www/html

RUN touch $PHP_INI_DIR/php.ini

RUN echo 'upload_max_filesize=10M' >> $PHP_INI_DIR/php.ini
RUN echo 'post_max_size=10M' >> $PHP_INI_DIR/php.ini

USER ${SYS_USER}
