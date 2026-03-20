# Use official PHP image with Apache
FROM php:8.1-apache

# Copy all files into /var/www/html in container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Expose port 10000
EXPOSE 10000

# Start Apache in foreground (Render will use this)
CMD ["apache2-foreground"]