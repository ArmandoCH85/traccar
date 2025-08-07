#!/bin/bash

# Script para detener Traccar Server
echo "Deteniendo Traccar Server..."

# Encontrar y matar el proceso
pkill -f "tracker-server.jar"

# Esperar un momento
sleep 2

# Verificar que se detuvo
if ! pgrep -f "tracker-server.jar" > /dev/null; then
    echo "✅ Traccar Server detenido correctamente"
else
    echo "❌ Error al detener Traccar Server"
    echo "Forzando detención..."
    pkill -9 -f "tracker-server.jar"
fi