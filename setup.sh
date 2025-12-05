#!/bin/bash

echo "🖨️  Print Server Simulator - Setup Script"
echo "=========================================="
echo ""

# Verificar si Docker está corriendo
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker no está corriendo. Por favor inicia Docker Desktop."
    exit 1
fi

echo "✅ Docker está corriendo"
echo ""

# Paso 1: Construir imágenes
echo "📦 Paso 1/8: Construyendo imágenes Docker..."
docker-compose build

# Paso 2: Levantar servicios
echo "🚀 Paso 2/8: Levantando servicios..."
docker-compose up -d

# Esperar a que MySQL esté listo
echo "⏳ Esperando a que MySQL esté listo..."
sleep 10

# Paso 3: Instalar dependencias de Composer
echo "📚 Paso 3/8: Instalando dependencias de Composer..."
docker-compose exec -T app composer install --no-interaction

# Paso 4: Copiar .env si no existe
if [ ! -f .env ]; then
    echo "📝 Paso 4/8: Copiando archivo .env..."
    docker-compose exec -T app cp .env.example .env
else
    echo "📝 Paso 4/8: .env ya existe, saltando..."
fi

# Paso 5: Generar clave de aplicación
echo "🔑 Paso 5/8: Generando clave de aplicación..."
docker-compose exec -T app php artisan key:generate

# Paso 6: Ejecutar migraciones y seeders
echo "🗄️  Paso 6/8: Ejecutando migraciones y seeders..."
docker-compose exec -T app php artisan migrate --force --seed

# Paso 7: Instalar dependencias de npm
echo "📦 Paso 7/8: Instalando dependencias de npm..."
docker-compose exec -T app npm install

# Paso 8: Compilar assets
echo "🎨 Paso 8/8: Compilando assets..."
docker-compose exec -T app npm run build

# Limpiar cache
echo "🧹 Limpiando cache..."
docker-compose exec -T app php artisan cache:clear
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan view:clear

echo ""
echo "✅ ¡Setup completado!"
echo ""
echo "🌐 La aplicación está disponible en: http://localhost:8080"
echo ""
echo "📝 Comandos útiles:"
echo "   Ver logs:        docker-compose logs -f app"
echo "   Detener:         docker-compose down"
echo "   Reiniciar:       docker-compose restart"
echo ""
