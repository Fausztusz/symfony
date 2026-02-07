# syntax=docker/dockerfile:1.6

FROM dunglas/frankenphp:php8.4

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev
RUN docker-php-ext-install \
        intl \
        zip \
        opcache \
        pdo \
        mysqli \
        pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application source
COPY . .

# Ensure permissions
RUN chown -R www-data:www-data /app

# Install PHP dependencies
RUN composer install \
    --optimize-autoloader \
    --no-interaction

# Symfony / FrankenPHP configuration
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Expose HTTP port
EXPOSE 80

# Run FrankenPHP (Caddy)
COPY Caddyfile /etc/caddy/Caddyfile
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
