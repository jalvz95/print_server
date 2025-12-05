# 🖨️ Print Server Simulator

Simulador web de servidor de impresión desarrollado con Laravel 11 y Alpine.js. Simula el funcionamiento completo de un servidor de impresión en red, incluyendo gestión de colas, aplicación de reglas de negocio, y visualización en tiempo real del flujo de trabajos.

## ✨ Características

### Módulos de Simulación
- **📊 Dashboard con Estadísticas** - Gráficos en tiempo real con Chart.js
- **🖥️ Servidor Básico** - Arquitectura cliente-servidor tradicional
- **🔌 Servidor Dedicado** - Dispositivo físico autónomo (hardware)
- **💾 Servidor Software** - Servicio en servidor de red
- **🖨️ Servidor Integrado** - Funcionalidad incorporada en impresora
- **☁️ Servidor Cloud** - Gestión vía servicios en línea
- **🐧 CUPS** - Common Unix Printing System
- **📊 CUPS Backend Flow** - Diagrama interactivo del flujo CUPS
- **📠 LPR/LPD** - Protocolo clásico Unix/Linux

### Funcionalidades
- ✅ Sistema de cola (spooling) con prioridades
- ✅ Gestión CRUD de reglas de negocio
- ✅ Simulación visual estilo Packet Tracer
- ✅ Procesamiento automático de trabajos
- ✅ Dashboard con métricas y gráficos
- ✅ Visualización de flujo de procesamiento CUPS
- ✅ Múltiples impresoras con diferentes estados

## 🚀 Instalación Rápida con Docker

### Requisitos Previos
- Docker Desktop instalado y corriendo
- Git (para clonar el repositorio)

### Instalación Manual

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd print_server

# 2. Construir imágenes Docker
docker-compose build

# 3. Levantar servicios
docker-compose up -d

# 4. Instalar dependencias de Composer
docker-compose exec app composer install

# 5. Copiar y configurar .env
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 6. Ejecutar migraciones y seeders
docker-compose exec app php artisan migrate --seed

# 7. Instalar dependencias de npm
docker-compose exec app npm install

# 8. Compilar assets (Tailwind CSS + Vite)
docker-compose exec app npm run build

# 9. Limpiar cachés
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

**¡Listo!** Abre http://localhost:8080 en tu navegador

---

## 🐳 Servicios Docker

El proyecto utiliza 3 contenedores:

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| **app** | - | PHP 8.2 FPM + Composer + Node.js |
| **nginx** | 8080 | Servidor web Nginx |
| **db** | 3307 | MySQL 8.0 |

### Credenciales de Base de Datos

```env
DB_HOST=db
DB_PORT=3306
DB_DATABASE=print_server
DB_USERNAME=print_user
DB_PASSWORD=print_password
MYSQL_ROOT_PASSWORD=root_password
```

---

## 📚 Uso de la Aplicación

### 1. Dashboard Principal
**Ruta:** `/dashboard`

Muestra:
- Estadísticas de trabajos (total, en cola, en proceso, bloqueados, terminados)
- Gráficos de distribución por estado, prioridad, color vs B/N
- Top usuarios y carga por impresora
- Estado detallado de impresoras
- Cuotas de usuarios

### 2. Simuladores de Servidor

Accede a diferentes módulos desde la página principal (`/`) o el menú rápido:

- **Básico** (`/servidor/basico`) - Flujo simple cliente → router → impresora
- **Dedicado** (`/servidor/dedicado`) - Dispositivo hardware independiente
- **Software** (`/servidor/software`) - Servicio centralizado en red
- **Integrado** (`/servidor/integrado`) - Impresora con servidor incorporado
- **Cloud** (`/servidor/cloud`) - Gestión cloud
- **CUPS** (`/servidor/cups`) - Sistema Unix de impresión
- **CUPS Flow** (`/servidor/cups-backend`) - Diagrama interactivo CUPS
- **LPR/LPD** (`/servidor/lpr`) - Protocolo legacy

### 3. Enviar Trabajos
**Ruta:** `/trabajos/create`

Formulario para enviar trabajos con:
- Selección de usuario
- Descripción del trabajo
- Número de páginas
- Tipo (Color o B/N)
- Prioridad (Baja=1, Normal=3, Urgente=5)

### 4. Gestionar Reglas
**Ruta:** `/reglas`

CRUD completo para reglas de negocio que se aplican automáticamente.

---

## 🎯 Datos de Prueba (Seeders)

### Usuarios Creados
1. Departamento Contabilidad (cuota: 100)
2. Departamento Recursos Humanos (cuota: 50)
3. Usuario A (cuota: 0) - ⚠️ Bloqueado por cuota
4. Usuario B (cuota: 200)
5. Estudiante Premium (cuota: 500)

### Impresoras Creadas
1. Impresora 1 - ✅ Funcional
2. Impresora 2 - ⚠️ Sin tinta
3. Impresora 3 - ⚠️ Sin hojas
4. Impresora 4 - 🔴 Desconectada

### Reglas Predefinidas
1. **Límite por Cuota Cero** (activa) - Bloquea trabajos si cuota = 0
2. **Restricción Trabajo Grande** (activa) - Reduce prioridad si >200 páginas
3. **Restricción Impresión a Color** (inactiva) - Advierte sobre trabajos a color

---

## 🛠️ Comandos Útiles

### Docker Compose

```bash
# Ver logs en tiempo real
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db

# Detener servicios
docker-compose down

# Detener y eliminar volúmenes
docker-compose down -v

# Reiniciar servicios
docker-compose restart

# Reconstruir contenedores
docker-compose up -d --build

# Acceder al shell del contenedor
docker-compose exec app sh
```

### Laravel Artisan

```bash
# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Ejecutar seeders
docker-compose exec app php artisan db:seed

# Limpiar cachés
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# Ver rutas
docker-compose exec app php artisan route:list
```

### Compilar Assets

```bash
# Desarrollo (watch mode)
docker-compose exec app npm run dev

# Producción (minificado)
docker-compose exec app npm run build
```

---

## 🔧 Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"

```bash
# Esperar a que MySQL esté listo (puede tardar 10-15 segundos)
docker-compose logs db

# Verificar que el contenedor db esté corriendo
docker-compose ps
```

### Error: "Permission denied" en storage

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Error: "Vite manifest not found"

```bash
# Recompilar assets
docker-compose exec app npm run build
```

### Los colores de Tailwind no se ven

```bash
# Recompilar assets y limpiar cache
docker-compose exec app npm run build
docker-compose exec app php artisan view:clear
```

### Base de datos vacía después de migrate

```bash
# Ejecutar seeders manualmente
docker-compose exec app php artisan db:seed
```

---

## 📁 Estructura del Proyecto

```
print_server/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php          # Dashboard con estadísticas
│   │   ├── ServidorBasicoController.php     # Simulador básico
│   │   ├── ServidorDedicadoController.php   # Simulador dedicado
│   │   ├── ServidorCupsBackendController.php # Diagrama CUPS
│   │   └── ...
│   └── Models/
│       ├── Usuario.php
│       ├── Trabajo.php
│       ├── Impresora.php
│       └── Regla.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── ImpresoraSeeder.php
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php              # Dashboard principal
│   │   ├── layouts/app.blade.php            # Layout con nav
│   │   ├── tipo-servidor/index.blade.php    # Página principal
│   │   ├── servidores/
│   │   │   ├── basico.blade.php
│   │   │   ├── dedicado.blade.php
│   │   │   ├── cups-backend.blade.php       # Diagrama CUPS
│   │   │   └── ...
│   │   └── trabajos/create.blade.php
│   ├── css/app.css                           # Tailwind CSS
│   └── js/app.js                             # Alpine.js
├── routes/
│   ├── web.php                               # Rutas web
│   └── api.php                               # API para simulación
├── docker/
│   ├── nginx/default.conf
│   └── php/local.ini
├── docker-compose.yml
├── Dockerfile
├── setup.sh                                   # Script de instalación
└── README.md
```

---

## 🎨 Tecnologías Utilizadas

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** Blade Templates, Alpine.js, Tailwind CSS
- **Gráficos:** Chart.js
- **Build:** Vite
- **Base de Datos:** MySQL 8.0
- **Contenedores:** Docker, Docker Compose
- **Servidor Web:** Nginx

---

## 📝 Notas Importantes

### Simulación Automática
- Los trabajos se procesan automáticamente cada **2 segundos**
- Tiempo de procesamiento: **páginas × 0.1 segundos**
- Orden de procesamiento: Por **prioridad** (5→3→1) y luego **FIFO**

### Reglas de Negocio
- Las reglas activas se aplican automáticamente al enviar trabajos
- Las reglas pueden **bloquear**, **advertir** o **reducir prioridad**
- Se pueden crear, editar y desactivar reglas desde `/reglas`

### Estados de Trabajo
- **Enviado** → Recién enviado
- **En Cola** → Esperando procesamiento
- **En Proceso** → Siendo impreso
- **Bloqueado** → Rechazado por regla
- **Terminado** → Completado exitosamente

---

## 🤝 Contribuir

Este es un proyecto académico. Para contribuir:
1. Fork el repositorio
2. Crea una rama (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

---

## 📄 Licencia

MIT License - ver [LICENSE](LICENSE) para más detalles

---

## 👥 Autores

Proyecto desarrollado como simulador educativo de servidores de impresión.

---

## 📧 Soporte

Si encuentras algún problema:
1. Revisa la sección de **Troubleshooting**
2. Verifica los logs: `docker-compose logs -f`
3. Asegúrate de que Docker esté corriendo
4. Verifica que los puertos 8080 y 3307 estén disponibles

---

**¡Disfruta simulando servidores de impresión!** 🖨️✨
