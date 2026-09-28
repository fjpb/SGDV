# 📜 Historial de Cambios y Mantenimiento — SGDV

## [2026-09-28] — Optimización Móvil y Responsive UX/UI

### 📱 Mejoras de Navegación Móvil
- **Barra Lateral y Header (`navbar.blade.php`, `sidebar.blade.php`)**:
  - Incorporación del botón de menú hamburguesa colapsable (`navbar-toggler`) para teléfonos inteligentes.
  - Encapsulación de la navegación lateral en contenedor `.collapse.navbar-collapse` desplegable en pantallas < 992px.
  - Ajuste de `position: fixed` de la barra lateral en `sgdv-theme.css` para aplicar exclusivamente en escritorio (≥992px), eliminando el desplazamiento horizontal en smartphones.
  - Dimensionamiento de botones e ítems de menú con áreas de toque táctil optimizadas (mínimo 44px de alto).

### 🔍 Optimización del Visor Público e Inspector QR
- **Ficha Vehicular Pública (`public/vehicle.blade.php`)**:
  - Adaptación responsive de tarjetas para dispositivos móviles (<480px).
  - Botones de acción de descarga en PDF optimizados con icono, área táctil accesible y soporte de interacción móvil.
- **Visor Documental PDF (`public/document.blade.php`)**:
  - Incorporación de una barra de acciones móviles con botón prominente "Abrir / Descargar PDF directamente", solucionando las restricciones de renderizado iframe en iOS Safari y Android.

---

## [2026-09-28] — Limpieza de Repositorio y Preparación Inicial

### 🧹 Limpieza de Deuda Técnica y Residuos
- **Eliminación de archivos `.bak` y `.backup`**: Se removieron más de 100 archivos de respaldo en `src/` (controladores, vistas Blade, middleware, rutas y Service Worker).
- **Eliminación de carpetas de respaldo**: Se borraron `src/.rbac-backup-20260905` y `Dockerfile.bak-fase22-gd`.
- **Unificación de Migraciones**: Se eliminó el directorio redundante `database/migrations/` en la raíz (dejando únicamente `src/database/migrations/` como fuente oficial).
- **Eliminación de archivos huérfanos**: Se removieron los archivos de 0 bytes `active` en la raíz y en `src/active`.

### 📚 Documentación
- **README.md**: Poblado desde cero con la descripción del sistema SGDV, características, stack tecnológico, guías para Docker y despliegue a cPanel.
- **Historial de cambios**: Creación e inicialización formal de este documento `historial.md`.
