<div class="space-y-4">
    @php
        // Debug info
        \Log::info('Modal device data: ' . json_encode($device));
        \Log::info('Modal position data: ' . json_encode($position));
    @endphp
    
    @if ($device)
        <!-- Header Section with Device Info -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-lg p-4 border border-blue-200 dark:border-gray-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <x-heroicon-o-truck class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $device['name'] ?? 'Dispositivo Desconocido' }}
                        </h3>
                        <p class="text-xs text-gray-600 dark:text-gray-300">
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
                    <div class="flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $isOnline ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        <div class="w-2 h-2 rounded-full mr-1 {{ $isOnline ? 'bg-green-500' : 'bg-red-500' }}"></div>
                        {{ $statusLabel }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info Grid -->
        <div class="space-y-4">
            <!-- Vehicle Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                    <x-heroicon-o-document-text class="w-4 h-4 mr-2 text-indigo-500" />
                    Información del Vehículo
                </h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Placa:</span>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white">
                            {{ $device['uniqueId'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Categoría:</span>
                        <span class="text-xs text-gray-900 dark:text-white capitalize">
                            {{ $device['category'] ?? 'Predeterminado' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Hora:</span>
                        <span class="text-xs text-gray-900 dark:text-white">
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

            <!-- Location Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                    <x-heroicon-o-map-pin class="w-4 h-4 mr-2 text-green-500" />
                    Ubicación y Velocidad
                </h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Coordenadas:</span>
                        <span class="text-xs font-mono text-gray-900 dark:text-white">
                            @if ($position && isset($position['latitude']) && isset($position['longitude']))
                                {{ number_format($position['latitude'], 4) }}, {{ number_format($position['longitude'], 4) }}
                            @else
                                Sin coordenadas
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Velocidad:</span>
                        <span class="text-xs font-bold text-blue-600 dark:text-blue-400">
                            @if ($position && isset($position['speed']))
                                {{ number_format($position['speed'] * 1.852, 0) }} km/h
                            @else
                                0 km/h
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Dirección:</span>
                        <span class="text-xs text-gray-900 dark:text-white">
                            @if ($position && isset($position['course']))
                                {{ number_format($position['course'], 0) }}°
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        @if ($position && isset($position['attributes']['distance']))
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Distancia Total:</span>
                <span class="text-xs font-bold text-green-600 dark:text-green-400">
                    {{ number_format($position['attributes']['distance'] / 1000, 1) }} km
                </span>
            </div>
        </div>
        @endif

    @else
        <!-- No Data Available -->
        <div class="text-center py-12">
            <x-heroicon-o-exclamation-triangle class="w-16 h-16 text-yellow-400 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                No hay información disponible
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                No se pudo cargar la información del dispositivo seleccionado.
            </p>
        </div>
    @endif
</div>