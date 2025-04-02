# Use the official PHP image from Docker Hub
FROM php:7.4-apache

# Install dependencies (e.g., Composer)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

# Enable Apache mod_rewrite (for URL routing if needed)
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY . /var/www/html/

# Expose port 80 (Apache default port)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
