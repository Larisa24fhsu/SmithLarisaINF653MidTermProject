# Use an official PHP runtime as a parent image
# FROM php:8.2-apache

# Install required system packages and dependencies
# RUN apt-get update && apt-get install -y \
#    libpq-dev \
 #   && rm -rf /var/lib/apt/lists/*

# Install PostgreSQL support for PHP
#RUN docker-php-ext-install pdo_pgsql

# Enable Apache modules
#RUN a2enmod rewrite

# Set the working directory in the container
#WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
#COPY . /var/www/html/

# Copy custom Apache configuration (if you have one)
#COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Make sure Apache is set to listen on 0.0.0.0 for external access
#RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf

# Set ServerName to avoid Apache startup warnings
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80 to allow incoming connections to the container
#EXPOSE 80

# By default, Apache is started automatically. You can change or customize the startup command if necessary.
# CMD ["apachectl", "-D", "FOREGROUND"]1


FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
COPY . /var/www/html
RUN docker-php-ext-install pdo_pgsql
RUN a2enmod rewrite
RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf
EXPOSE 80
