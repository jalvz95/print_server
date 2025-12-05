# 🚀 QUICKSTART - Para tu Compañero de Universidad

## 📋 Lo que necesitas

- ✅ Docker Desktop (descarga de https://docker.com)
- ✅ Git
- ✅ 10 minutos de tu tiempo

## ⚡ Instalación en 3 Pasos

### 1️⃣ Clonar el proyecto
```bash
git clone <URL_DEL_REPOSITORIO>
cd print_server
```

### 2️⃣ Ejecutar setup automático
```bash
./setup.sh
```

### 3️⃣ Abrir en navegador
```
http://localhost:8080
```

**¡Eso es todo!** 🎉

---

## 🖥️ ¿Qué hace el proyecto?

Es un **Simulador de Servidor de Impresión** educativo con:

- 📊 **Dashboard** con estadísticas y gráficos en tiempo real
- 🖨️ **9 tipos de servidores** para simular:
  - Básico
  - Dedicado (Hardware)
  - Software
  - Integrado
  - Cloud
  - CUPS
  - CUPS Backend Flow (diagrama interactivo)
  - LPR/LPD
  
- 📝 **Sistema de cola** con prioridades
- 🎯 **Reglas de negocio** configurables
- 🎨 **Visualización animada** tipo Packet Tracer

---

## 🎮 Cómo Usar

### Ver Dashboard
**URL:** http://localhost:8080/dashboard
- Gráficos de trabajos, usuarios, impresoras
- Estadísticas en tiempo real

### Explorar Simuladores
**URL:** http://localhost:8080
- Click en cualquier tarjeta para ver ese tipo de servidor
- Cada uno tiene su visualización animada

### Enviar Trabajo de Impresión
1. Click en "Enviar Impresión" en el menú
2. Selecciona usuario
3. Llena el formulario
4. ¡Observa cómo se procesa en tiempo real!

---

## 🛠️ Comandos Útiles

```bash
# Ver logs
docker-compose logs -f app

# Detener todo
docker-compose down

# Reiniciar
docker-compose restart

# Ver qué está corriendo
docker-compose ps
```

---

## 🐛 Problemas Comunes

### "Puerto 8080 ya en uso"
```bash
# Cambiar puerto en docker-compose.yml
# Línea 27: "8080:80" → "8081:80"
docker-compose down
docker-compose up -d
```

### "MySQL connection refused"
```bash
# Espera 10-15 segundos para que MySQL inicie
docker-compose logs db
```

### "Permission denied en setup.sh"
```bash
chmod +x setup.sh
./setup.sh
```

### "Assets/estilos no se ven"
```bash
docker-compose exec app npm run build
docker-compose exec app php artisan view:clear
# Refresca el navegador con Ctrl+Shift+R
```

---

## 📚 Documentación Completa

- **README.md** - Documentación completa del proyecto

---

## 💡 Tips

### Datos de Prueba Ya Incluidos

El sistema viene con:
- ✅ 5 usuarios de ejemplo
- ✅ 4 impresoras (con diferentes estados)
- ✅ 3 reglas de negocio predefinidas

### Credenciales Base de Datos

Si necesitas acceder a MySQL:
```
Host: localhost
Puerto: 3307 (¡no 3306!)
Database: print_server
Usuario: print_user
Password: print_password
Root Password: root_password
```

---

## 🎓 Proyecto Académico

Este es un proyecto educativo que simula:
- Arquitectura cliente-servidor
- Sistemas de cola de impresión (spooling)
- Aplicación de reglas de negocio
- Procesamiento concurrente
- Diferentes protocolos de impresión (IPP, LPR/LPD, etc.)

---

## 📧 ¿Necesitas Ayuda?

1. Revisa el **README.md** (tiene sección de troubleshooting)
2. Verifica los logs: `docker-compose logs -f`
3. Asegúrate que Docker esté corriendo
4. Verifica puertos disponibles: `lsof -i :8080`

---

**¡Disfruta el simulador!** 🖨️✨

Fecha: Diciembre 2025
Versión: 1.0.0