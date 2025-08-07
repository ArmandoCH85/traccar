# Implementación de la API de Traccar en Laravel y Filament v3

## 1. Resumen

Este documento describe la implementación de tres funcionalidades clave de la API de Traccar: autenticación de usuario, obtención de la lista de dispositivos y visualización de los dispositivos en un mapa. La aplicación back-end se construirá con Laravel, y la interfaz de usuario se desarrollará utilizando el framework Filament v3.

## 2. Autenticación

### Métodos del API a consumir

* **POST /session**: Este método se utilizará para iniciar sesión. Recibe el `email` y `password` del usuario en el cuerpo de la solicitud (`application/x-www-form-urlencoded`). Si las credenciales son correctas, la API devuelve un objeto `User` con los detalles del usuario, incluyendo el ID de usuario (`id`) que es necesario para otras operaciones.
* **DELETE /session**: Este método se utilizará para cerrar la sesión del usuario. No requiere parámetros y cierra la sesión actual, devolviendo un estado `204 No Content`.

### Lógica de implementación en Laravel y Filament

* **Formulario de inicio de sesión**: En Filament, se creará una página de inicio de sesión personalizada. El formulario debe capturar el correo electrónico y la contraseña del usuario.
* **Llamada al API**: Al enviar el formulario, se realizará una solicitud `POST` al endpoint `/session` de la API de Traccar.
* **Gestión de la sesión**: Si la llamada es exitosa, se almacenará la información del usuario devuelta por la API (como el ID del usuario) en la sesión de Laravel o en el almacenamiento en caché, para su uso en solicitudes posteriores. Para el cierre de sesión, se llamará al endpoint `DELETE /session`.

## 3. Listar dispositivos

### Métodos del API a consumir

* **GET /devices**: Este método se utilizará para obtener la lista de dispositivos. Puede ser llamado con varios parámetros de consulta para filtrar la lista.
    * `userId`: Se usará el ID del usuario autenticado para obtener solo los dispositivos a los que tiene acceso.
    * `all`: Los administradores pueden usar este parámetro para obtener todos los dispositivos.

### Lógica de implementación en Laravel y Filament

* **Recurso de Dispositivos**: Se creará un recurso en Filament para gestionar los dispositivos.
* **Tabla de datos**: La vista de lista de este recurso (`ListDevices`) mostrará una tabla de dispositivos. La tabla se poblará llamando al endpoint `GET /devices` de la API de Traccar.
* **Paginación y filtrado**: La tabla de Filament se configurará para manejar la paginación de manera manual, y se implementará la lógica para usar los parámetros de consulta del API (`userId`, `all`) para permitir un filtrado similar en la interfaz.

## 4. Mostrar dispositivos en el mapa

### Métodos del API a consumir

* **GET /positions**: Este es el método clave para la visualización. Devuelve la ubicación de los dispositivos en forma de objetos `Position` que incluyen las coordenadas `latitude` y `longitude`.
    * Sin parámetros, devuelve la última posición conocida de todos los dispositivos.
    * Con los parámetros `deviceId`, `from` y `to`, se puede obtener el historial de una posición para la visualización de rutas.
* **WebSocket API**: Para una experiencia en tiempo real, se recomienda utilizar la API de WebSocket de Traccar en lugar de sondear el endpoint `positions` periódicamente.

### Lógica de implementación en Laravel y Filament

* **Página del Mapa**: Se creará una página personalizada en Filament (`MapPage`) que contendrá el mapa.
* **Componente de mapa**: Se utilizará una biblioteca de JavaScript como Leaflet o Mapbox para renderizar el mapa. Se implementará un componente Livewire personalizado para gestionar la interacción del mapa dentro de Filament.
* **Marcadores de dispositivos**: Para mostrar los dispositivos, se realizará una llamada `GET` al endpoint `/positions` sin parámetros para obtener las últimas posiciones. Con las coordenadas de `latitude` y `longitude`, se crearán marcadores en el mapa para cada dispositivo.
* **Actualizaciones en tiempo real**: Se implementará la integración con la API de WebSocket de Traccar para recibir nuevas posiciones y actualizar dinámicamente los marcadores de los dispositivos en el mapa, garantizando una visualización en tiempo real.
* **Configuración del mapa**: Se puede obtener información de configuración del mapa (como `latitude`, `longitude` y `zoom` del centro del mapa) desde la API de `Server` o `User` para inicializar el mapa con los valores predeterminados.
