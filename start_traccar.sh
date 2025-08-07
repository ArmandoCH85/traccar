#!/bin/bash

# Script para iniciar Traccar Server
cd /home/armando/Sites/Trackar

# Verificar si ya está ejecutándose
if pgrep -f "tracker-server.jar" > /dev/null; then
    echo "Traccar ya está ejecutándose"
    exit 1
fi

# Iniciar Traccar
echo "Iniciando Traccar Server..."
./jdk-17.0.2/bin/java -jar tracker-server.jar conf/traccar.xml > traccar.log 2>&1 &

# Esperar un momento
sleep 3

# Verificar que se inició correctamente
if pgrep -f "tracker-server.jar" > /dev/null; then
    echo "✅ Traccar Server iniciado correctamente"
    echo "🌐 Interfaz web: http://localhost:8082"
    echo "👤 Usuario: admin"
    echo "🔑 Contraseña: admin"
else
    echo "❌ Error al iniciar Traccar Server"
    exit 1
fi