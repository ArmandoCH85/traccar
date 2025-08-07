<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-[calc(100vh-8rem)]">
        
        <!-- Device List Panel -->
        <div class="lg:col-span-1">
            @if (count($devices) > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        Devices ({{ count($devices) }})
                    </x-slot>
                    
                    <x-slot name="headerEnd">
                        <x-filament::button 
                            wire:click="refreshMap" 
                            icon="heroicon-m-arrow-path"
                            color="gray"
                            size="sm"
                        >
                        </x-filament::button>
                    </x-slot>

                        @foreach ($devices as $device)
                            <div class="device-card p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors cursor-pointer" 
                                 onclick="focusOnDevice({{ $device['id'] }})"
                                 wire:click="showDeviceDetails({{ $device['id'] }})"
                                 data-device-id="{{ $device['id'] }}"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate">
                                            {{ $device['name'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $device['uniqueId'] }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full mr-2 {{ isset($device['status']) && $device['status'] === 'online' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                            <span class="text-xs font-medium {{ isset($device['status']) && $device['status'] === 'online' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $device['status'] ?? 'Offline' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Statistics Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-3 gap-4 text-center text-xs">
                            <div>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ count($devices) }}</p>
                                <p class="text-gray-500 dark:text-gray-400">Total</p>
                            </div>
                            <div>
                                <p class="font-bold text-green-600 dark:text-green-400">
                                    {{ collect($devices)->where('status', 'online')->count() }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400">Online</p>
                            </div>
                            <div>
                                <p class="font-bold text-red-600 dark:text-red-400">
                                    {{ collect($devices)->where('status', '!=', 'online')->count() }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400">Offline</p>
                            </div>
                        </div>
                    </div>
                </x-filament::section>
            @else
                <x-filament::section>
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">
                            No devices found. Make sure you're authenticated with Traccar.
                        </p>
                    </div>
                </x-filament::section>
            @endif
        </div>

        <!-- Map Panel -->
        <div class="lg:col-span-3">
            <x-filament::section>
                <x-slot name="heading">
                    Interactive Map
                </x-slot>
                
                <div id="mapContainer" class="w-full h-[calc(100vh-12rem)] rounded-lg overflow-hidden">
                    <div id="map" class="w-full h-full"></div>
                </div>
            </x-filament::section>
        </div>
    </div>

    <!-- Hidden actions wireframe for modal -->
    <div style="display: none;">
        {{ $this->getAction('viewDeviceDetails') }}
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script>
        console.log('Leaflet loaded:', typeof L);
        
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded, initializing map');
            
            setTimeout(function() {
                console.log('Starting map initialization');
                
                try {
                    // Verificar que el elemento existe
                    const mapElement = document.getElementById('map');
                    console.log('Map element found:', mapElement);
                    console.log('Map element dimensions:', {
                        width: mapElement.offsetWidth,
                        height: mapElement.offsetHeight,
                        clientWidth: mapElement.clientWidth,
                        clientHeight: mapElement.clientHeight
                    });
                    
                    if (!mapElement) {
                        console.error('Map element not found!');
                        return;
                    }
                    
                    // Verificar y corregir dimensiones si es necesario
                    console.log('Map element computed style:', {
                        width: window.getComputedStyle(mapElement).width,
                        height: window.getComputedStyle(mapElement).height,
                        display: window.getComputedStyle(mapElement).display
                    });
                    
                    // Forzar dimensiones explícitas para asegurar que Leaflet funcione
                    if (mapElement.offsetHeight === 0 || mapElement.offsetWidth === 0) {
                        console.warn('Map element has invalid dimensions, forcing explicit dimensions');
                        mapElement.style.width = '100%';
                        mapElement.style.height = '100%';
                        mapElement.style.minHeight = '400px';
                        
                        // Force container dimensions too
                        const container = mapElement.parentElement;
                        if (container) {
                            container.style.width = '100%';
                            container.style.height = '100%';
                        }
                    }
                    
                    // Inicializar mapa básico
                    const map = L.map('map', {
                        center: [0, 0],
                        zoom: 2,
                        zoomControl: true
                    });
                    
                    // Store map instance globally for resize functionality
                    window.mapInstance = map;
                    
                    console.log('Map created:', map);
                    
                    // Agregar tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors',
                        maxZoom: 19
                    }).addTo(map);
                    
                    console.log('Tiles added');
                    
                    // Obtener datos de dispositivos y posiciones
                    const devices = @json($devices);
                    const positions = @json($positions);
                    
                    console.log('Devices:', devices.length, 'Positions:', positions.length);
                    console.log('First device:', devices[0]);
                    console.log('First position:', positions[0]);
                    
                    // Crear mapa de dispositivos
                    const deviceMap = {};
                    devices.forEach(device => {
                        deviceMap[device.id] = device;
                    });
                    
                    // Agregar markers de posiciones reales
                    const bounds = [];
                    positions.forEach(position => {
                        const device = deviceMap[position.deviceId];
                        if (device && position.latitude && position.longitude) {
                            const marker = L.marker([position.latitude, position.longitude]).addTo(map);
                            marker.bindPopup(`<b>${device.name}</b><br>ID: ${device.uniqueId}`);
                            bounds.push([position.latitude, position.longitude]);
                        }
                    });
                    
                    // Ajustar vista a todas las posiciones
                    if (bounds.length > 0) {
                        map.fitBounds(bounds);
                        console.log('Map fitted to', bounds.length, 'positions');
                    }
                    
                    console.log('Real markers added');
                    
                    // Forzar resize después de un momento (múltiples intentos)
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Map resized - first attempt');
                    }, 100);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Map resized - second attempt');
                    }, 500);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Map resized - third attempt');
                    }, 1000);
                    
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }, 500);
        });

        // Sidebar toggle functionality for Filament
        function toggleSidebar() {
            // Try different selectors for Filament sidebar
            const sidebar = document.querySelector('.fi-sidebar') || 
                           document.querySelector('[data-sidebar]') ||
                           document.querySelector('aside') ||
                           document.querySelector('.fi-sidebar-nav');
            
            if (sidebar) {
                // Toggle sidebar visibility
                sidebar.classList.toggle('fi-sidebar-hidden');
                
                // Update map and device panel positions
                const mapContainer = document.getElementById('mapContainer');
                const devicePanel = document.getElementById('devicePanel');
                const noDevicesPanel = document.querySelector('.fixed.left-4.top-16');
                
                if (sidebar.classList.contains('fi-sidebar-hidden')) {
                    // Sidebar hidden - expand map to full width, move device panel to left edge
                    if (mapContainer) {
                        mapContainer.style.left = '0';
                    }
                    if (devicePanel) {
                        devicePanel.style.left = '1rem'; // 16px
                    }
                    if (noDevicesPanel && noDevicesPanel !== devicePanel) {
                        noDevicesPanel.style.left = '1rem'; // 16px
                    }
                } else {
                    // Sidebar visible - adjust map position, normal device panel position  
                    const sidebarWidth = sidebar.offsetWidth || 256; // fallback to typical width
                    if (mapContainer) {
                        mapContainer.style.left = sidebarWidth + 'px';
                    }
                    if (devicePanel) {
                        devicePanel.style.left = (sidebarWidth + 16) + 'px'; // sidebar width + 1rem
                    }
                    if (noDevicesPanel && noDevicesPanel !== devicePanel) {
                        noDevicesPanel.style.left = (sidebarWidth + 16) + 'px'; // sidebar width + 1rem
                    }
                }
                
                // Trigger map resize after position change
                setTimeout(() => {
                    const mapInstance = window.mapInstance;
                    if (mapInstance) {
                        mapInstance.invalidateSize();
                    }
                }, 300);
            } else {
                console.warn('Filament sidebar not found. Available elements:', 
                    Array.from(document.querySelectorAll('*')).filter(el => 
                        el.className.includes('sidebar') || el.tagName === 'ASIDE'
                    )
                );
            }
        }

        // Device panel toggle functionality (for future enhancement)
        function toggleDevicePanel() {
            const panel = document.getElementById('devicePanel');
            if (panel) {
                panel.classList.toggle('-translate-x-full');
            }
        }

        // Focus on specific device in map and show details modal
        function focusOnDevice(deviceId) {
            const mapInstance = window.mapInstance;
            if (!mapInstance) {
                console.warn('Map not initialized yet');
                return;
            }

            // Get device and position data
            const devices = @json($devices);
            const positions = @json($positions);

            // Find the device
            const device = devices.find(d => d.id === deviceId);
            if (!device) {
                console.warn('Device not found:', deviceId);
                return;
            }

            // Find the device position
            const position = positions.find(p => p.deviceId === deviceId);
            if (!position || !position.latitude || !position.longitude) {
                console.warn('Position not found for device:', device.name);
                return;
            }

            // Center map on device location
            mapInstance.setView([position.latitude, position.longitude], 16, {
                animate: true,
                duration: 1.0
            });

            // Find and highlight the marker
            mapInstance.eachLayer(function(layer) {
                if (layer instanceof L.Marker) {
                    const markerLatLng = layer.getLatLng();
                    if (Math.abs(markerLatLng.lat - position.latitude) < 0.0001 && 
                        Math.abs(markerLatLng.lng - position.longitude) < 0.0001) {
                        // Open popup for this marker
                        layer.openPopup();
                        
                        // Add temporary highlight effect
                        const icon = layer.getElement();
                        if (icon) {
                            icon.style.filter = 'drop-shadow(0 0 10px #3b82f6)';
                            setTimeout(() => {
                                icon.style.filter = '';
                            }, 2000);
                        }
                    }
                }
            });

            // Update device card styling to show selection
            document.querySelectorAll('.device-card').forEach(card => {
                card.classList.remove('bg-blue-100', 'dark:bg-blue-800', 'border-blue-300', 'dark:border-blue-600');
            });
            
            const selectedCard = document.querySelector(`[data-device-id="${deviceId}"]`);
            if (selectedCard) {
                selectedCard.classList.add('bg-blue-100', 'dark:bg-blue-800', 'border-blue-300', 'dark:border-blue-600');
                setTimeout(() => {
                    selectedCard.classList.remove('bg-blue-100', 'dark:bg-blue-800', 'border-blue-300', 'dark:border-blue-600');
                }, 3000);
            }

            // Modal is now handled by wire:click on the device card

            console.log(`Focused on device: ${device.name} at [${position.latitude}, ${position.longitude}]`);
        }

        // Auto-refresh functionality for real-time updates
        let autoRefreshInterval;

        function startAutoRefresh() {
            console.log('Starting auto-refresh every 10 seconds...');
            
            autoRefreshInterval = setInterval(function() {
                console.log('Auto-refreshing map data...');
                
                // Call Livewire method to refresh data
                try {
                    window.Livewire.find('{{ $this->getId() }}').call('refreshMap');
                } catch (error) {
                    console.error('Error during auto-refresh:', error);
                }
            }, 10000); // 10 seconds
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
                console.log('Auto-refresh stopped');
            }
        }

        // Start auto-refresh when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Start auto-refresh after map is initialized
            setTimeout(function() {
                startAutoRefresh();
            }, 2000);
        });

        // Stop auto-refresh when page is about to unload
        window.addEventListener('beforeunload', function() {
            stopAutoRefresh();
        });

        // Listen for Livewire updates and refresh map markers
        document.addEventListener('livewire:updated', function() {
            console.log('Livewire updated, refreshing map markers...');
            updateMapMarkers();
        });

        // Simple map resize on modal events
        document.addEventListener('livewire:modal-opened', function() {
            if (window.mapInstance) {
                setTimeout(() => window.mapInstance.invalidateSize(), 100);
            }
        });

        // Function to update map markers with new data
        function updateMapMarkers() {
            if (!window.mapInstance) {
                console.warn('Map not initialized yet for marker update');
                return;
            }

            // Get updated data
            const devices = @json($devices);
            const positions = @json($positions);

            console.log('Updating map with', devices.length, 'devices and', positions.length, 'positions');

            // Clear existing markers
            window.mapInstance.eachLayer(function(layer) {
                if (layer instanceof L.Marker) {
                    window.mapInstance.removeLayer(layer);
                }
            });

            // Create device map
            const deviceMap = {};
            devices.forEach(device => {
                deviceMap[device.id] = device;
            });

            // Add updated markers
            const bounds = [];
            positions.forEach(position => {
                const device = deviceMap[position.deviceId];
                if (device && position.latitude && position.longitude) {
                    const marker = L.marker([position.latitude, position.longitude]).addTo(window.mapInstance);
                    marker.bindPopup(`<b>${device.name}</b><br>ID: ${device.uniqueId}<br>Speed: ${Math.round(position.speed * 1.852)} km/h`);
                    bounds.push([position.latitude, position.longitude]);
                }
            });

            console.log('Updated', bounds.length, 'markers on map');
        }
    </script>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <style>
        
        #mapContainer {
            min-height: 400px !important;
            height: 100vh !important;
        }
        
        #map {
            background: #f0f0f0;
            min-height: 400px !important;
            width: 100% !important;
            height: 100% !important;
        }
        
        /* Sidebar toggle styles */
        .fi-sidebar-hidden {
            transform: translateX(-100%) !important;
        }
        
        .fi-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Ensure map is behind everything */
        .fi-page {
            overflow: hidden !important;
        }
        
        /* Hide default page padding for fullscreen effect */
        .fi-page-content {
            padding: 0 !important;
        }
        
        /* Smooth transitions for map and device panel */
        #mapContainer, #devicePanel {
            transition: left 0.3s ease-in-out;
        }
        
        /* Simple z-index hierarchy */
        #mapContainer {
            z-index: 5;
        }
        
        #devicePanel {
            z-index: 10;
        }
        
        /* Target specific Filament slideOver backdrop */
        [data-slot="backdrop"]:has(+ [data-slot="panel"]) {
            background-color: transparent !important;
            backdrop-filter: none !important;
        }
        
        /* Alternative selectors for slideOver backdrop */
        .fi-slide-over-backdrop,
        .fi-modal-backdrop,
        [x-show][x-transition\:enter] {
            background-color: rgba(0, 0, 0, 0) !important;
            backdrop-filter: none !important;
        }
        
        /* Ensure map container stays above backdrop */
        #mapContainer {
            z-index: 999 !important;
            position: fixed !important;
        }
        
        /* Ensure device panel stays visible */
        #devicePanel {
            z-index: 1000 !important;
        }
    </style>
    @endpush
</x-filament-panels::page>