# 🖨️ Simulación de Servidor de Impresión

Aplicación web desarrollada con Laravel que simula el funcionamiento de un servidor de impresión en una red. La aplicación gestiona trabajos de impresión, aplica reglas de negocio y visualiza el flujo en tiempo real.

## 🚀 Características

- **Simulación de Envío de Trabajos**: Formulario para enviar trabajos de impresión con diferentes configuraciones
- **Gestión de Cola**: Sistema de cola (spooling) que procesa trabajos según prioridad
- **Reglas de Negocio**: Sistema CRUD para gestionar reglas que aplican restricciones y políticas
- **Visualización en Tiempo Real**: Dashboard interactivo que muestra el flujo de trabajos usando Alpine.js
- **Dockerización Completa**: Configuración Docker para despliegue independiente

## 📋 Requisitos

- Docker y Docker Compose
- PHP 8.1 o superior
- Composer
- Node.js y npm (para desarrollo local)

## 🐳 Instalación con Docker

1. **Clonar o descargar el proyecto**

2. **Construir las imágenes Docker:**
   ```bash
   docker-compose build
   ```

3. **Levantar los servicios:**
   ```bash
   docker-compose up -d
   ```

4. **Instalar dependencias de Composer (dentro del contenedor):**
   ```bash
   docker-compose exec app composer install
   ```

5. **Instalar dependencias de npm (dentro del contenedor):**
   ```bash
   docker-compose exec app npm install
   ```

6. **Configurar el archivo .env:**
   ```bash
   cp .env.example .env
   ```
   Editar `.env` si es necesario (las configuraciones por defecto funcionan con Docker).

7. **Generar la clave de aplicación:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

8. **Ejecutar migraciones y seeders:**
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

9. **Compilar assets (CSS/JS):**
   ```bash
   docker-compose exec app npm run build
   ```

10. **Acceder a la aplicación:**
    Abrir en el navegador: `http://localhost:8080`

## 🛠️ Desarrollo Local (sin Docker)

1. **Instalar dependencias:**
   ```bash
   composer install
   npm install
   ```

2. **Configurar .env:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configurar base de datos en .env:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=print_server
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Ejecutar migraciones:**
   ```bash
   php artisan migrate --seed
   ```

5. **Compilar assets:**
   ```bash
   npm run dev
   ```

6. **Iniciar servidor:**
   ```bash
   php artisan serve
   ```

## 📁 Estructura del Proyecto

```
print_server/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TrabajoController.php
│   │   │   ├── ReglaController.php
│   │   │   └── SimulacionController.php
│   │   └── Middleware/
│   └── Models/
│       ├── Usuario.php
│       ├── Trabajo.php
│       └── Regla.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php
└── docker-compose.yml
```

## 🎯 Uso

### Enviar un Trabajo

1. Navegar a "Enviar Trabajo" desde el menú
2. Seleccionar un usuario
3. Completar los campos del formulario
4. El trabajo se agregará a la cola automáticamente

### Gestionar Reglas

1. Ir a "Reglas" desde el menú
2. Crear, editar o eliminar reglas según necesidad
3. Las reglas activas se aplican automáticamente a los trabajos

### Dashboard

El dashboard muestra:
- Estadísticas en tiempo real
- Flujo visual de trabajos (Envío → Cola → Procesamiento → Historial)
- Lista de usuarios y sus cuotas
- Actualización automática cada 2 segundos

## 🔧 Reglas Predefinidas

El seeder incluye tres reglas de ejemplo:

1. **Límite por Cuota Cero**: Bloquea trabajos si el usuario tiene cuota 0
2. **Restricción Trabajo Grande**: Reduce la prioridad de trabajos con más de 200 páginas
3. **Restricción Impresión a Color**: Advierte sobre trabajos a color (inactiva por defecto)

## 🐳 Comandos Docker Útiles

- **Ver logs:**
  ```bash
  docker-compose logs -f app
  ```

- **Ejecutar comandos artisan:**
  ```bash
  docker-compose exec app php artisan [comando]
  ```

- **Detener servicios:**
  ```bash
  docker-compose down
  ```

- **Reconstruir contenedores:**
  ```bash
  docker-compose up -d --build
  ```

## 📝 Notas

- La simulación procesa trabajos cada 2 segundos automáticamente
- El tiempo de procesamiento se calcula como: `páginas × 0.1 segundos`
- Los trabajos se ordenan por prioridad (5 = Urgente, 3 = Normal, 1 = Baja) y luego por tiempo de envío (FIFO)

## 📄 Licencia

MIT

