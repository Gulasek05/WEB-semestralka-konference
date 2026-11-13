FROM php:8.3-apache
RUN docker-php-ext-install pdo_mysql && a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN docker-php-ext-enable opcache
RUN { echo 'opcache.enable=1'; echo 'opcache.validate_timestamps=1'; echo 'opcache.revalidate_freq=2'; } > /usr/local/etc/php/conf.d/opcache.ini