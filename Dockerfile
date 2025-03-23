# Use an official PHP runtime
FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory in the container
WORKDIR /var/www/html

# Create logs directory and set proper permissions
RUN mkdir -p /var/log/apache2 && \
    chown -R www-data:www-data /var/log/apache2

# Copy project files into container
COPY . /var/www/html/

# Adding Postgres support:
RUN docker-php-ext-install pdo_pgsql

# Copy apache config file
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Set Apache to bind to 0.0.0.0 (for render only, not local)
RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
