<div class="space-y-6 p-2">
    @php
        // Debug info
        \Log::info('Modal device data: ' . json_encode($device));
        \Log::info('Modal position data: ' . json_encode($position));
    @endphp

    @if ($device)
        <!-- Header Section with Device Info - MEJORADO -->
        <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 rounded-xl p-6 border border-blue-200 dark:border-gray-600 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900 dark:to-indigo-800 rounded-full flex items-center justify-center shadow-md">
                            <x-heroicon-o-truck class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ $device['name'] ?? 'Dispositivo Desconocido' }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 font-medium">
                            ID: {{ $device['uniqueId'] ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center">
                    @php
                        $isOnline = isset($device['status']) && $device['status'] === 'online';
                        $statusColor = $isOnline ? 'green' : 'red';
                        $statusLabel = $isOnline ? 'En Línea' : 'Sin Conexión';
                    @endphp
                    <div class="flex items-center px-4 py-2 rounded-full text-sm font-semibold shadow-md
                        {{ $isOnline ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900 dark:to-emerald-900 dark:text-green-200 border border-green-200 dark:border-green-700' : 'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 dark:from-red-900 dark:to-rose-900 dark:text-red-200 border border-red-200 dark:border-red-700' }}">
                        <div class="w-3 h-3 rounded-full mr-2 {{ $isOnline ? 'bg-green-500 animate-pulse' : 'bg-red-500' }} shadow-sm"></div>
                        {{ $statusLabel }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info Grid - MEJORADO -->
        <div class="space-y-5">
            <!-- Vehicle Information -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 p-5 shadow-md">
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <x-heroicon-o-document-text class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    Información del Vehículo
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Placa:</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            {{ $device['uniqueId'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Categoría:</span>
                        <span class="text-sm text-gray-900 dark:text-white capitalize bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            {{ $device['category'] ?? 'Predeterminado' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Última Actualización:</span>
                        <span class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm font-mono">
                            @if ($position && isset($position['deviceTime']))
                                {{ \Carbon\Carbon::parse($position['deviceTime'])->format('d/m/Y H:i:s') }}
                            @elseif ($device && isset($device['lastUpdate']))
                                {{ \Carbon\Carbon::parse($device['lastUpdate'])->format('d/m/Y H:i:s') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Location Information - MEJORADO -->
            <div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 p-5 shadow-md">
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-green-600 dark:text-green-400" />
                    </div>
                    Ubicación y Velocidad
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 px-3 bg-green-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Coordenadas:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            @if ($position && isset($position['latitude']) && isset($position['longitude']))
                                {{ number_format($position['latitude'], 4) }}, {{ number_format($position['longitude'], 4) }}
                            @else
                                Sin coordenadas
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 px-3 bg-green-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Velocidad:</span>
                        <span class="text-sm font-bold bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400 bg-clip-text text-transparent bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            @if ($position && isset($position['speed']))
                                {{ number_format($position['speed'] * 1.852, 0) }} km/h
                            @else
                                0 km/h
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 px-3 bg-green-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Rumbo:</span>
                        <span class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            @if ($position && isset($position['course']))
                                {{ number_format($position['course'], 0) }}°
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-start py-2 px-3 bg-green-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex-shrink-0 mt-1">Dirección:</span>
                        <div class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm ml-2 flex-1 text-right">
                            @if ($position && isset($position['address']) && !empty($position['address']))
                                <span class="break-words">{{ $position['address'] }}</span>
                            @elseif ($position && isset($position['latitude']) && isset($position['longitude']))
                                @php
                                    // Crear un ID único y robusto para el elemento
                                    $elementId = 'address-loading-' . md5(($device['id'] ?? $device['uniqueId'] ?? 'unknown') . '-' . $position['latitude'] . '-' . $position['longitude']);
                                @endphp
                                <span class="text-blue-600 dark:text-blue-400 italic" id="{{ $elementId }}">
                                    🔄 Obteniendo dirección...
                                </span>
                                <script>
                                    // Geocodificación individual para este dispositivo
                                    (function() {
                                        const elementId = '{{ $elementId }}';
                                        const lat = {{ $position['latitude'] }};
                                        const lng = {{ $position['longitude'] }};
                                        const deviceName = '{{ $device['name'] ?? 'Dispositivo' }}';
                                        const loadingElement = document.getElementById(elementId);
                                        
                                        console.log('🌍 Iniciando geocodificación para:', deviceName, 'en coordenadas:', lat, lng);
                                        
                                        if (lat && lng && loadingElement) {
                                            // Agregar timeout para evitar esperas indefinidas
                                            const controller = new AbortController();
                                            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 segundos timeout
                                            
                                            // Usar servicio de geocodificación de OpenStreetMap
                                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                                                signal: controller.signal,
                                                headers: {
                                                    'User-Agent': 'TrackarApp/1.0'
                                                }
                                            })
                                                .then(response => {
                                                    clearTimeout(timeoutId);
                                                    if (!response.ok) {
                                                        throw new Error(`HTTP ${response.status}`);
                                                    }
                                                    return response.json();
                                                })
                                                .then(data => {
                                                    console.log('✅ Geocodificación exitosa para:', deviceName, data);
                                                    if (data && data.display_name) {
                                                        loadingElement.innerHTML = `<span class="text-green-600 dark:text-green-400 break-words">📍 ${data.display_name}</span>`;
                                                    } else {
                                                        console.warn('⚠️ Sin datos de dirección para:', deviceName);
                                                        loadingElement.innerHTML = '<span class="text-gray-500">❌ Dirección no disponible</span>';
                                                    }
                                                })
                                                .catch(error => {
                                                    clearTimeout(timeoutId);
                                                    console.error('❌ Error geocodificando para:', deviceName, error);
                                                    if (error.name === 'AbortError') {
                                                        loadingElement.innerHTML = '<span class="text-gray-500">⏱️ Timeout obteniendo dirección</span>';
                                                    } else {
                                                        loadingElement.innerHTML = '<span class="text-gray-500">❌ Error obteniendo dirección</span>';
                                                    }
                                                });
                                        } else {
                                            console.error('❌ Datos inválidos para geocodificación:', {elementId, lat, lng, hasElement: !!loadingElement});
                                            if (loadingElement) {
                                                loadingElement.innerHTML = '<span class="text-gray-500">❌ Datos inválidos</span>';
                                            }
                                        }
                                    })();
                                </script>
                            @else
                                <span class="text-gray-500">Sin coordenadas</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information - NUEVO -->
            <div class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 p-5 shadow-md">
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900 dark:to-cyan-900 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <x-heroicon-o-signal class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    Estado del Movimiento
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 px-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Estado:</span>
                        <span class="text-sm font-bold px-3 py-1 rounded-md shadow-sm">
                            @if ($position && isset($position['speed']) && $position['speed'] > 0)
                                <span class="bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900 dark:to-emerald-900 dark:text-green-200 border border-green-200 dark:border-green-700 px-3 py-1 rounded-md">
                                    🚗 En movimiento
                                </span>
                            @else
                                <span class="bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 dark:from-gray-900 dark:to-slate-900 dark:text-gray-200 border border-gray-200 dark:border-gray-700 px-3 py-1 rounded-md">
                                    🅿️ Estacionado
                                </span>
                            @endif
                        </span>
                    </div>
                    @if ($position && isset($position['fixTime']))
                    <div class="flex justify-between items-center py-2 px-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Última posición:</span>
                        <span class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm font-mono">
                            {{ \Carbon\Carbon::parse($position['fixTime'])->format('d/m/Y, H:i:s') }}
                        </span>
                    </div>
                    @endif
                    @if ($position && isset($position['attributes']['totalDistance']))
                    <div class="flex justify-between items-center py-2 px-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Horas totales:</span>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
                            {{ number_format(($position['attributes']['totalDistance'] ?? 0) / 1000, 1) }} km
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats - MEJORADO -->
        @if ($position && isset($position['attributes']['distance']))
        <div class="bg-gradient-to-br from-white to-yellow-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 p-5 shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900 dark:to-orange-900 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Distancia Total:</span>
                </div>
                <span class="text-lg font-bold bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 bg-clip-text text-transparent bg-white dark:bg-gray-600 px-4 py-2 rounded-lg shadow-sm">
                    {{ number_format($position['attributes']['distance'] / 1000, 1) }} km
                </span>
            </div>
        </div>
        @endif

    @else
        <!-- No Data Available - MEJORADO -->
        <div class="text-center py-16 bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-lg">
            <div class="w-20 h-20 bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900 dark:to-orange-900 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                <x-heroicon-o-exclamation-triangle class="w-10 h-10 text-yellow-600 dark:text-yellow-400" />
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                No hay información disponible
            </h3>
            <p class="text-base text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                No se pudo cargar la información del dispositivo seleccionado. Por favor, intenta nuevamente.
            </p>
        </div>
    @endif
</div>