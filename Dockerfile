# Use an official PHP runtime
FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory in the container
WORKDIR /var/www/html

# Copy project files into container
COPY . /var/www/html/

# Adding Postgres support:
RUN docker-php-ext-install pdo_pgsql

COPY apache.conf /etc/apache2/sites-available/000-default.conf

#Enable Apache modules
RUN a2enmod rewrite

#set apache to bind (render only not local)
RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
