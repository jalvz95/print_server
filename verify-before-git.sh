#!/bin/bash

echo "🔍 Verificando proyecto antes de subir a Git..."
echo "=============================================="
echo ""

ERRORS=0

# Verificar archivos críticos
echo "📁 Verificando archivos críticos..."

check_file() {
    if [ -f "$1" ]; then
        echo "  ✅ $1"
    else
        echo "  ❌ $1 - FALTA!"
        ERRORS=$((ERRORS + 1))
    fi
}

check_file ".env.example"
check_file "package.json"
check_file "package-lock.json"
check_file "composer.json"
check_file "composer.lock"
check_file "setup.sh"
check_file "README.md"
check_file "docker-compose.yml"
check_file "Dockerfile"
check_file ".gitignore"

echo ""

# Verificar que NO existan archivos sensibles
echo "🔒 Verificando archivos sensibles..."

check_not_exists() {
    if [ ! -d "$1" ] && [ ! -f "$1" ]; then
        echo "  ✅ $1 (no incluido - correcto)"
    else
        echo "  ⚠️  $1 existe - ¡Verifica que esté en .gitignore!"
    fi
}

check_not_exists "vendor"
check_not_exists "node_modules"

echo ""

# Verificar .gitignore
echo "📄 Verificando .gitignore..."

if grep -q "^/vendor$" .gitignore; then
    echo "  ✅ /vendor en .gitignore"
else
    echo "  ❌ /vendor NO está en .gitignore!"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "^/node_modules$" .gitignore; then
    echo "  ✅ /node_modules en .gitignore"
else
    echo "  ❌ /node_modules NO está en .gitignore!"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "^\.env$" .gitignore; then
    echo "  ✅ .env en .gitignore"
else
    echo "  ❌ .env NO está en .gitignore!"
    ERRORS=$((ERRORS + 1))
fi

# Verificar que package.json NO esté en gitignore
if grep -q "package.json" .gitignore; then
    echo "  ❌ package.json está en .gitignore (NO DEBE ESTAR!)"
    ERRORS=$((ERRORS + 1))
else
    echo "  ✅ package.json NO está en .gitignore (correcto)"
fi

echo ""

# Verificar permisos de scripts
echo "🔧 Verificando permisos de scripts..."

if [ -x "setup.sh" ]; then
    echo "  ✅ setup.sh es ejecutable"
else
    echo "  ❌ setup.sh NO es ejecutable!"
    echo "     Ejecuta: chmod +x setup.sh"
    ERRORS=$((ERRORS + 1))
fi

echo ""

# Resumen
echo "=============================================="
if [ $ERRORS -eq 0 ]; then
    echo "✅ TODO CORRECTO - LISTO PARA SUBIR A GIT"
    echo ""
    echo "Siguiente comando sugerido:"
    echo "  git init"
    echo "  git add ."
    echo "  git commit -m \"Initial commit: Print Server Simulator\""
    echo ""
    exit 0
else
    echo "❌ ENCONTRADOS $ERRORS ERRORES - CORREGIR ANTES DE SUBIR"
    echo ""
    exit 1
fi
