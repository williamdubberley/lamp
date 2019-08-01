# we are extending everything from tomcat:8.0 image ...
FROM php:apache
MAINTAINER William Dubberley
COPY index.php /var/www/html
COPY lm.css /var/www/html
COPY lm.js /var/www/html
COPY White_Papers_Banner.jpg /var/www/html
RUN docker-php-ext-install pdo pdo_mysql mysqli