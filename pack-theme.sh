#!/usr/bin/env bash
set -euo pipefail

# ——— Config ———
# Qué incluir (rutas relativas a la raíz del tema)
INCLUDE=(
  "acf-json"
  "assets"
  "functions"
  "template-parts"
  "templates"
  "build"
  "*.php"
  "style.css"
  "README.md"
)

# Qué excluir (patrones del zip -x)
EXCLUDE=(
  "node_modules/*"
  ".git/*"
  ".DS_Store"
  ".env"
  ".nvmrc"
  "docker-compose.y*ml"
  "vite.config.*"
  "package*.json"
  ".pack/*"
)

SKIP_INSTALL="${SKIP_INSTALL:-0}"   # export SKIP_INSTALL=1 para saltar npm ci

# ——— Ubicación ———
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT_DIR"
THEME_SLUG="${THEME_SLUG:-$(basename "$ROOT_DIR")}"

# ——— Limpieza previa ———
# (evita sustos si por error el ROOT_DIR fuera "/")
if [[ "$ROOT_DIR" == "/" ]]; then
  echo "❌ ROOT_DIR apunta a /. Aborto por seguridad."
  exit 1
fi

echo "🧹 Limpiando build/ y .zip previos..."

# Borrar build/ si existe
if [[ -d "build" ]]; then
  rm -rf "build"
fi

# Borrar zips en el root (solo si hay match; nullglob evita rm de patrón literal)
shopt -s nullglob
zips=( *.zip )
if ((${#zips[@]})); then
  rm -f "${zips[@]}"
fi
shopt -u nullglob

# ——— nvm use ———
if [ -s "$HOME/.nvm/nvm.sh" ]; then
  export NVM_DIR="$HOME/.nvm"
  # shellcheck disable=SC1090
  . "$HOME/.nvm/nvm.sh"
  if [ -f .nvmrc ]; then
    echo "🔧 nvm use $(cat .nvmrc)…"
    nvm use >/dev/null 2>&1 || { echo "⬇️  Instalando versión de .nvmrc…"; nvm install >/dev/null; nvm use >/dev/null; }
  else
    echo "ℹ️  No hay .nvmrc, usando LTS…"
    nvm install --lts >/dev/null
    nvm use --lts >/dev/null
  fi
else
  echo "⚠️  nvm no encontrado. Sigo con $(node -v 2>/dev/null || echo 'Node no instalado')."
fi

# ——— Versionado ———
if command -v jq >/dev/null 2>&1 && [[ -f package.json ]]; then
  VERSION="$(jq -r '.version // empty' package.json || true)"
  [[ -z "$VERSION" || "$VERSION" == "null" ]] && VERSION="$(date +%Y%m%d%H%M)"
else
  VERSION="$(date +%Y%m%d%H%M)"
fi
ARCHIVE_NAME="${THEME_SLUG}-${VERSION}.zip"
ZIP_PATH="${ROOT_DIR}/${ARCHIVE_NAME}"

# ——— Build ———
if [[ "$SKIP_INSTALL" -ne 1 ]]; then
  if [[ -f package-lock.json ]]; then npm ci; else npm install; fi
fi
npm run build

# Mover el manifest y borrar la carpeta .vite
if [ -f "build/.vite/manifest.json" ]; then
  mv -f "build/.vite/manifest.json" "build/manifest.json"
fi
if [ -d "build/.vite" ]; then
  rm -rf "build/.vite"
fi

# ——— Preparar lista a zippear (sin staging) ———
# Expandimos patrones del array INCLUDE (directorios o archivos)
shopt -s nullglob
FILES=()
for patt in "${INCLUDE[@]}"; do
  # si existe tal cual (dir o archivo), lo agregamos
  if [[ -d "$patt" || -f "$patt" ]]; then
    FILES+=("$patt")
    continue
  fi
  # si es un patrón (ej: *.php), expandimos
  matches=( $patt )
  for m in "${matches[@]}"; do FILES+=("$m"); done
done
shopt -u nullglob

if [[ ${#FILES[@]} -eq 0 ]]; then
  echo "❌ No hay archivos para zippear según INCLUDE."
  exit 1
fi

# Armar flags de exclusión para zip
EX_OPTS=()
for x in "${EXCLUDE[@]}"; do EX_OPTS+=("-x" "$x"); done

# Evitar que zip “actualice” un zip previo
rm -f "$ZIP_PATH"

echo "🗜️  Creando zip en la raíz: $ZIP_PATH"
# -r recursivo, -q silencioso
zip -r -q "$ZIP_PATH" "${FILES[@]}" "${EX_OPTS[@]}"

echo "✅ Listo: $ZIP_PATH"
