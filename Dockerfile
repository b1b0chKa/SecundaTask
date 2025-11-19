FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql mbstring pcntl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./SecundaTask .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www

RUN composer install --no-interaction --optimize-autoloader

CMD ["sleep", "infinity"]
