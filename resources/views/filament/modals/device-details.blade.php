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
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Dirección:</span>
                        <span class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-600 px-3 py-1 rounded-md shadow-sm">
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