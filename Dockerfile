# Използваме официален PHP образ с вграден Apache
FROM php:8.2-apache

# Инсталираме разширението pdo_mysql, необходимо за връзка с базата данни
RUN docker-php-ext-install pdo_mysql

# Копираме всички файлове от текущата директория в работната директория на Apache
COPY . /var/www/html/

# Позволяваме на Apache да чете файловете правилно
RUN chown -R www-data:www-data /var/www/html

# Експонираме порт 80
EXPOSE 80