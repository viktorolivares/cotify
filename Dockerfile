# Usa una imagen base oficial de PHP con extensiones necesarias para Laravel
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    npm \
    nano \
    netcat-openbsd \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
    
# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Instala dependencias de Vue/Vite
RUN npm install && npm run build

# Ajusta permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# ⚠️ Aquí desactivas los binarios de Rollup
ENV ROLLUP_NO_BINARY=true

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]