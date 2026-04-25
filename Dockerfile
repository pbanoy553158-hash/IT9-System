FROM php:8.4-apache

# =========================
# SYSTEM DEPENDENCIES
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# =========================
# ENABLE APACHE REWRITE
# =========================
RUN a2enmod rewrite

# =========================
# RENDER PORT CONFIG
# =========================
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
 && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# =========================
# SET LARAVEL PUBLIC FOLDER
# =========================
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Allow .htaccess
RUN printf "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n" > /etc/apache2/conf-available/laravel.conf \
 && a2enconf laravel

# =========================
# NODEJS (FOR VITE)
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs

# =========================
# COMPOSER
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# =========================
# COPY ONLY DEPENDENCY FILES FIRST (FIXES npm run build ERROR)
# =========================
COPY package*.json ./

RUN npm install

# =========================
# COPY FULL PROJECT
# =========================
COPY . .

# =========================
# PHP DEPENDENCIES
# =========================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# =========================
# VITE BUILD (FIXED)
# =========================
ENV NODE_ENV=production

RUN npm run build

# =========================
# LARAVEL SETUP
# =========================
RUN php artisan key:generate --force || true \
 && php artisan storage:link || true \
 && php artisan config:cache || true \
 && php artisan route:cache || true

# =========================
# PERMISSIONS
# =========================
RUN mkdir -p storage bootstrap/cache public/uploads \
 && chown -R www-data:www-data storage bootstrap/cache public/uploads \
 && chmod -R 775 storage bootstrap/cache public/uploads

# =========================
# EXPOSE PORT
# =========================
EXPOSE 10000

CMD ["apache2-foreground"]