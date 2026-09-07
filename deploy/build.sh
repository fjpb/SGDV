#!/usr/bin/env bash

set -Eeuo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
CONTAINER="sgdv_app"
RELEASE_DIR="$PROJECT_ROOT/deploy/releases"
TMP_DIR="$PROJECT_ROOT/deploy/.build"

echo "========================================="
echo " SGDV Build Production"
echo "========================================="

echo "[1/6] Verificando Docker..."

docker ps --format '{{.Names}}' | grep -qx "$CONTAINER" || {
    echo "ERROR: Contenedor $CONTAINER no está ejecutándose."
    exit 1
}

echo "[2/6] Limpiando build anterior..."

rm -rf "$TMP_DIR"
mkdir -p "$TMP_DIR"

echo "[3/6] Verificando Artisan..."

docker exec "$CONTAINER" php artisan --version >/dev/null

echo "[4/6] Verificando Composer..."

docker exec "$CONTAINER" composer --version >/dev/null

echo "[5/6] Ejecutando optimize..."

docker exec "$CONTAINER" php artisan optimize

echo "[6/6] Verificaciones OK."

echo
echo "Build base finalizado correctamente."
echo
echo "Siguiente iteración:"
echo " - copiar archivos"
echo " - excluir desarrollo"
echo " - generar ZIP"
