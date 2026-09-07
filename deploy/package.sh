#!/usr/bin/env bash
set -Eeuo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RELEASE_DIR="$PROJECT_ROOT/deploy/releases"
BUILD_DIR="$RELEASE_DIR/build"

VERSION="$(date +%Y%m%d-%H%M%S)"

echo "========================================="
echo " SGDV Production Package"
echo "========================================="

mkdir -p "$RELEASE_DIR"

rm -rf "$BUILD_DIR"

mkdir -p "$BUILD_DIR"

echo
echo "[1/7] Copiando proyecto..."

rsync -a \
    --delete \
    --exclude=".git" \
    --exclude=".github" \
    --exclude=".idea" \
    --exclude=".vscode" \
    --exclude=".DS_Store" \
    --exclude="node_modules" \
    --exclude="tests" \
    --exclude="docker" \
    --exclude="deploy/releases" \
    --exclude=".env" \
    --exclude="storage/logs/*" \
    --exclude="storage/framework/cache/*" \
    --exclude="storage/framework/sessions/*" \
    --exclude="storage/framework/views/*" \
    --exclude="bootstrap/cache/*.php" \
    "$PROJECT_ROOT/" \
    "$BUILD_DIR/"

echo
echo "[2/7] Preparando storage..."

mkdir -p "$BUILD_DIR/storage/logs"
mkdir -p "$BUILD_DIR/storage/framework/cache"
mkdir -p "$BUILD_DIR/storage/framework/views"
mkdir -p "$BUILD_DIR/storage/framework/sessions"

touch "$BUILD_DIR/storage/logs/laravel.log"

echo
echo "[3/7] Eliminando backups..."

find "$BUILD_DIR" -type f \
\( \
-name "*.bak" -o \
-name "*.bak-*" -o \
-name "*.backup*" \
\) \
-delete

echo
echo "[4/7] Limpiando archivos temporales..."

find "$BUILD_DIR" -name ".DS_Store" -delete

echo
echo "[5/7] Generando ZIP..."

cd "$RELEASE_DIR"

zip -rq "sgdv-${VERSION}.zip" build

mv build "sgdv-${VERSION}"

echo
echo "[6/7] Verificando..."

unzip -t "sgdv-${VERSION}.zip" >/dev/null

echo
echo "[7/7] FINALIZADO"

echo
echo "Carpeta:"
echo "  $RELEASE_DIR/sgdv-${VERSION}"

echo
echo "ZIP:"
echo "  $RELEASE_DIR/sgdv-${VERSION}.zip"
