# 🚗 SGDV — Sistema de Gestión y Documentación Vehicular

Sistema web para la administración de flotas de vehículos, control de documentación (padrones, revisiones técnicas, permisos de circulación, seguros, etc.), consulta pública mediante código QR y soporte PWA offline.

---

## 📌 Características Principales

- **Gestión de Vehículos y Flota**: Registro, actualización y ficha técnica de vehículos.
- **Control Documental con Alertas**: Carga de documentos con estado de vigencia (Vigente, Por Vencer, Vencido).
- **Acceso Público vía Código QR**: Cada vehículo posee un código QR único para validación rápida de sus documentos por parte de inspectores o personal autorizado.
- **PWA & Visor Documental Offline**: Service Worker optimizado para almacenar en caché los PDF y fichas de vehículos, permitiendo la consulta de documentos sin conexión a internet.
- **Auditoría y Reportes**: Registro de accesos a documentos y consultas de QR, con exportación de reportes ejecutivos.
- **Control de Acceso basado en Roles (RBAC)**: Gestión de usuarios con permisos delimitados.

---

## 🛠️ Stack Tecnológico

- **Backend**: Laravel (PHP 8.4) ubicado en `src/`
- **Base de Datos**: MySQL 8.0
- **Frontend & Assets**: Vite, Tailwind CSS, Blade Templates
- **PWA**: Service Worker con caché de documentos y archivos estáticos
- **Entorno de Desarrollo**: Docker Compose
- **Despliegue Producción**: Hosting Compartido / cPanel

---

## 🚀 Entorno de Desarrollo (Docker)

### Requisitos
- Docker Engine 20.10+
- Docker Compose v2+

### Puesta en Marcha
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/fjpb/SGDV.git
   cd SGDV
   ```
2. Iniciar los contenedores:
   ```bash
   docker compose up -d
   ```
3. Acceder a la aplicación:
   - Web: [http://localhost:8080](http://localhost:8080)
   - phpMyAdmin (opcional): `docker compose --profile tools up -d phpmyadmin` -> [http://localhost:8081](http://localhost:8081)

---

## 🚢 Despliegue a Producción (cPanel / Hosting Compartido)

El directorio `deploy/` incluye scripts automatizados para empaquetar y preparar las versiones de producción:

- `deploy/build.sh`: Compila assets de frontend (`npm run build`) e instala dependencias de Composer sin dev.
- `deploy/package.sh`: Genera el paquete zip comprimido para cPanel.
- `deploy/export-db.sh`: Exporta la estructura y datos de la base de datos.

---

## 📄 Guía de Desarrollo

Para ver la arquitectura detallada, reglas de código para asistentes de IA y checklist de seguridad, consultar el archivo [`geminis.md`](file:///Users/FJ/Development/SGDV/SGDV/geminis.md).
