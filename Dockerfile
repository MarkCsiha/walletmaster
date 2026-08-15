FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<VirtualHost/i <Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
