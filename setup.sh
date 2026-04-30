#!/bin/bash
# setup.sh - Script de configuración inicial

echo " Configurando el proyecto..."

# Verificar si Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "Instalando Composer..."
    sudo dnf install -y composer
fi

# Instalar dependencias
echo "Instalando dependencias de PHP..."
composer require vlucas/phpdotenv

# Crear carpetas necesarias
mkdir -p logs
mkdir -p assets/css assets/js assets/img
mkdir -p includes
mkdir -p clases
mkdir -p public

# Crear archivo .env si no existe
if [ ! -f .env ]; then
    echo "Creando archivo .env..."
    cat > .env << 'EOF'
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=root123
DB_NAME=portafolio_db
DB_PORT=3306
SITE_NAME="Axel Colorado - Portafolio"
SITE_URL="http://localhost:8000"
DEBUG_MODE=true
TIMEZONE=America/Mexico_City
EOF
fi

# Crear .gitignore
echo "Creando .gitignore..."
cat > .gitignore << 'EOF'
.env
/vendor/
composer.lock
*.log
/logs/
EOF

echo " Configuración completada!"
echo " No olvides:"
echo "   1. Configurar tu .env con las credenciales correctas"
echo "   2. Mover tus archivos CSS/JS a assets/"
echo "   3. Actualizar las rutas en index.html"