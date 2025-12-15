
# 1. BASE IMAGE: Start with a secure, official PHP image that includes Apache
# This sets up the operating system, PHP interpreter, and the web server.
FROM php:8.2-apache

# 2. INSTALL EXTENSIONS: Run commands to install PHP extensions
# The mysqli extension is REQUIRED for your config.php file to connect to MySQL.
RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# 3. COPY CODE: Copy all files from your local directory (.) into the web server's root (/var/www/html/)
COPY . /var/www/html/

# 4. ENTRY POINT: The base image automatically starts the Apache server,
# making a separate START COMMAND unnecessary on Render.

# To ensure file permissions are correct (good practice)
RUN chown -R www-data:www-data /var/www/html

# EXPOSE 80 (standard HTTP port for Apache) is often implicit in the base image,
# but the service will ultimately be routed via Render's $PORT.
