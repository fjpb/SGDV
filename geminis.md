🚀 SGDV — Guía de Inicio del Proyecto (geminis.md)

Documento de referencia para desarrolladores y asistentes de IA (Gemini, Claude, Copilot…) que trabajen en SGDV. Repositorio: https://github.com/fjpb/SGDV

Stack: Laravel (en src/) · PHP 8.4 + Apache · MySQL 8.0 · Vite/Node · phpMyAdmin (solo desarrollo) Producción: hosting compartido/cPanel (sin Docker) · Desarrollo: Docker Compose Versión del documento: 3.0

📑 Índice
Sobre el proyecto
Requisitos previos
Estructura real del repositorio
Entorno de desarrollo (Docker)
Puesta en marcha
Comandos útiles
Seguridad
Despliegue a producción
Reglas para asistentes de IA
Solución de problemas
Pendientes y deuda técnica detectada
Checklist antes de un commit / despliegue
📌 1. Sobre el proyecto
Campo	Valor
Nombre	SGDV
Descripción	Completar: significado de la sigla, objetivo y usuarios. (La descripción actual del repo dice «papele der auto»)
Módulos principales	Completar
Roles / permisos (RBAC)	Completar: paquete usado (p. ej. spatie/laravel-permission) y lista de roles
Fases de desarrollo	Completar: registro de fases (el repo menciona fase22)

💡 El README.md del repositorio está vacío. Esta sección puede copiarse allí.

🛠️ 2. Requisitos previos
Herramienta	Versión mínima	Verificar con
Docker Engine / Desktop	20.10+	docker --version
Docker Compose (plugin v2)	2.0+	docker compose version
Git	2.30+	git --version

PHP, Composer y Node corren dentro del contenedor app; no hace falta instalarlos en tu máquina.

🗂️ 3. Estructura real del repositorio
text
SGDV/
├── src/                          # Aplicación Laravel completa (composer.json, artisan, app/, routes/…)
├── database/migrations/          # ⚠️ Migraciones en la raíz (ver sección 11)
├── docker/
│   └── apache/000-default.conf   # VirtualHost de Apache (DocumentRoot debe ser .../public)
├── deploy/                       # Material de despliegue (documentar su contenido aquí)
├── Dockerfile                    # Imagen PHP 8.4 + Apache + Node
├── Dockerfile.bak-fase22-gd      # ⚠️ Respaldo: eliminar del repo (ver sección 11)
├── docker-compose.yml
├── .env.production.example       # Plantilla de producción (sin secretos)
├── .gitignore
├── active                        # ⚠️ Archivo sin documentar (ver sección 11)
└── README.md                     # Vacío

Convención clave: el proyecto Laravel vive en src/, que se monta en /var/www/html. Todos los comandos de artisan, composer y npm se ejecutan dentro del contenedor, donde ya estás posicionado en la raíz de Laravel.

🏗️ 4. Entorno de desarrollo (Docker)
text
 Navegador ──► [ app: Apache + PHP 8.4 :8080 ] ──► [ mysql :3306 ]
                    └─ Vite :5173                     ▲
                                        [ phpmyadmin :8081 ] (perfil "tools")

Todos los puertos se publican solo en 127.0.0.1 para que nadie de tu red pueda acceder a la base de datos ni a phpMyAdmin.

4.1 docker-compose.yml (propuesto)
yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: sgdv_app
    restart: unless-stopped
    ports:
      - "127.0.0.1:8080:80"
      - "127.0.0.1:5173:5173"
    volumes:
      - ./src:/var/www/html
    depends_on:
      mysql:
        condition: service_healthy

  mysql:
    image: mysql:8.0
    container_name: sgdv_mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD:?Define MYSQL_ROOT_PASSWORD en .env}
      MYSQL_DATABASE: ${MYSQL_DATABASE:-sgdv}
      MYSQL_USER: ${MYSQL_USER:-sgdv}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD:?Define MYSQL_PASSWORD en .env}
    ports:
      - "127.0.0.1:3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    healthcheck:
      test: ["CMD-SHELL", "mysqladmin ping -h localhost -uroot -p\"$$MYSQL_ROOT_PASSWORD\" --silent"]
      interval: 10s
      timeout: 5s
      retries: 10
      start_period: 30s

  # Solo cuando lo necesites: docker compose --profile tools up -d phpmyadmin
  phpmyadmin:
    image: phpmyadmin:5
    container_name: sgdv_phpmyadmin
    profiles: ["tools"]
    restart: unless-stopped
    ports:
      - "127.0.0.1:8081:80"
    environment:
      PMA_HOST: mysql
    depends_on:
      - mysql

volumes:
  mysql_data:

Qué cambia respecto al compose actual:

Credenciales (root/root, sgdv/sgdv) fuera del archivo → variables de un .env en la raíz del repo (ignorado por Git).
Puertos ligados a 127.0.0.1 (antes MySQL, phpMyAdmin y Vite quedaban expuestos a toda la red).
phpMyAdmin pasa a un profile opcional.
healthcheck + service_healthy para que Laravel espere a MySQL.

ℹ️ Como producción es hosting compartido (sin Docker), en desarrollo se usan variables en .env en lugar de Docker Secrets. Si algún día migran a un VPS con Docker, se puede pasar a secrets.

4.2 .env de la raíz (para Docker Compose — NO se sube a Git)
dotenv
MYSQL_ROOT_PASSWORD=cambia_esta_clave_root
MYSQL_DATABASE=sgdv
MYSQL_USER=sgdv
MYSQL_PASSWORD=cambia_esta_clave_app

Crea también un .env.example en la raíz con estas mismas claves sin valores y súbelo a Git.

4.3 Dockerfile (propuesto)
dockerfile
FROM php:8.4-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip curl nodejs npm \
        libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd bcmath intl opcache \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite headers

# Configuración PHP de producción + overrides (display_errors Off, expose_php Off…)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Versión fija de Composer (evita "latest")
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

En desarrollo conviene cambiar display_errors a On mediante un conf.d/dev.ini montado solo en local.

4.4 docker/apache/000-default.conf — debe contener al menos
apache
<VirtualHost *:80>
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
4.5 src/.env (Laravel, desarrollo — NO se sube a Git)
dotenv
APP_NAME=SGDV
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql            # nombre del servicio Docker, NO localhost
DB_PORT=3306
DB_DATABASE=sgdv
DB_USERNAME=sgdv
DB_PASSWORD=cambia_esta_clave_app   # igual que MYSQL_PASSWORD

# Igual que producción, para detectar diferencias temprano
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
4.6 .gitignore — ajustes recomendados

El actual ignora src/.env.*, lo que también ignora src/.env.example (Laravel lo necesita versionado). Añade:

gitignore
# Excepción: plantilla de entorno de Laravel
!src/.env.example

# Compose (raíz)
.env

# Otros artefactos de Laravel/Vite
src/public/hot
src/public/storage
src/storage/*.key
🏎️ 5. Puesta en marcha
Clonar
bash
   git clone https://github.com/fjpb/SGDV.git
   cd SGDV
Variables de Docker (raíz): crea .env como en 4.2.
Levantar contenedores
bash
   docker compose up -d --build
Configurar Laravel
bash
   cp src/.env.example src/.env      # o créalo según 4.5
   docker compose exec app composer install
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate
   docker compose exec app php artisan storage:link
Frontend (Vite)
bash
   docker compose exec app npm install
   docker compose exec app npm run dev -- --host 0.0.0.0

Si el HMR no conecta, en src/vite.config.js define server: { host: '0.0.0.0', hmr: { host: 'localhost' } }.

Verificar: http://localhost:8080 (app) · http://localhost:8081 (phpMyAdmin, con --profile tools).

⚠️ Si ya tenías el volumen mysql_data creado con root/root, las nuevas contraseñas no se aplican. Para reiniciar la BD de desarrollo: docker compose down -v (⚠️ borra los datos locales) y vuelve al paso 3.

📊 6. Comandos útiles
Acción	Comando
Levantar / reconstruir	docker compose up -d --build
Detener	docker compose down
Detener y borrar BD local	docker compose down -v ⚠️
Estado	docker compose ps
Logs	docker compose logs -f app
Log de Laravel	docker compose exec app tail -f storage/logs/laravel.log
Terminal en el contenedor	docker compose exec app bash
Artisan	docker compose exec app php artisan <comando>
Migrar	docker compose exec app php artisan migrate
Rehacer BD + seeders	docker compose exec app php artisan migrate:fresh --seed ⚠️
Rutas	docker compose exec app php artisan route:list
Tinker	docker compose exec app php artisan tinker
Tests	docker compose exec app php artisan test
Estilo (Pint, si está instalado)	docker compose exec app ./vendor/bin/pint
Composer	docker compose exec app composer require <paquete>
Build de assets	docker compose exec app npm run build
Limpiar cachés	docker compose exec app php artisan optimize:clear
phpMyAdmin	docker compose --profile tools up -d phpmyadmin
Backup de BD	docker compose exec mysql sh -c 'mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" sgdv' > backups/sgdv_$(date +%F).sql
Restaurar	docker compose exec -T mysql sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" sgdv' < backups/archivo.sql

backups/ y *.sql ya están en .gitignore. Los respaldos con datos reales nunca se suben a Git.

🔒 7. Seguridad
Docker / entorno
Sin contraseñas escritas en docker-compose.yml; usar .env (ignorado por Git).
Puertos ligados a 127.0.0.1; no exponer MySQL ni phpMyAdmin a la red.
Fijar versiones de imágenes (mysql:8.0, phpmyadmin:5, composer:2), evitar latest.
Si alguna vez se subió una credencial real a Git, rotarla (borrar el commit no basta).
Laravel
SQL: Eloquent / Query Builder con bindings. Prohibido concatenar variables en DB::raw(), whereRaw(), orderByRaw().
XSS: Blade {{ }}; evitar {!! !!} salvo HTML sanitizado.
CSRF: @csrf en todos los formularios que modifiquen datos.
Validación: Form Requests; no usar $request->all() sin filtrar.
Mass assignment: $fillable explícito en cada modelo.
Autorización (RBAC): verificar permisos en el backend (Policies/Gates/middleware), nunca solo ocultando botones en la vista.
Documentos y archivos subidos (relevante en un sistema documental): validar mimes y tamaño, renombrar, guardar en disco privado y servir mediante controlador con autorización o URLs firmadas. No confiar en la extensión.
Datos personales: no registrar en logs datos sensibles (RUT, patentes con titular, etc.).
Sesión/cookies en producción: SESSION_SECURE_COOKIE=true, SESSION_SAME_SITE=lax, SESSION_HTTP_ONLY=true.
Rate limiting en login y endpoints costosos.
Dependencias: composer audit y npm audit de forma periódica.
🚢 8. Despliegue a producción

Según .env.production.example, producción es un hosting compartido con MySQL local (DB_HOST=localhost), CACHE_STORE=file, SESSION_DRIVER=file y QUEUE_CONNECTION=sync (sin worker).

Puntos críticos
src/public/build/ está en .gitignore: los assets de Vite no llegan con git pull. Hay que compilarlos (npm ci && npm run build) y subirlos, o compilar en un paso de CI.
src/vendor/ tampoco está versionado: ejecutar composer install --no-dev --optimize-autoloader (en el servidor o subir vendor/ ya generado).
El .env de producción se crea directamente en el servidor a partir de .env.production.example. Nunca se sube por Git.
Solo public/ debe ser accesible por web. Verifica que .env, storage/, vendor/ y app/ estén fuera del directorio público o bloqueados.
Con QUEUE_CONNECTION=sync los trabajos pesados se ejecutan dentro de la petición HTTP. Si aparecen lentitud o timeouts, evaluar cola con database y un cron.
Secuencia de despliegue
bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan storage:link      # solo la primera vez

Antes de migrate --force en producción: backup de la base de datos.

Ajustes sugeridos para .env.production.example
dotenv
APP_URL=https://midominio.cl
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
# DB_HOST puede no ser "localhost" según el proveedor; confirmarlo en el panel del hosting.

📝 Documentar aquí el contenido de la carpeta deploy/ y el procedimiento de subida real (FTP, SSH, cPanel Git, etc.).

🤖 9. Reglas para asistentes de IA
Leer este archivo primero. El código Laravel está en src/; las rutas de archivos son relativas a esa carpeta.
Nunca escribir credenciales, tokens ni APP_KEY en código, compose, ejemplos o commits.
Nunca leer, mostrar ni modificar .env, src/.env ni respaldos *.sql. Los cambios de configuración van a los archivos *.example.
No tocar src/.rbac-backup-*/ ni Dockerfile.bak-*; son respaldos.
Usar Artisan (make:model, make:controller, make:request, make:policy, make:migration…) en lugar de crear archivos a mano.
Migraciones: nunca editar una ya ejecutada o mergeada; crear una nueva. Confirmar dónde vive la migración (ver sección 11) antes de crearla.
SQL solo con Eloquent/Query Builder con bindings.
Validación en Form Requests; autorización en Policies/Gates respetando el sistema RBAC existente.
Blade: {{ }} por defecto; justificar cualquier {!! !!}.
Modelos: $fillable, relaciones y casts explícitos.
Controladores delgados; lógica de negocio en Services/Actions.
Compatibilidad con producción (hosting compartido): no depender de Redis, workers persistentes, Supervisor ni extensiones PHP raras sin consultarlo. Recordar QUEUE_CONNECTION=sync.
Assets: si se cambia frontend, indicar que hay que ejecutar npm run build antes de desplegar (public/build/ no se versiona).
Tests: cada funcionalidad nueva incluye al menos un test Feature.
Comandos destructivos (migrate:fresh, down -v, rm -rf, DROP, TRUNCATE): pedir confirmación explícita.
No agregar paquetes Composer/npm sin justificarlo (peso, mantenimiento y compatibilidad con el hosting).
Cambios pequeños y revisables, indicando qué archivos se tocan y por qué.
Si algo no está claro (requisitos, esquema, versión de Laravel), preguntar antes de asumir.
Convenciones
PHP: PSR-12; clases PascalCase, métodos/variables camelCase; tablas en plural snake_case.
Commits: Conventional Commits (feat:, fix:, docs:, chore:).
Ramas: main (estable) · feature/<nombre> para trabajo nuevo.
🩺 10. Solución de problemas
Síntoma	Causa probable	Solución
port is already allocated	8080/3306/5173/8081 ocupado	Cambiar el puerto del host en el compose
SQLSTATE[HY000] [2002] Connection refused	DB_HOST=localhost en src/.env	Usar DB_HOST=mysql
Access denied for user	Volumen antiguo con otras credenciales	docker compose down -v (⚠️ borra datos locales)
Permission denied en storage/ o bootstrap/cache	Permisos del bind mount	docker compose exec app chown -R www-data:www-data storage bootstrap/cache
404 en todas las rutas salvo /	mod_rewrite o AllowOverride mal configurado	Revisar 000-default.conf (sección 4.4)
Estilos/JS no cargan en local	Vite no está corriendo	npm run dev -- --host 0.0.0.0
Estilos/JS no cargan en producción	Falta public/build/	Compilar con npm run build y subir la carpeta
Cambios de .env no se aplican	Config en caché	php artisan optimize:clear
Pantalla en blanco / 500	Error de PHP oculto	Revisar storage/logs/laravel.log
🧹 11. Pendientes y deuda técnica detectada

Observaciones al revisar el repositorio (marcar al resolver):

 Credenciales en docker-compose.yml (root/root, sgdv/sgdv) y puertos abiertos a toda la red → aplicar sección 4.1.
 Dockerfile.bak-fase22-gd versionado en la raíz → borrarlo (el historial de Git ya guarda las versiones anteriores).
 Archivo active en la raíz sin explicación → documentar su propósito o eliminarlo.
 database/migrations/ en la raíz (fuera de src/) → confirmar si es una carpeta de trabajo que luego se copia a src/database/migrations. Laravel solo ejecuta las de src/. Si son duplicadas, unificar.
 .gitignore ignora src/.env.example → añadir la excepción !src/.env.example.
 README.md vacío → completar con la sección 1 y los pasos de la sección 5.
 Dockerfile: composer:latest sin fijar, Node/npm desde apt (versión antigua) y contenedor único para PHP + Node. Valorar un servicio node separado (node:22-alpine).
 Documentar deploy/ (qué contiene y cómo se usa).
 Documentar el sistema de roles/permisos (RBAC) y los roles existentes.
 Añadir tests y CI básico (GitHub Actions: composer install, php artisan test, composer audit).
✅ 12. Checklist antes de un commit / despliegue
 .env, src/.env y *.sql no aparecen en git status
 Plantillas *.example actualizadas con variables nuevas (sin valores reales)
 Sin credenciales en código ni historial reciente
 Validación en Form Requests y permisos verificados en backend
 Sin SQL concatenado ni {!! !!} injustificado
 php artisan test en verde
 Migraciones nuevas probadas con migrate y migrate:rollback
 Backup de BD antes de migrar en producción
 npm run build ejecutado y public/build/ incluido en el despliegue
 Producción: APP_DEBUG=false, APP_ENV=production, cookies seguras
 Producción: config:cache, route:cache, view:cache
 Este documento refleja los cambios realizados
 Por ultimos siempre guardar lo necesario para entender los cambios en historia.md