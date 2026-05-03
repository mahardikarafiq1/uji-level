# Stage 1: PHP Dependencies
FROM php:8.2-fpm-alpine as php-deps

WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    icu-data-full \
    oniguruma-dev \
    libxml2-dev \
    git \
    unzip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Stage 2: Node Dependencies & Build Assets
FROM node:20-alpine as node-build

WORKDIR /var/www

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 3: Final Production Image
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install Nginx and system dependencies
RUN apk add --no-cache nginx libpng libzip icu-libs oniguruma libxml2

# Install PHP extensions needed at runtime
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Copy Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy application code from previous stages
COPY --from=php-deps /var/www/vendor /var/www/vendor
COPY --from=node-build /var/www/public/build /var/www/public/build
COPY . .

# Finish composer autoload
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 80
EXPOSE 80

# Entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
