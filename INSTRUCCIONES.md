# 🚀 Instrucciones de Inicio Rápido

## Opción 1: Docker (Recomendado)

### Paso 1: Construir las imágenes
```bash
docker-compose build
```

### Paso 2: Levantar los servicios
```bash
docker-compose up -d
```

### Paso 3: Instalar dependencias de Composer
```bash
docker-compose exec app composer install
```

### Paso 4: Instalar dependencias de npm
```bash
docker-compose exec app npm install
```

### Paso 5: Configurar entorno
```bash
# Copiar archivo .env si no existe
docker-compose exec app cp .env.example .env

# Generar clave de aplicación
docker-compose exec app php artisan key:generate
```

### Paso 6: Ejecutar migraciones y seeders
```bash
docker-compose exec app php artisan migrate --seed
```

### Paso 7: Compilar assets
```bash
docker-compose exec app npm run build
```

### Paso 8: Acceder a la aplicación
Abrir en el navegador: **http://localhost:8080**

---

## Opción 2: Desarrollo Local (sin Docker)

### Requisitos previos
- PHP 8.1 o superior
- Composer
- Node.js y npm
- MySQL o PostgreSQL

### Paso 1: Instalar dependencias
```bash
composer install
npm install
```

### Paso 2: Configurar .env
```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` y configurar la base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=print_server
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### Paso 3: Crear base de datos
```sql
CREATE DATABASE print_server;
```

### Paso 4: Ejecutar migraciones
```bash
php artisan migrate --seed
```

### Paso 5: Compilar assets
```bash
npm run dev
# O para producción:
npm run build
```

### Paso 6: Iniciar servidor
```bash
php artisan serve
```

Acceder a: **http://localhost:8000**

---

## 🐛 Solución de Problemas

### Error: "Class not found"
```bash
docker-compose exec app composer dump-autoload
```

### Error: "Permission denied" en storage
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Reconstruir contenedores
```bash
docker-compose down
docker-compose up -d --build
```

### Ver logs
```bash
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db
```

---

## 📝 Notas Importantes

- La simulación procesa trabajos automáticamente cada 2 segundos
- Los trabajos se ordenan por prioridad (5=Urgente, 3=Normal, 1=Baja)
- El tiempo de procesamiento es: `páginas × 0.1 segundos`
- Las reglas se aplican automáticamente al enviar trabajos

