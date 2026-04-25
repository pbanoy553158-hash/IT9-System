FROM php:8.4-apache

# =========================
# SYSTEM DEPENDENCIES
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        mbstring \
        xml \
        fileinfo \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# =========================
# APACHE CONFIG
# =========================
RUN a2enmod rewrite

# Render uses port 10000
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
&& sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
&& sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Allow .htaccess
RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
&& a2enconf laravel

# =========================
# NODE + COMPOSER
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
&& apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# PROJECT SETUP
# =========================
WORKDIR /var/www/html

COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend assets
RUN npm install
RUN npm run build

# =========================
# STORAGE + PERMISSIONS
# =========================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    public/uploads \
&& chown -R www-data:www-data storage bootstrap/cache public/uploads \
&& chmod -R 775 storage bootstrap/cache public/uploads

# Create storage link (safe)
RUN php artisan storage:link || true

# =========================
# IMPORTANT: DO NOT CACHE CONFIG HERE
# =========================
# (This is the main fix for your login issue)

RUN php artisan route:cache || true \
&& php artisan view:cache || true

# =========================
# EXPOSE PORT
# =========================
EXPOSE 10000

# =========================
# START APACHE
# =========================
CMD ["apache2-foreground"]