FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de configuración primero
COPY composer.json package.json ./
COPY composer.lock* package-lock.json* ./

# Instalar dependencias de Composer (sin optimización para desarrollo)
RUN composer install --no-scripts --no-autoloader

# Copiar resto de archivos
COPY . .

# Completar instalación de Composer
RUN composer dump-autoload --optimize --no-scripts

# Instalar dependencias de npm
RUN npm install

# Compilar assets
RUN npm run build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exponer puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]

