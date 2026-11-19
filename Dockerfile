FROM php:8.2-apache

# Install the helper script for clean extension installation
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install only the required extensions (mbstring, pdo_mysql)
# This avoids recompiling curl and triggering the internal warnings
RUN install-php-extensions mbstring pdo_mysql \
    && a2enmod rewrite \
    && printf '%s\n' \
        '<Directory /var/www/html>' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/tutalink.conf \
    && a2enconf tutalink \
    && printf '%s\n' \
        'upload_max_filesize=26M' \
        'post_max_size=28M' \
        'max_execution_time=60' \
        > /usr/local/etc/php/conf.d/tutalink.ini \
    && mkdir -p /var/lib/tutalink-private/provider-documents /var/lib/tutalink-private/revision-materials \
    && chown -R www-data:www-data /var/lib/tutalink-private \
    && chmod -R 700 /var/lib/tutalink-private \
    && rm -rf /var/lib/apt/lists/*

ENV TUTALINK_ENV=production
ENV TUTALINK_PRIVATE_STORAGE_DIR=/var/lib/tutalink-private
ENV PORT=80

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
