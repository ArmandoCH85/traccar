# Sincronización de Dispositivos

## Manual

Para sincronizar manualmente los dispositivos desde Traccar:

```bash
php artisan traccar:sync-devices
```

## Desde la Interfaz Web

1. Ve a **Devices** en el panel de administración
2. Haz clic en **"Sync from Traccar"** en la parte superior
3. Confirma la sincronización

## Automática (Recomendado)

Para configurar sincronización automática cada 15 minutos, agrega esto al crontab:

```bash
# Editar crontab
crontab -e

# Agregar esta línea:
*/15 * * * * cd /home/armando/Sites/Trackar && php artisan traccar:sync-devices >> /dev/null 2>&1
```

## Servidor Traccar Configurado

- **URL**: http://161.132.47.112:8082
- **Usuario**: administrador@lubarsa.com
- **Contraseña**: administrador
- **Dispositivos**: 60 dispositivos activos

## Estado Actual

✅ Configuración completada
✅ 60 dispositivos sincronizados
✅ Visible en panel Devices
✅ Visible en mapa interactivo