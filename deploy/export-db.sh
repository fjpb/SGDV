#!/usr/bin/env bash
set -Eeuo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RELEASE_DIR="$PROJECT_ROOT/deploy/releases"

mkdir -p "$RELEASE_DIR"

VERSION=$(date +%Y%m%d-%H%M%S)

echo "Exportando base de datos..."

docker exec sgdv_mysql \
    mysqldump \
    -uroot \
    -proot \
    --single-transaction \
    --routines \
    --triggers \
    sgdv \
> "$RELEASE_DIR/sgdv-$VERSION.sql"

echo
echo "SQL generado:"
echo "$RELEASE_DIR/sgdv-$VERSION.sql"
