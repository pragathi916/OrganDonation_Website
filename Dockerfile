# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy all project files to the Apache web server root
COPY . /var/www/html/

# Enable mysqli if you are using MySQL
RUN docker-php-ext-install mysqli

# Expose port 80
EXPOSE 80
