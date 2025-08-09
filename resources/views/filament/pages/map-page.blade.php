<x-filament-panels::page>
    <div>
        <!-- ========================================
             CAPA 1: MAP CONTAINER - AZUL CLARO
             ======================================== -->
        <!-- Fullscreen Map Container -->
        <div id="mapContainer" class="fixed inset-0 w-full h-full">
            <div id="map" class="w-full h-full"></div>
        </div>

        <!-- ========================================
             CAPA 3: SIDEBAR TOGGLE - AMARILLO
             ======================================== -->
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed top-4 left-4 z-20 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl hover:bg-white dark:hover:bg-gray-800 p-3 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-xl ring-1 ring-gray-100/20 dark:ring-gray-800/20 group">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-100 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- ========================================
             CAPA 6: MODAL COMPACTO - ROSA/MAGENTA (HORIZONTAL)
             POSICIÓN: CENTRO DEL MAPA - VISIBLE SOLO AL SELECCIONAR
             ======================================== -->
        <!-- Modal compacto flotante sobre el mapa -->
        <div id="compactDeviceModal" class="hidden">
            <!-- Primer cuadro: Información del vehículo -->
            <div id="vehicleInfoBox" class="compact-modal bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-700/50 ring-1 ring-pink-100/20 dark:ring-pink-800/20">
                <!-- Header del primer cuadro -->
                <div class="relative p-2 border-b border-pink-100/50 dark:border-pink-800/50 bg-gradient-to-r from-pink-50/80 via-rose-50/80 to-pink-100/80 dark:from-pink-900/40 dark:via-rose-900/40 dark:to-pink-800/40 rounded-t-2xl backdrop-blur-sm">
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white flex items-center justify-center">
                        <div class="w-2 h-2 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full flex items-center justify-center mr-1 shadow-sm">
                        </div>
                        Información del Vehículo
                    </h3>
                    <button id="closeCompactModal" class="absolute top-1 right-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-all duration-300 p-1 hover:bg-white/50 dark:hover:bg-gray-700/50 rounded-lg backdrop-blur-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Contenido del primer cuadro -->
                <div id="vehicleInfoContent" class="p-2 text-xs leading-tight">
                    <!-- El contenido se cargará dinámicamente via JavaScript -->
                    <div class="text-center py-3 text-gray-500">
                        <div class="w-5 h-5 border-2 border-pink-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                        <p class="text-xs font-medium">Cargando...</p>
                    </div>
                </div>
            </div>

            <!-- Segundo cuadro: Información de ubicación -->
            <div id="locationInfoBox" class="compact-modal bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-2xl shadow-2xl border border-purple-200/50 dark:border-purple-700/50 ring-1 ring-purple-100/20 dark:ring-purple-800/20">
                <!-- Header del segundo cuadro -->
                <div class="p-2 border-b border-purple-100/50 dark:border-purple-800/50 bg-gradient-to-r from-purple-50/80 via-violet-50/80 to-purple-100/80 dark:from-purple-900/40 dark:via-violet-900/40 dark:to-purple-800/40 rounded-t-2xl backdrop-blur-sm">
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white flex items-center justify-center">
                        <div class="w-2 h-2 bg-gradient-to-br from-purple-400 to-violet-500 rounded-full flex items-center justify-center mr-1 shadow-sm">
                        </div>
                        Información de Ubicación
                    </h3>
                </div>
                <!-- Contenido del segundo cuadro -->
                <div id="locationInfoContent" class="p-2 text-xs leading-tight">
                    <!-- El contenido se cargará dinámicamente via JavaScript -->
                    <div class="text-center py-3 text-gray-500">
                        <div class="w-5 h-5 border-2 border-purple-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                        <p class="text-xs font-medium">Obteniendo...</p>
                    </div>
                </div>
            </div>



            <!-- Cuarto cuadro: Resumen Diario -->
            <div id="dailySummaryBox" class="compact-modal bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-2xl shadow-2xl border border-blue-200/50 dark:border-blue-700/50 ring-1 ring-blue-100/20 dark:ring-blue-800/20">
                <!-- Header del tercer cuadro -->
                <div class="p-2 border-b border-blue-100/50 dark:border-blue-800/50 bg-gradient-to-r from-blue-50/80 via-sky-50/80 to-blue-100/80 dark:from-blue-900/40 dark:via-sky-900/40 dark:to-blue-800/40 rounded-t-2xl backdrop-blur-sm">
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white flex items-center justify-center">
                        <div class="w-2 h-2 bg-gradient-to-br from-blue-400 to-sky-500 rounded-full flex items-center justify-center mr-1 shadow-sm">
                        </div>
                        Resumen Diario
                    </h3>
                </div>
                <!-- Contenido del tercer cuadro -->
                <div id="dailySummaryContent" class="p-2 text-xs leading-tight">
                    <!-- El contenido se cargará dinámicamente via JavaScript -->
                    <div class="text-center py-3 text-gray-500">
                        <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                        <p class="text-xs font-medium">Calculando...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================
             CAPA 2: DEVICE PANEL - VERDE CLARO
             ======================================== -->
        <!-- Floating Device List Panel - ALWAYS VISIBLE -->
        <div id="devicePanel" class="fixed left-4 top-16 w-80 max-h-[calc(100vh-5rem)] bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden z-10 ring-1 ring-gray-100/20 dark:ring-gray-800/20">
            
            @if (isset($devices) && is_array($devices) && count($devices) > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        @php
                            $totalDevices = count($devices);
                            $onlineDevices = collect($devices)->where('status', 'online')->count();
                            $offlineDevices = $totalDevices - $onlineDevices;
                        @endphp
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold">{{ $totalDevices }} dispositivos</span>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                <span class="text-green-600 dark:text-green-400">{{ $onlineDevices }} online</span>
                                <span class="mx-1">•</span>
                                <span class="text-red-600 dark:text-red-400">{{ $offlineDevices }} offline</span>
                            </span>
                        </div>
                        <span id="selectedDeviceIndicator" class="hidden ml-2 text-xs px-2 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 rounded-full shadow-sm">
                            Tracking device
                        </span>
                    </x-slot>
                    
                    <x-slot name="headerEnd">
                        <div class="flex gap-2">
                            <x-filament::button 
                                wire:click="refreshMap" 
                                icon="heroicon-m-arrow-path"
                                color="gray"
                                size="sm"
                                title="Refresh every 10s automatically"
                            >
                            </x-filament::button>
                        </div>
                    </x-slot>

                    <div class="custom-scrollbar relative" id="deviceListContainer" style="height: 400px !important; max-height: 400px !important; overflow-y: scroll !important; overflow-x: hidden !important; min-height: 400px !important;">
                        
                        <div class="space-y-2 p-2">
                            @foreach ($devices as $device)
                                <div class="device-card p-4 bg-gradient-to-br from-gray-50/80 via-white/90 to-gray-100/80 dark:from-gray-800/80 dark:via-gray-700/90 dark:to-gray-800/80 rounded-xl border border-gray-200/60 dark:border-gray-600/60 hover:from-blue-50/90 hover:via-indigo-50/95 hover:to-blue-100/90 dark:hover:from-blue-900/40 dark:hover:via-indigo-900/50 dark:hover:to-blue-800/40 hover:border-blue-300/70 dark:hover:border-blue-500/70 hover:shadow-xl hover:shadow-blue-500/10 hover:scale-[1.02] transition-all duration-300 cursor-pointer group backdrop-blur-sm ring-1 ring-gray-100/30 dark:ring-gray-700/30 hover:ring-blue-200/50 dark:hover:ring-blue-600/50"
                                     onclick="focusOnDevice({{ $device['id'] }})"
                                     data-device-id="{{ $device['id'] }}"
                                >
                                    <!-- Fila superior: Icono + Información del dispositivo + Estado -->
                                    <div class="flex items-start justify-between mb-2">
                                        <!-- Icono y datos del dispositivo -->
                                        <div class="flex items-center min-w-0 flex-1">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3 group-hover:from-blue-500 group-hover:via-blue-600 group-hover:to-blue-700 transition-all duration-300 shadow-lg shadow-blue-500/25 group-hover:shadow-blue-600/40 ring-2 ring-blue-100/50 dark:ring-blue-800/50 flex-shrink-0">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm leading-tight truncate group-hover:text-blue-900 dark:group-hover:text-blue-100 transition-colors duration-200">
                                                    {{ $device['name'] ?? 'Device ' . $device['id'] }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate group-hover:text-gray-600 dark:group-hover:text-gray-300 font-mono">
                                                    ID: {{ $device['uniqueId'] ?? $device['id'] }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Estado del dispositivo -->
                                        <div class="flex-shrink-0 ml-3">
                                            @php
                                                $isOnline = isset($device['status']) && $device['status'] === 'online';
                                            @endphp
                                            <div class="flex items-center">
                                                <div class="relative mr-2">
                                                    <div class="w-3 h-3 rounded-full {{ $isOnline ? 'bg-green-500' : 'bg-red-500' }} shadow-lg {{ $isOnline ? 'shadow-green-500/50' : 'shadow-red-500/50' }}"></div>
                                                    @if($isOnline)
                                                        <div class="absolute top-0 left-0 w-3 h-3 rounded-full bg-green-400 animate-ping opacity-75"></div>
                                                        <div class="absolute top-0 left-0 w-3 h-3 rounded-full bg-green-300 animate-pulse opacity-50"></div>
                                                    @endif
                                                </div>
                                                <span class="text-xs font-semibold px-2 py-1 rounded-md shadow-sm {{ $isOnline ? 'bg-gradient-to-r from-green-100 via-emerald-50 to-green-100 text-green-800 dark:from-green-900/80 dark:via-emerald-900/80 dark:to-green-900/80 dark:text-green-200 border border-green-200/60 dark:border-green-700/60' : 'bg-gradient-to-r from-red-100 via-rose-50 to-red-100 text-red-800 dark:from-red-900/80 dark:via-rose-900/80 dark:to-red-900/80 dark:text-red-200 border border-red-200/60 dark:border-red-700/60' }}">
                                                    {{ $isOnline ? 'Online' : 'Offline' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fila inferior: Última actualización -->
                                    <div class="flex justify-end">
                                        <p class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                                            {{ isset($device['lastUpdate']) ? \Carbon\Carbon::parse($device['lastUpdate'])->diffForHumans() : 'Sin datos' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-filament::section>
            @else
                <x-filament::section>
                    <x-slot name="heading">
                        Device Status
                    </x-slot>
                    <div class="text-center py-6">
                        <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                            No devices available
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                            Check Traccar connection or try refreshing
                        </p>
                        <x-filament::button 
                            wire:click="refreshMap" 
                            icon="heroicon-m-arrow-path"
                            color="primary"
                            size="sm"
                        >
                            Retry Connection
                        </x-filament::button>
                    </div>
                </x-filament::section>
            @endif
        </div>

        <!-- Hidden actions wireframe for modal (mantener para compatibilidad) -->
        <div style="display: none;">
            {{ $this->getAction('viewDeviceDetails') }}
        </div>


    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script>
        console.log('🎨 Laravel Map with Visual Layers - Leaflet loaded:', typeof L);
        
        // SIMPLIFIED and RELIABLE map initialization
        function initializeMap() {
            console.log('🔵 CAPA 1: SIMPLIFIED map initialization starting...');
            
            try {
                // Verify map element exists
                const mapElement = document.getElementById('map');
                if (!mapElement) {
                    console.error('❌ CAPA 1: Map element not found!');
                    return false;
                }
                
                console.log('✅ CAPA 1: Map element found, initializing...');
                
                // Force proper dimensions BEFORE initializing Leaflet
                mapElement.style.width = '100%';
                mapElement.style.height = '100%';
                mapElement.style.minHeight = '400px';
                mapElement.style.background = '#f0f8ff'; // Azul claro CAPA 1
                
                const container = mapElement.parentElement;
                if (container) {
                    container.style.width = '100%';
                    container.style.height = '100%';
                    container.style.background = '#e0f2fe'; // Azul claro CAPA 1
                }
                
                // Create map with simpler configuration - Centered on Lima, Peru
                const map = L.map('map', {
                    center: [-12.0464, -77.0428], // Lima, Peru coordinates
                    zoom: 11, // Appropriate zoom level for Lima city view
                    zoomControl: true,
                    attributionControl: true
                });
                
                // Store globally
                window.mapInstance = map;
                
                // Add tiles with fallbacks
                let tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19,
                    crossOrigin: true
                });
                
                // Handle tile loading errors
                let tileErrorCount = 0;
                tileLayer.on('tileerror', function(e) {
                    tileErrorCount++;
                    console.error('🔵 CAPA 1: Tile loading error #' + tileErrorCount, e);
                    
                    if (tileErrorCount > 5) {
                        console.error('🔵 CAPA 1: Too many tile errors, switching to fallback');
                        map.removeLayer(tileLayer);
                        
                        const fallbackTileLayer = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors, © CartoDB',
                            maxZoom: 19,
                            subdomains: 'abcd'
                        }).addTo(map);
                        
                        console.log('🔵 CAPA 1: Fallback tiles loaded');
                    }
                });
                
                tileLayer.addTo(map);
                console.log('🔵 CAPA 1: Basic map created with tiles');
                
                // Create markers layer
                window.markersLayer = L.layerGroup().addTo(map);
                
                // Load initial markers
                loadMapMarkers(map);
                
                // Single resize after everything is loaded
                setTimeout(function() {
                    map.invalidateSize();
                    console.log('🔵 CAPA 1: Map resized and ready');
                }, 200);
                
                return true;
                
            } catch (error) {
                console.error('❌ CAPA 1: Error initializing map:', error);
                return false;
            }
        }
        
        // SEPARATE function to load markers
        function loadMapMarkers(map) {
            try {
                // Get data from Laravel Blade
                const devices = @json($devices ?? []);
                const positions = @json($positions ?? []);
                
                console.log('🔵 CAPA 1: Loading', devices.length, 'devices and', positions.length, 'positions');
                
                if (devices.length === 0) {
                    console.warn('🔵 CAPA 1: No devices found to display on map');
                    return;
                }
                
                // Create device lookup
                const deviceMap = {};
                devices.forEach(device => {
                    deviceMap[device.id] = device;
                });
                
                // Add markers and track bounds
                const bounds = [];
                let markersAdded = 0;
                
                positions.forEach(position => {
                    const device = deviceMap[position.deviceId];
                    if (device && position.latitude && position.longitude && 
                        !isNaN(position.latitude) && !isNaN(position.longitude)) {
                        
                        // Crear marcador principal
                        const marker = L.marker([position.latitude, position.longitude])
                            .bindPopup(`<b>${device.name}</b><br>ID: ${device.uniqueId}<br>Last Update: ${new Date(position.fixTime || position.deviceTime).toLocaleString()}`);
                        
                        // Crear etiqueta con el nombre del vehículo
                        const labelIcon = L.divIcon({
                            className: 'vehicle-label',
                            html: `<div class="vehicle-label-content">${device.name}</div>`,
                            iconSize: [0, 0],
                            iconAnchor: [0, 0]
                        });
                        
                        // Crear marcador para la etiqueta (ligeramente desplazado hacia arriba)
                        const labelMarker = L.marker([position.latitude + 0.0008, position.longitude], {
                            icon: labelIcon,
                            interactive: false
                        });
                        
                        // Agregar ambos marcadores a la capa
                        window.markersLayer.addLayer(marker);
                        window.markersLayer.addLayer(labelMarker);
                        bounds.push([position.latitude, position.longitude]);
                        markersAdded++;
                    }
                });
                
                console.log('🔵 CAPA 1: Added', markersAdded, 'valid markers to map');
                
                // Set initial view
                if (bounds.length > 0) {
                    console.log('🔵 CAPA 1: Found', bounds.length, 'devices on map');
                }
                
                // Always start centered on Lima, Peru
                map.setView([-12.0464, -77.0428], 11);
                console.log('🔵 CAPA 1: Map centered on Lima, Peru');
                
            } catch (error) {
                console.error('❌ CAPA 1: Error loading markers:', error);
            }
        }

        // NUEVO: Focus en dispositivo con modal horizontal compacto
        function focusOnDevice(deviceId) {
            console.log('CAPA 2: focusOnDevice called with deviceId:', deviceId);
            
            const mapInstance = window.mapInstance;
            if (!mapInstance) {
                console.warn('❌ CAPA 2: Map not initialized yet');
                return;
            }

            // Get device and position data from Laravel
            const devices = @json($devices ?? []);
            const positions = @json($positions ?? []);
            
            console.log('CAPA 2: Available devices:', devices.length, 'positions:', positions.length);

            // Find the device
            const device = devices.find(d => d.id === deviceId);
            if (!device) {
                console.error('❌ CAPA 2: Device not found for ID:', deviceId);
                return;
            }
            console.log('✅ CAPA 2: Device found:', device.name);

            // Find the device position
            const position = positions.find(p => p.deviceId === deviceId);
            if (!position || !position.latitude || !position.longitude) {
                console.error('❌ CAPA 2: Position not found for device:', device.name);
                // Crear posición simulada para demo
                const simulatedPosition = {
                    deviceId: deviceId,
                    latitude: -12.0464 + (Math.random() - 0.5) * 0.1,
                    longitude: -77.0428 + (Math.random() - 0.5) * 0.1,
                    deviceTime: new Date().toISOString(),
                    speed: Math.random() * 80,
                    attributes: {
                        totalDistance: Math.random() * 50000,
                        hours: Math.random() * 8760
                    }
                };
                console.log('CAPA 2: Using simulated position for demo');
                showCompactModal(device, simulatedPosition);
                return;
            }
            console.log('✅ CAPA 2: Position found for device');

            // CRITICAL: Guardar dispositivo seleccionado para persistencia
            selectedDeviceId = deviceId;
            selectedDeviceZoom = 16;
            isDeviceSelected = true;
            
            console.log(`🎯 CAPA 2: DEVICE SELECTED FOR PERSISTENCE: ${device.name} (ID: ${deviceId})`);

            // Center map on device location
            mapInstance.setView([position.latitude, position.longitude], selectedDeviceZoom, {
                animate: true,
                duration: 1.0
            });

            // Update device card styling to show selection
            document.querySelectorAll('.device-card').forEach(card => {
                card.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-gradient-to-r', 'from-blue-100', 'to-indigo-100', 'dark:from-blue-900', 'dark:to-indigo-900', 'shadow-xl', 'scale-105', 'ring-2', 'ring-blue-300', 'dark:ring-blue-600');
                card.style.transform = '';
            });

            const selectedCard = document.querySelector(`[data-device-id="${deviceId}"]`);
            if (selectedCard) {
                selectedCard.classList.add('border-blue-500', 'dark:border-blue-400', 'bg-gradient-to-r', 'from-blue-100', 'to-indigo-100', 'dark:from-blue-900', 'dark:to-indigo-900', 'shadow-xl', 'scale-105', 'ring-2', 'ring-blue-300', 'dark:ring-blue-600');
                selectedCard.style.transform = 'scale(1.05)';
            }

            // Mostrar modal compacto horizontal
            console.log('CAPA 6: About to show horizontal compact modal...');
            showCompactModal(device, position);

            // Mostrar indicador de dispositivo siendo tracked
            const indicator = document.getElementById('selectedDeviceIndicator');
            if (indicator) {
                indicator.classList.remove('hidden');
                indicator.textContent = `Tracking: ${device.name}`;
            }
            
            console.log(`✅ CAPA 2: Focused on device: ${device.name} - WILL PERSIST ON REFRESH`);
        }
        
        // NUEVO: Función para mostrar modal compacto horizontal sobre el mapa
        function showCompactModal(device, position) {
            console.log('CAPA 6: Starting showCompactModal for device:', device.name);
            
            const modal = document.getElementById('compactDeviceModal');
            const vehicleDiv = document.getElementById('vehicleInfoContent');
            const locationDiv = document.getElementById('locationInfoContent');
            const dailySummaryDiv = document.getElementById('dailySummaryContent');
            
            if (!modal || !vehicleDiv || !locationDiv || !dailySummaryDiv) {
                console.error('❌ CAPA 6: Modal elements not found!');
                return;
            }
            
            try {
                console.log('✅ CAPA 6: All modal elements found, generating content...');
                
                // Generar contenido para los tres cuadros
                const vehicleContent = generateVehicleInfoContent(device, position);
                const locationContent = generateLocationInfoContent(device, position);
                const dailySummaryContent = generateDailySummaryContent(device, position);
                
                // Actualizar contenido
                vehicleDiv.innerHTML = vehicleContent;
                locationDiv.innerHTML = locationContent;
                dailySummaryDiv.innerHTML = dailySummaryContent;
                
                console.log('✅ CAPA 6: Content updated, showing modal...');
                
                // Mostrar modal con animación
                modal.classList.remove('hidden');
                modal.style.transform = 'translate(-50%, 50%) scale(0.9)';
                modal.style.opacity = '0';
                
                setTimeout(() => {
                    modal.style.transform = 'translate(-50%, 50%) scale(1)';
                    modal.style.opacity = '1';
                    modal.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                }, 10);
                
                // Configurar botón de cerrar
                const closeButton = document.getElementById('closeCompactModal');
                if (closeButton) {
                    closeButton.onclick = closeCompactModal;
                }
                
                console.log('✅ CAPA 6: Horizontal compact modal with 3 boxes is now floating over the map!');
                
            } catch (error) {
                console.error('💥 CAPA 6: Exception in showCompactModal:', error);
            }
        }
        
        // NUEVO: Generar contenido HTML para el primer cuadro (información del vehículo)
        function generateVehicleInfoContent(device, position) {
            try {
                const isOnline = device.status === 'online';
                const statusColor = isOnline ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                const statusBg = isOnline ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900';
                const statusDot = isOnline ? 'bg-green-500' : 'bg-red-500';
                
                // Calcular velocidad
                let speed = 0;
                let motionStatus = 'Detenido';
                
                if (position && position.speed !== undefined) {
                    speed = Math.round(position.speed * 1.852); // knots to km/h
                    motionStatus = speed > 0 ? 'En movimiento' : 'Detenido';
                }
                
                // Calcular distancia y horas
                let totalDistance = 0;
                let totalHours = 0;
                
                if (position && position.attributes) {
                    if (position.attributes.totalDistance) {
                        totalDistance = Math.round(position.attributes.totalDistance / 1000);
                    }
                    if (position.attributes.hours) {
                        totalHours = Math.round(position.attributes.hours / 3600);
                    }
                }
                
                return `
                    <div class="space-y-0.5">
                        <!-- Info básica del vehículo -->
                        <div class="bg-pink-50 dark:bg-pink-900 rounded px-1 py-0.5">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-gray-900 dark:text-white text-[8px] truncate leading-none">${device.name || 'Dispositivo'}</h4>
                                <div class="flex items-center px-1 py-0.5 rounded-full text-[7px] font-medium ${statusBg} ${statusColor}">
                                    <div class="w-1 h-1 rounded-full mr-0.5 ${statusDot}"></div>
                                    ${isOnline ? 'Online' : 'Offline'}
                                </div>
                            </div>
                            <div class="text-[7px] text-gray-600 dark:text-gray-400 truncate leading-none">
                                <strong>ID:</strong> ${device.uniqueId || device.id}
                            </div>
                        </div>
                        
                        <!-- Velocidad -->
                        <div class="${speed > 0 ? 'bg-green-50 dark:bg-green-900' : 'bg-blue-50 dark:bg-blue-900'} rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[8px] leading-none">Velocidad</div>
                                <div class="text-[8px] font-bold ${speed > 0 ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400'} leading-none">
                                    ${speed} km/h
                                </div>
                                <div class="text-[7px] ${speed > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'} leading-none">
                                    ${motionStatus}
                                </div>
                            </div>
                        </div>

                        <!-- Distancia y horas -->
                        <div class="bg-orange-50 dark:bg-orange-900 rounded px-1 py-0.5">
                            <div class="grid grid-cols-2 gap-0.5 text-[8px]">
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Distancia</div>
                                    <div class="text-[8px] font-bold text-orange-600 dark:text-orange-400 leading-none">
                                        ${totalDistance.toLocaleString()} km
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Horas</div>
                                    <div class="text-[8px] font-bold text-orange-600 dark:text-orange-400 leading-none">
                                        ${totalHours.toLocaleString()} h
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
            } catch (error) {
                console.error('💥 CAPA 6: Error generating vehicle content:', error);
                return `<div class="p-1 text-red-600 text-xs">Error cargando información del vehículo</div>`;
            }
        }

        // NUEVO: Generar contenido HTML para el segundo cuadro (información de ubicación)
        function generateLocationInfoContent(device, position) {
            try {
                // Procesar coordenadas
                const coordinates = position && position.latitude && position.longitude 
                    ? `${position.latitude.toFixed(4)}, ${position.longitude.toFixed(4)}`
                    : 'Sin coordenadas';
                    
                // Fecha de última actualización
                let lastUpdate = 'N/A';
                if (position && position.deviceTime) {
                    const date = new Date(position.deviceTime);
                    lastUpdate = date.toLocaleString('es-ES', {
                        day: '2-digit',
                        month: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } else if (device && device.lastUpdate) {
                    const date = new Date(device.lastUpdate);
                    lastUpdate = date.toLocaleString('es-ES', {
                        day: '2-digit',
                        month: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }

                // Obtener dirección real usando geocoding
                let address = 'Obteniendo dirección...';
                
                // Cache simple para evitar peticiones repetidas
                if (!window.geocodeCache) {
                    window.geocodeCache = {};
                }
                
                const coordKey = `${position.latitude},${position.longitude}`;
                
                if (window.geocodeCache[coordKey]) {
                    // Usar dirección del cache
                    address = window.geocodeCache[coordKey];
                } else {
                    // Obtener dirección de forma asíncrona
                    setTimeout(() => {
                        getAddressForCoordinates(position.latitude, position.longitude, coordKey);
                    }, 100);
                }
                
                return `
                    <div class="space-y-0.5">
                        <!-- Fecha -->
                        <div class="bg-purple-50 dark:bg-purple-900 rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[8px] leading-none">Última Comunicación</div>
                                <div class="text-[8px] font-bold text-purple-600 dark:text-purple-400 leading-none">
                                    ${lastUpdate}
                                </div>
                            </div>
                        </div>

                        <!-- Coordenadas -->
                        <div class="bg-blue-50 dark:bg-blue-900 rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[8px] leading-none">
                                    Coordenadas
                                </div>
                                <div class="text-[7px] font-mono text-blue-600 dark:text-blue-400 font-bold leading-none">
                                    ${coordinates}
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="bg-green-50 dark:bg-green-900 rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[8px] leading-none">
                                    Dirección
                                </div>
                                <div class="text-[7px] text-green-600 dark:text-green-400 font-medium leading-none px-1 break-words" data-coord-key="${coordKey}">
                                    ${address}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
            } catch (error) {
                console.error('💥 CAPA 6: Error generating location content:', error);
                return `<div class="p-1 text-red-600 text-xs">Error cargando información de ubicación</div>`;
            }
        }

        // NUEVO: Generar contenido HTML para el tercer cuadro (resumen diario)
        function generateDailySummaryContent(device, position) {
            try {
                // Calcular datos simulados para el resumen diario
                const today = new Date();
                const todayStr = today.toLocaleDateString('es-ES', { 
                    day: '2-digit', 
                    month: '2-digit' 
                });

                // Datos simulados basados en el dispositivo
                const deviceId = device.id || 1;
                const seed = deviceId * today.getDate(); // Semilla para datos consistentes por día
                
                // Kilómetros recorridos hoy (simulado)
                const dailyKm = Math.round(50 + (seed % 150)); // Entre 50-200 km
                
                // Tiempo de conducción (simulado)
                const drivingHours = Math.floor(2 + (seed % 8)); // Entre 2-10 horas
                const drivingMinutes = Math.floor((seed * 7) % 60); // Minutos aleatorios
                
                // Consumo de combustible (simulado)
                const fuelConsumption = (dailyKm * 0.08 + (seed % 5)).toFixed(1); // ~8L/100km base
                
                // Eficiencia (km por litro)
                const efficiency = (dailyKm / parseFloat(fuelConsumption)).toFixed(1);
                
                // Número de paradas
                const stops = Math.floor(3 + (seed % 8)); // Entre 3-10 paradas
                
                // Velocidad promedio
                const avgSpeed = Math.round(dailyKm / (drivingHours + drivingMinutes/60));

                return `
                    <div class="space-y-0.5">
                        <!-- Fecha del resumen -->
                        <div class="bg-blue-50 dark:bg-blue-900 rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[8px] leading-none">Resumen del ${todayStr}</div>
                                <div class="text-[8px] font-bold text-blue-600 dark:text-blue-400 leading-none">
                                    ${device.name || 'Dispositivo'}
                                </div>
                            </div>
                        </div>

                        <!-- Kilómetros y tiempo -->
                        <div class="bg-green-50 dark:bg-green-900 rounded px-1 py-0.5">
                            <div class="grid grid-cols-2 gap-0.5 text-[8px]">
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Km Hoy</div>
                                    <div class="text-[8px] font-bold text-green-600 dark:text-green-400 leading-none">
                                        ${dailyKm} km
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Tiempo</div>
                                    <div class="text-[8px] font-bold text-green-600 dark:text-green-400 leading-none">
                                        ${drivingHours}h ${drivingMinutes}m
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Combustible y eficiencia combinados -->
                        <div class="bg-yellow-50 dark:bg-yellow-900 rounded px-1 py-0.5">
                            <div class="text-center">
                                <div class="font-medium text-gray-700 dark:text-gray-300 text-[7px] leading-none">Combustible</div>
                                <div class="text-[7px] font-bold text-yellow-600 dark:text-yellow-400 leading-none">
                                    ${fuelConsumption}L (Efic: ${efficiency} km/L)
                                </div>
                            </div>
                        </div>

                        <!-- Paradas y velocidad promedio -->
                        <div class="bg-indigo-50 dark:bg-indigo-900 rounded px-1 py-0.5">
                            <div class="grid grid-cols-2 gap-0.5 text-[8px]">
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Paradas</div>
                                    <div class="text-[8px] font-bold text-indigo-600 dark:text-indigo-400 leading-none">
                                        ${stops}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-gray-700 dark:text-gray-300 leading-none">Vel. Prom.</div>
                                    <div class="text-[8px] font-bold text-indigo-600 dark:text-indigo-400 leading-none">
                                        ${avgSpeed} km/h
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
            } catch (error) {
                console.error('💥 CAPA 6: Error generating daily summary content:', error);
                return `<div class="p-1 text-red-600 text-xs">Error cargando resumen diario</div>`;
            }
        }


        
        // NUEVO: Cerrar modal compacto
        function closeCompactModal() {
            const modal = document.getElementById('compactDeviceModal');
            
            if (modal) {
                modal.style.transform = 'translate(-50%, 50%) scale(0.9)';
                modal.style.opacity = '0';
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.style.transition = '';
                }, 300);
                
                // Limpiar selección de dispositivos
                document.querySelectorAll('.device-card').forEach(card => {
                    card.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-gradient-to-r', 'from-blue-100', 'to-indigo-100', 'dark:from-blue-900', 'dark:to-indigo-900', 'shadow-xl', 'scale-105', 'ring-2', 'ring-blue-300', 'dark:ring-blue-600');
                    card.style.transform = '';
                });
                
                // Ocultar indicador de tracking
                const indicator = document.getElementById('selectedDeviceIndicator');
                if (indicator) {
                    indicator.classList.add('hidden');
                }
                
                console.log('CAPA 6: Modal closed and selection cleared');
            }
        }

        // NUEVO: Función para mostrar todos los dispositivos en el mapa
        function fitAllDevices() {
            console.log('🔵 CAPA 1: FIT ALL - Starting fitAllDevices function');
            
            const mapInstance = window.mapInstance;
            if (!mapInstance) {
                console.warn('❌ CAPA 1: Map not initialized yet');
                return;
            }
            
            try {
                const positions = @json($positions ?? []);
                console.log('🔵 CAPA 1: Found', positions.length, 'positions');
                
                if (positions.length === 0) {
                    console.warn('⚠️ CAPA 1: No positions available to fit');
                    return;
                }
                
                const bounds = [];
                positions.forEach(position => {
                    if (position.latitude && position.longitude && 
                        !isNaN(position.latitude) && !isNaN(position.longitude)) {
                        bounds.push([position.latitude, position.longitude]);
                    }
                });
                
                if (bounds.length === 0) {
                    console.warn('⚠️ CAPA 1: No valid coordinates found');
                    return;
                }
                
                console.log('🔵 CAPA 1: Fitting map to', bounds.length, 'device locations');
                
                // Limpiar selección
                selectedDeviceId = null;
                isDeviceSelected = false;
                
                const indicator = document.getElementById('selectedDeviceIndicator');
                if (indicator) {
                    indicator.classList.add('hidden');
                }
                
                document.querySelectorAll('.device-card').forEach(card => {
                    card.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-gradient-to-r', 'from-blue-100', 'to-indigo-100', 'dark:from-blue-900', 'dark:to-indigo-900', 'shadow-xl', 'scale-105', 'ring-2', 'ring-blue-300', 'dark:ring-blue-600');
                    card.style.transform = '';
                });
                
                mapInstance.fitBounds(bounds, { 
                    padding: [20, 20],
                    animate: true,
                    duration: 1.0
                });
                
                console.log('✅ CAPA 1: Map fitted to show all devices');
                
            } catch (error) {
                console.error('❌ CAPA 1: Error in fitAllDevices:', error);
            }
        }

        // NUEVO: Función simple para obtener dirección real (principio KISS)
        async function getAddressForCoordinates(lat, lng, coordKey) {
            try {
                // Usar Nominatim (OpenStreetMap) directamente - simple y gratuito
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                
                if (response.ok) {
                    const data = await response.json();
                    let address = 'Dirección no disponible';
                    
                    if (data && data.display_name) {
                        // Formatear dirección de manera simple
                        const addr = data.address || {};
                        const parts = [];
                        
                        if (addr.road) {
                            let road = addr.road;
                            if (addr.house_number) road = `${addr.road} ${addr.house_number}`;
                            parts.push(road);
                        }
                        
                        if (addr.suburb || addr.neighbourhood) {
                            parts.push(addr.suburb || addr.neighbourhood);
                        }
                        
                        address = parts.length > 0 ? parts.join(', ') : data.display_name.split(',')[0];
                    }
                    
                    // Guardar en cache
                    window.geocodeCache[coordKey] = address;
                    
                    // Actualizar todos los elementos que muestran esta coordenada
                    updateAddressInUI(coordKey, address);
                    
                } else {
                    console.warn('Error en geocoding:', response.status);
                }
            } catch (error) {
                console.warn('Error obteniendo dirección:', error);
                window.geocodeCache[coordKey] = 'Error obteniendo dirección';
            }
        }

        // NUEVO: Actualizar dirección en la UI
        function updateAddressInUI(coordKey, address) {
            // Buscar todos los elementos que muestran direcciones para esta coordenada
            const addressElements = document.querySelectorAll(`[data-coord-key="${coordKey}"]`);
            addressElements.forEach(element => {
                element.innerHTML = `<span class="text-green-600 dark:text-green-400 break-words">📍 ${address}</span>`;
            });
        }

        // Variables globales
        let mapInitialized = false;
        let selectedDeviceId = null;
        let selectedDeviceZoom = null;
        let isDeviceSelected = false;

        // Initialize map when DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🎨 Laravel Map DOM ready, starting initialization...');
            
            setTimeout(function() {
                const success = initializeMap();
                if (success) {
                    console.log('✅ Laravel Map initialization successful!');
                    mapInitialized = true;
                } else {
                    console.warn('❌ Laravel Map initialization failed');
                }
            }, 300);

            // Configurar tecla ESC para cerrar modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('compactDeviceModal');
                    if (modal && !modal.classList.contains('hidden')) {
                        closeCompactModal();
                    }
                }
            });

            console.log('🎨 Laravel/Filament Map with Visual Layers initialized!');
            
            // SIDEBAR DEJADO POR DEFECTO - No interferir con el sidebar de Filament
            // hideSidebarByDefault();
        });

        // NUEVO: Función para ocultar completamente el sidebar después de que cargue
        function hideSidebarByDefault() {
            try {
                console.log('🔧 Esperando a que el sidebar cargue completamente...');
                
                // Función para verificar si el sidebar está completamente cargado
                function waitForSidebarToLoad() {
                    return new Promise((resolve) => {
                        const checkSidebar = () => {
                            const sidebar = document.querySelector('.fi-sidebar');
                            const navigationItems = document.querySelectorAll('.fi-sidebar-nav-item, .fi-sidebar-item');
                            
                            // Verificar que el sidebar existe y tiene elementos de navegación
                            if (sidebar && navigationItems.length > 0) {
                                console.log('✅ Sidebar cargado con', navigationItems.length, 'elementos de navegación');
                                resolve();
                            } else {
                                console.log('⏳ Esperando carga del sidebar...');
                                setTimeout(checkSidebar, 100);
                            }
                        };
                        checkSidebar();
                    });
                }
                
                // Esperar a que el sidebar cargue y luego ocultarlo
                waitForSidebarToLoad().then(() => {
                    setTimeout(() => {
                        console.log('🔧 Ocultando sidebar completamente...');
                        
                        // Agregar clase al body para ocultar sidebar
                        document.body.classList.add('sidebar-hidden');
                        
                        // Buscar y ocultar el sidebar de Filament
                        const sidebar = document.querySelector('.fi-sidebar');
                        if (sidebar) {
                            sidebar.style.display = 'none';
                            sidebar.style.visibility = 'hidden';
                            sidebar.style.opacity = '0';
                            sidebar.style.transform = 'translateX(-100%)';
                        }
                        
                        // Ajustar el contenido principal
                        const main = document.querySelector('.fi-main');
                        if (main) {
                            main.style.marginLeft = '0';
                            main.style.width = '100%';
                            main.style.maxWidth = '100%';
                        }
                        
                        // Ajustar el contenedor del mapa
                        const mapContainer = document.getElementById('mapContainer');
                        if (mapContainer) {
                            mapContainer.style.left = '0';
                            mapContainer.style.width = '100%';
                            mapContainer.style.maxWidth = '100%';
                        }
                        
                        // Ajustar el panel de dispositivos
                        const devicePanel = document.getElementById('devicePanel');
                        if (devicePanel) {
                            devicePanel.style.left = '1rem';
                        }
                        
                        // Ajustar el botón toggle
                        const toggleButton = document.getElementById('sidebarToggle');
                        if (toggleButton) {
                            toggleButton.style.left = '1rem';
                        }
                        
                        // Actualizar mapa si existe
                        setTimeout(() => {
                            if (window.mapInstance) {
                                window.mapInstance.invalidateSize();
                            }
                        }, 100);
                        
                        console.log('✅ Sidebar ocultado completamente después de cargar');
                        
                    }, 500); // Esperar 500ms adicionales después de que cargue
                });
                
            } catch (error) {
                console.error('❌ Error ocultando sidebar:', error);
            }
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.fi-sidebar');
            const body = document.body;
            let sidebarVisible = false; // Cambiado a false porque el sidebar estará visible por defecto

            console.log('Sidebar toggle initialized, sidebar found:', !!sidebar);

            if (toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    console.log('Toggle clicked, current state (sidebarVisible):', sidebarVisible);
                    
                    if (!sidebarVisible) {
                        // Hide sidebar - use CSS class only, don't directly modify display
                        body.classList.add('sidebar-hidden');
                        
                        // Update map and device panel immediately
                        updateMapLayout(false);
                        
                        sidebarVisible = true; // true = sidebar está oculto
                        console.log('Sidebar hidden via CSS class');
                    } else {
                        // Show sidebar - remove CSS class
                        body.classList.remove('sidebar-hidden');
                        
                        // Small delay to allow sidebar to render before updating layout
                        setTimeout(() => {
                            updateMapLayout(true);
                        }, 50);
                        
                        sidebarVisible = false; // false = sidebar está visible
                        console.log('Sidebar shown via CSS class');
                    }
                });
            } else {
                console.warn('Sidebar toggle elements not found:', {
                    toggleButton: !!toggleButton,
                    sidebar: !!sidebar
                });
            }
        });

        // Function to update map and device panel layout based on sidebar state
        function updateMapLayout(sidebarVisible) {
            const mapContainer = document.getElementById('mapContainer');
            const devicePanel = document.getElementById('devicePanel');
            const toggleButton = document.getElementById('sidebarToggle');

            if (sidebarVisible) {
                // Sidebar is visible - use default positioning
                mapContainer.style.left = 'var(--fi-sidebar-width, 16rem)';
                mapContainer.style.width = 'calc(100% - var(--fi-sidebar-width, 16rem))';
                mapContainer.style.transition = 'left 0.3s ease-in-out, width 0.3s ease-in-out';
                
                devicePanel.style.left = 'calc(var(--fi-sidebar-width, 16rem) + 1rem)';
                devicePanel.style.transition = 'left 0.3s ease-in-out';
                
                toggleButton.style.left = 'calc(var(--fi-sidebar-width, 16rem) + 1rem)';
                toggleButton.style.transition = 'left 0.3s ease-in-out';
            } else {
                // Sidebar is hidden - expand to full width
                mapContainer.style.left = '0';
                mapContainer.style.width = '100%';
                mapContainer.style.transition = 'left 0.3s ease-in-out, width 0.3s ease-in-out';
                
                devicePanel.style.left = '1rem';
                devicePanel.style.transition = 'left 0.3s ease-in-out';
                
                toggleButton.style.left = '1rem';
                toggleButton.style.transition = 'left 0.3s ease-in-out';
            }

            // Trigger map resize after layout change
            setTimeout(() => {
                if (window.mapInstance) {
                    window.mapInstance.invalidateSize();
                    console.log('Map resized after sidebar toggle');
                }
            }, 350);
        }
    </script>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <style>
        /* ========================================
           CAPA 1: MAP CONTAINER - MODERNO Y ELEGANTE
           ======================================== */
        #mapContainer {
            position: fixed !important;
            top: 0 !important;
            left: var(--fi-sidebar-width, 16rem) !important;
            right: 0 !important;
            bottom: 0 !important;
            width: calc(100% - var(--fi-sidebar-width, 16rem)) !important;
            height: 100% !important;
            z-index: 1 !important;
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.98), rgba(241, 245, 249, 0.98)) !important; /* Gradiente gris claro moderno */
        }
        
        #map {
            width: 100% !important;
            height: 100% !important;
            background: rgba(249, 250, 251, 0.95) !important; /* Fondo gris muy claro moderno para Leaflet */
            min-height: 400px !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
        }
        
        /* ========================================
           CAPA 2: DEVICE PANEL - MODERNO Y ELEGANTE
           ======================================== */
        #devicePanel {
            position: fixed !important;
            left: calc(var(--fi-sidebar-width, 16rem) + 1rem) !important;
            top: 4rem !important;
            width: 20rem !important;
            max-height: calc(100vh - 8rem) !important;
            z-index: 10 !important;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95)) !important; /* Gradiente blanco moderno */
            border-radius: 1.5rem !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
            border: 1px solid rgba(229, 231, 235, 0.5) !important; /* Borde sutil */
            backdrop-filter: blur(20px) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        /* ========================================
           CAPA 3: SIDEBAR TOGGLE - MODERNO Y ACCESIBLE
           ======================================== */
        #sidebarToggle {
            position: fixed !important;
            top: 1rem !important;
            left: calc(var(--fi-sidebar-width, 16rem) + 1rem) !important;
            z-index: 20 !important;
            background: transparent !important; /* Fondo transparente */
            border: none !important; /* Sin borde */
            border-radius: 1rem !important;
            padding: 0.75rem !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            cursor: pointer !important;
            backdrop-filter: blur(20px) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            ring: 1px solid rgba(156, 163, 175, 0.1) !important;
        }

        #sidebarToggle:hover {
            background: rgba(249, 250, 251, 0.98) !important; /* Hover sutil */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px) !important;
            border-color: rgba(99, 102, 241, 0.3) !important;
        }
        
        /* ========================================
           CAPA 6: MODAL COMPACTO - MODERNO Y ELEGANTE
           ======================================== */
        #compactDeviceModal {
            z-index: 9999 !important;
            position: fixed !important;
            bottom: 1.5rem !important; /* Posicionado en la parte inferior del mapa */
            right: 1.5rem !important; /* Iniciando desde la derecha de la pantalla */
            transform: none !important; /* Sin transformaciones */
            width: 56rem !important; /* Más ancho para mejor visualización */
            height: 18rem !important; /* Altura aumentada para mostrar combustible */
            background: transparent !important; /* Fondo transparente */
            border: none !important; /* Sin borde */
            display: flex !important; /* Layout horizontal */
            flex-direction: row !important; /* Dirección horizontal */
            gap: 1.25rem !important; /* Más espacio entre cuadros */
            padding: 1.25rem !important; /* Padding interno aumentado */
            border-radius: 1.5rem !important; /* Bordes más redondeados */
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important; /* Sombra elegante */
            backdrop-filter: blur(20px) !important; /* Efecto blur de fondo */
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            opacity: 1 !important;
            filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.15)) !important;
        }

        #compactDeviceModal.hidden {
            opacity: 0 !important;
            transform: translate(20px, 20px) scale(0.95) !important;
            pointer-events: none !important;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1)) !important;
        }

        .compact-modal {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.9)) !important; /* Gradiente blanco moderno */
            border: 1px solid rgba(229, 231, 235, 0.3) !important; /* Borde sutil */
            border-radius: 1rem !important;
            padding: 0.75rem !important; /* Padding aumentado para mejor respiración */
            flex: 1;
            min-width: 0;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
            overflow-y: auto !important;
            max-width: 280px !important; /* Ancho aumentado para más contenido */
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }
        
        .compact-modal:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
        }
        
        /* ========================================
           ESTILOS DE TEXTO PARA MODALES COMPACTOS
           ======================================== */
        #compactDeviceModal * {
            color: #1f2937 !important; /* Texto oscuro por defecto */
        }
        
        #compactDeviceModal h3,
        #compactDeviceModal h4,
        #compactDeviceModal .font-medium,
        #compactDeviceModal .font-bold {
            color: #111827 !important; /* Títulos más oscuros */
            font-weight: 600 !important;
        }
        
        #compactDeviceModal .text-xs,
        #compactDeviceModal .text-sm {
            color: #374151 !important; /* Texto pequeño legible */
        }
        
        /* Colores específicos para estados */
        #compactDeviceModal .text-green-600 {
            color: #059669 !important; /* Verde más oscuro */
        }
        
        #compactDeviceModal .text-red-600 {
            color: #dc2626 !important; /* Rojo más oscuro */
        }
        
        #compactDeviceModal .text-blue-600 {
            color: #2563eb !important; /* Azul más oscuro */
        }
        
        #compactDeviceModal .text-purple-600 {
            color: #9333ea !important; /* Púrpura más oscuro */
        }
        
        #compactDeviceModal .text-orange-600 {
            color: #ea580c !important; /* Naranja más oscuro */
        }
        
        #compactDeviceModal .text-gray-600,
        #compactDeviceModal .text-gray-700 {
            color: #4b5563 !important; /* Gris oscuro */
        }
        
        /* Asegurar que los fondos de colores mantengan contraste */
        #compactDeviceModal .bg-pink-50,
        #compactDeviceModal .bg-green-50,
        #compactDeviceModal .bg-blue-50,
        #compactDeviceModal .bg-purple-50,
        #compactDeviceModal .bg-orange-50 {
            background-color: rgba(249, 250, 251, 0.8) !important;
            border: 1px solid rgba(229, 231, 235, 0.5) !important;
        }
        
        /* Optimizar visualización del contenido en modales */
        .compact-modal * {
            max-width: 100% !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }
        
        /* Permitir texto multilínea para mejor legibilidad */
        .compact-modal .text-xs,
        .compact-modal .text-sm,
        .compact-modal p,
        .compact-modal div:not(.flex):not(.grid) {
            white-space: normal !important;
            line-height: 1.3 !important;
            overflow: visible !important;
        }
        
        /* Mantener títulos en una línea pero con ellipsis suave */
        .compact-modal h3,
        .compact-modal h4,
        .compact-modal .font-bold {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        
        /* ========================================
           CAPA 7: SCROLLBAR CUSTOM - MODERNO Y SUTIL
           ======================================== */
        .custom-scrollbar {
            overflow-y: scroll !important;
            overflow-x: hidden !important;
            scrollbar-width: thin !important;
            scrollbar-color: #6366f1 rgba(156, 163, 175, 0.2) !important; /* Moderno: Indigo/Gray */
        }
        
        /* FORZAR SCROLLBAR SIEMPRE VISIBLE */
        #deviceListContainer {
            overflow-y: scroll !important;
            overflow-x: hidden !important;
            scrollbar-width: thin !important;
            height: 400px !important;
            max-height: 400px !important;
            min-height: 400px !important;
        }
        
        /* FORZAR SCROLLBAR WEBKIT */
        #deviceListContainer::-webkit-scrollbar {
            width: 8px !important;
            height: 8px !important;
            display: block !important;
            -webkit-appearance: auto !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px !important;
            background: transparent !important;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(156, 163, 175, 0.1) !important;
            border-radius: 10px !important;
            margin: 4px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            border-radius: 10px !important;
            border: 2px solid transparent !important;
            background-clip: content-box !important;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.5) !important;
            transform: scaleY(1.1) !important;
        }
        
        /* SCROLLBAR NEUTRO Y FUNCIONAL */
        #deviceListContainer::-webkit-scrollbar-track {
            border-radius: 4px !important;
            margin: 2px !important;
        }

        #deviceListContainer::-webkit-scrollbar-thumb {
            border-radius: 4px !important;
            min-height: 20px !important;
        }

        #deviceListContainer::-webkit-scrollbar-thumb:hover {
            opacity: 0.8 !important;
        }
        
        /* Responsive para modal horizontal compacto */
        @media (max-width: 1400px) {
            #compactDeviceModal {
                width: 50rem !important;
                height: 17rem !important;
            }
        }

        @media (max-width: 1200px) {
            #compactDeviceModal {
                width: 45rem !important;
                height: 16rem !important;
            }
        }

        @media (max-width: 1024px) {
            #compactDeviceModal {
                width: 40rem !important;
                height: 15rem !important;
            }
        }

        @media (max-width: 768px) {
            #compactDeviceModal {
                flex-direction: column !important;
                width: 20rem !important;
                height: auto !important;
                max-height: 60vh !important;
                overflow-y: auto !important;
                bottom: 1rem !important; /* Mantener en la parte inferior también en móviles */
                right: 1rem !important; /* Desde la derecha también en móviles */
            }
            
            .compact-modal {
                flex: none !important;
                height: auto !important;
            }
        }

        /* Fallback sidebar positioning */
        .fi-sidebar ~ .fi-main #mapContainer {
            left: 16rem !important;
            width: calc(100% - 16rem) !important;
        }
        
        .fi-sidebar ~ .fi-main #devicePanel {
            left: calc(16rem + 1rem) !important;
        }
        
        /* When sidebar is collapsed */
        .fi-sidebar-collapsed #mapContainer {
            left: 4rem !important;
            width: calc(100% - 4rem) !important;
        }
        
        .fi-sidebar-collapsed #devicePanel {
            left: calc(4rem + 1rem) !important;
        }
        
        /* Smooth transitions */
        #mapContainer {
            transition: left 0.3s ease-in-out, width 0.3s ease-in-out !important;
        }
        
        #devicePanel {
            transition: left 0.3s ease-in-out !important;
        }
        
        /* When sidebar is hidden */
        body.sidebar-hidden .fi-sidebar {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            transform: translateX(-100%) !important;
        }
        
        body.sidebar-hidden .fi-main {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        body.sidebar-hidden #mapContainer {
            left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        body.sidebar-hidden #devicePanel {
            left: 1rem !important;
        }
        
        body.sidebar-hidden #sidebarToggle {
            left: 1rem !important;
        }
        
        /* Ensure Leaflet container has proper dimensions */
        .leaflet-container {
            height: 100% !important;
            width: 100% !important;
        }
        
        /* Hide default Filament page padding */
        .fi-page {
            padding: 0 !important;
        }
        
        .fi-page-content {
            padding: 0 !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            #mapContainer {
                left: 0 !important;
                width: 100% !important;
            }
            
            #devicePanel {
                left: 1rem !important;
            }
            
            #sidebarToggle {
                left: 1rem !important;
            }
        }

        /* Indicadores de scroll mejorados */
        .scroll-indicator {
            position: absolute;
            right: 8px;
            width: 20px;
            height: 20px;
            background: linear-gradient(to bottom, #0891b2, #0e7490); /* CAPA 7: Cian */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 10;
        }
        
        .scroll-indicator.show {
            opacity: 0.8;
        }
        
        .scroll-indicator svg {
            width: 12px;
            height: 12px;
            color: white;
        }
        
        .scroll-indicator.top {
            top: 8px;
        }
        
        .scroll-indicator.bottom {
            bottom: 8px;
        }
        
        /* ========================================
           CAPA 8: ETIQUETAS DE VEHÍCULOS - MODERNO Y LEGIBLE
           ======================================== */
        .vehicle-label {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            pointer-events: none !important;
        }
        
        .vehicle-label-content {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95)) !important;
            color: #1f2937 !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            line-height: 1.2 !important;
            text-align: center !important;
            white-space: nowrap !important;
            border: 1px solid rgba(229, 231, 235, 0.6) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            backdrop-filter: blur(10px) !important;
            transform: translateX(-50%) !important;
            min-width: max-content !important;
            max-width: 120px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        /* Tema oscuro para las etiquetas */
        @media (prefers-color-scheme: dark) {
            .vehicle-label-content {
                background: linear-gradient(135deg, rgba(31, 41, 55, 0.95), rgba(17, 24, 39, 0.95)) !important;
                color: #f9fafb !important;
                border: 1px solid rgba(75, 85, 99, 0.6) !important;
            }
        }
        
        /* Hover effect para mejor visibilidad */
        .vehicle-label-content:hover {
            transform: translateX(-50%) scale(1.05) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2) !important;
        }
        
        /* Responsive para etiquetas */
        @media (max-width: 768px) {
            .vehicle-label-content {
                font-size: 0.6875rem !important;
                padding: 0.25rem 0.5rem !important;
                max-width: 100px !important;
            }
        }
    </style>
    @endpush
</x-filament-panels::page>