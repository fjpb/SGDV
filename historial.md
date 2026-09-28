# 📜 Historial de Cambios y Mantenimiento — SGDV

## [2026-09-28] — Limpieza de Repositorio y Preparación Móvil

### 🧹 Limpieza de Deuda Técnica y Residuos
- **Eliminación de archivos `.bak` y `.backup`**: Se removieron más de 100 archivos de respaldo en `src/` (controladores, vistas Blade, middleware, rutas y Service Worker) que ensuciaban el árbol de código.
- **Eliminación de carpetas de respaldo**: Se borraron `src/.rbac-backup-20260905` y `Dockerfile.bak-fase22-gd`.
- **Unificación de Migraciones**: Se eliminó el directorio redundante `database/migrations/` en la raíz (dejando únicamente `src/database/migrations/` como fuente oficial).
- **Eliminación de archivos huérfanos**: Se removieron los archivos de 0 bytes `active` en la raíz y en `src/active`.

### 📚 Documentación
- **README.md**: Poblado desde cero con la descripción del sistema SGDV, características, stack tecnológico, guías para Docker y despliegue a cPanel.
- **Historial de cambios**: Creación e inicialización formal de este documento `historial.md`.

### 🚀 Próxima Fase
- Optimización y mejoras UX/UI orientadas a dispositivos móviles (Mobile First, vistas responsive de fichas vehiculares y visor de documentos).
