<?php

namespace App\Filament\Pages;

use App\Services\TraccarService;
use App\Services\GeocodingService;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;

class MapPage extends Page implements HasActions, HasForms, HasInfolists
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithInfolists;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Tracking';

    protected static ?string $navigationLabel = 'Map';

    protected static ?string $title = 'Device Map';

    protected static ?int $navigationSort = 2;

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected static string $view = 'filament.pages.map-page';

    public $devices = [];
    public $positions = [];
    public $selectedDevice = null;
    public $selectedPosition = null;


    public function mount(): void
    {
        $this->loadMapData();
    }

    public function loadMapData(): void
    {
        try {
            $traccarService = app(TraccarService::class);
            
            // Intentar autenticarse automáticamente si no está autenticado
            if (!$traccarService->isAuthenticated()) {
                \Log::info('MapPage: Attempting to authenticate with Traccar...');
                $authResult = $traccarService->login('administrador@lubarsa.com', 'administrador');
                \Log::info('MapPage: Authentication result: ' . ($authResult ? 'SUCCESS' : 'FAILED'));
            }
            
            if ($traccarService->isAuthenticated()) {
                \Log::info('MapPage: Traccar authenticated, loading data...');
                
                $devices = $traccarService->getDevices();
                
                // ESTRATEGIA MÚLTIPLE: Probar diferentes métodos para obtener datos completos de velocidad
                $positions = [];
                
                // Método 1: Últimas posiciones con all=true
                try {
                    $positions = $traccarService->getLastPositions();
                    \Log::info('MapPage: Method 1 (getLastPositions) returned: ' . count($positions) . ' positions');
                } catch (\Exception $e) {
                    \Log::error('MapPage: Method 1 failed: ' . $e->getMessage());
                }
                
                // Método 2: Si no tenemos suficientes datos, probar método alternativo
                if (empty($positions)) {
                    \Log::info('MapPage: Method 1 returned empty, trying Method 2 (getLatestPositions)');
                    try {
                        $positions = $traccarService->getLatestPositions();
                        \Log::info('MapPage: Method 2 returned: ' . count($positions) . ' positions');
                    } catch (\Exception $e) {
                        \Log::error('MapPage: Method 2 failed: ' . $e->getMessage());
                    }
                }
                
                // Método 3: Fallback al método original
                if (empty($positions)) {
                    \Log::info('MapPage: Both new methods failed, falling back to original getPositions');
                    $positions = $traccarService->getPositions();
                    \Log::info('MapPage: Original method returned: ' . count($positions) . ' positions');
                }
                
                // Ensure we have arrays
                $this->devices = is_array($devices) ? $devices : [];
                $this->positions = is_array($positions) ? $positions : [];
                
                // Debug logging with more details
                \Log::info('MapPage: Successfully loaded ' . count($this->devices) . ' devices and ' . count($this->positions) . ' positions');
                
                if (count($this->devices) > 0) {
                    \Log::info('MapPage: First device: ' . json_encode($this->devices[0]));
                }
                
                if (count($this->positions) > 0) {
                    \Log::info('MapPage: First position: ' . json_encode($this->positions[0]));
                    
                    // DEBUG: Verificar si las posiciones tienen datos de velocidad
                    $positionsWithSpeed = array_filter($this->positions, function($pos) {
                        return isset($pos['speed']) && $pos['speed'] !== null;
                    });
                    
                    \Log::info('MapPage: Positions with speed data: ' . count($positionsWithSpeed) . ' out of ' . count($this->positions));
                    
                    if (count($positionsWithSpeed) > 0) {
                        \Log::info('MapPage: Sample position with speed: ' . json_encode($positionsWithSpeed[0]));
                    } else {
                        \Log::warning('MapPage: NO POSITIONS HAVE SPEED DATA! This is the problem.');
                        
                        // Log all available fields in positions to see what we have
                        if (count($this->positions) > 0) {
                            \Log::info('MapPage: Available fields in first position: ' . implode(', ', array_keys($this->positions[0])));
                        }
                    }
                }
                
                // Add status information to devices if not present
                foreach ($this->devices as &$device) {
                    if (!isset($device['status'])) {
                        // Find corresponding position to determine status
                        $position = collect($this->positions)->firstWhere('deviceId', $device['id']);
                        if ($position && isset($position['fixTime'])) {
                            $lastUpdate = \Carbon\Carbon::parse($position['fixTime']);
                            $minutesAgo = $lastUpdate->diffInMinutes(now());
                            $device['status'] = $minutesAgo < 10 ? 'online' : 'offline';
                        } else {
                            $device['status'] = 'offline';
                        }
                    }
                }
                
                // OPTIMIZACIÓN: Geocodificar de forma limitada para evitar timeout
                \Log::info('MapPage: Enabling limited geocoding to prevent timeout');
                $this->enrichPositionsWithAddressesLimited();
                
            } else {
                \Log::error('MapPage: Failed to authenticate with Traccar after retry');
                $this->devices = [];
                $this->positions = [];
            }
            
        } catch (\Exception $e) {
            \Log::error('MapPage: Exception loading data: ' . $e->getMessage());
            \Log::error('MapPage: Stack trace: ' . $e->getTraceAsString());
            
            $this->devices = [];
            $this->positions = [];
        }
    }

    public function refreshMap(): void
    {
        \Log::info('MapPage: Manual refresh triggered');
        
        $this->loadMapData();
        
        // Force Livewire to re-render the component
        $this->dispatch('map-refresh', [
            'devices' => $this->devices,
            'positions' => $this->positions,
            'timestamp' => time()
        ]);
        
        // Enriquecer con direcciones después del refresh (limitado)
        $this->enrichPositionsWithAddressesLimited();
        
        \Log::info('MapPage: Manual refresh completed');
    }

    /**
     * Método para polling automático cada 10 segundos
     * Este método se ejecuta automáticamente por wire:poll
     */
    public function autoRefresh(): void
    {
        \Log::info('MapPage: Auto-refresh triggered by wire:poll');
        
        try {
            // Cargar nuevos datos
            $this->loadMapData();
            
            // REMOVED: map-auto-refresh dispatch - was causing interference
            // El mapa se actualiza automáticamente con livewire:updated
            
            \Log::info('MapPage: Auto-refresh completed successfully');
            
        } catch (\Exception $e) {
            \Log::error('MapPage: Error during auto-refresh: ' . $e->getMessage());
        }
    }

    /**
     * Método para activar geocoding manualmente (sin bloquear la carga inicial)
     */
    public function enableGeocoding(): void
    {
        try {
            \Log::info('MapPage: Manual geocoding requested');
            
            // Disparar evento de inicio
            $this->js('window.dispatchEvent(new CustomEvent("geocoding-started"))');
            
            $this->enrichPositionsWithAddresses();
            
            // Disparar evento de completado
            $this->js('window.dispatchEvent(new CustomEvent("geocoding-completed"))');
            
            // Notificar al frontend que se actualizaron las direcciones
            $this->dispatch('map-refresh', [
                'devices' => $this->devices,
                'positions' => $this->positions,
                'timestamp' => time()
            ]);
            
            \Log::info('MapPage: Manual geocoding completed successfully');
            
        } catch (\Exception $e) {
            \Log::error('MapPage: Error during manual geocoding: ' . $e->getMessage());
            
            // Disparar evento de error
            $this->js('window.dispatchEvent(new CustomEvent("geocoding-error"))');
        }
    }
    
    /**
     * Enriquece las posiciones con direcciones geocodificadas (versión limitada para evitar timeout)
     */
    private function enrichPositionsWithAddressesLimited(): void
    {
        try {
            $geocodingService = app(GeocodingService::class);
            
            // Obtener coordenadas únicas para geocodificar
            $uniqueCoordinates = [];
            foreach ($this->positions as $position) {
                if (isset($position['latitude']) && isset($position['longitude'])) {
                    $key = number_format($position['latitude'], 4) . ',' . number_format($position['longitude'], 4);
                    if (!isset($uniqueCoordinates[$key])) {
                        $uniqueCoordinates[$key] = [
                            'latitude' => $position['latitude'],
                            'longitude' => $position['longitude']
                        ];
                    }
                }
            }
            
            \Log::info('MapPage: Limited geocoding for ' . count($uniqueCoordinates) . ' unique coordinates');
            
            // SOLO procesar el primer lote de 20 coordenadas para evitar timeout
            $firstBatch = array_slice(array_values($uniqueCoordinates), 0, 20);
            
            if (!empty($firstBatch)) {
                \Log::info("MapPage: Processing first batch of " . count($firstBatch) . " coordinates");
                
                // Obtener direcciones para el primer lote
                $addresses = $geocodingService->getMultipleAddresses($firstBatch);
                
                // Enriquecer posiciones con direcciones
                $enrichedCount = 0;
                foreach ($this->positions as &$position) {
                    if (isset($position['latitude']) && isset($position['longitude'])) {
                        $key = $position['latitude'] . ',' . $position['longitude'];
                        if (isset($addresses[$key])) {
                            $position['address'] = $addresses[$key];
                            $enrichedCount++;
                        }
                    }
                }
                
                \Log::info("MapPage: Limited geocoding completed, {$enrichedCount} positions enriched with addresses");
                
                // Si hay más coordenadas, programar geocodificación completa para después
                if (count($uniqueCoordinates) > 20) {
                    \Log::info("MapPage: " . (count($uniqueCoordinates) - 20) . " coordinates remaining for background processing");
                }
            }
            
        } catch (\Exception $e) {
            \Log::error('MapPage: Error during limited geocoding: ' . $e->getMessage());
        }
    }

    /**
     * Enriquece las posiciones con direcciones geocodificadas (versión completa)
     */
    private function enrichPositionsWithAddresses(): void
    {
        try {
            $geocodingService = app(GeocodingService::class);
            
            // Obtener coordenadas únicas para geocodificar
            $uniqueCoordinates = [];
            foreach ($this->positions as $position) {
                if (isset($position['latitude']) && isset($position['longitude'])) {
                    $key = number_format($position['latitude'], 4) . ',' . number_format($position['longitude'], 4);
                    if (!isset($uniqueCoordinates[$key])) {
                        $uniqueCoordinates[$key] = [
                            'latitude' => $position['latitude'],
                            'longitude' => $position['longitude']
                        ];
                    }
                }
            }
            
            \Log::info('MapPage: Geocoding ' . count($uniqueCoordinates) . ' unique coordinates');
            
            // Procesar coordenadas en lotes de 20 con pausas reducidas
            $allAddresses = [];
            $coordinateChunks = array_chunk(array_values($uniqueCoordinates), 20);
            $totalChunks = count($coordinateChunks);
            
            \Log::info("MapPage: Processing {$totalChunks} chunks of coordinates");
            
            foreach ($coordinateChunks as $chunkIndex => $chunk) {
                \Log::info("MapPage: Processing chunk " . ($chunkIndex + 1) . " of {$totalChunks} (" . count($chunk) . " coordinates)");
                
                // Obtener direcciones para este lote
                $chunkAddresses = $geocodingService->getMultipleAddresses($chunk);
                
                // Combinar con el resultado total
                $allAddresses = array_merge($allAddresses, $chunkAddresses);
                
                // Pausa reducida entre lotes (solo 500ms)
                if ($chunkIndex < $totalChunks - 1) {
                    \Log::info("MapPage: Pausing 500ms before next chunk...");
                    usleep(500000); // 500ms en microsegundos
                }
            }
            
            \Log::info('MapPage: Completed all chunks, total addresses obtained: ' . count($allAddresses));
            
            // Enriquecer posiciones con direcciones
            $enrichedCount = 0;
            foreach ($this->positions as &$position) {
                if (isset($position['latitude']) && isset($position['longitude'])) {
                    $key = $position['latitude'] . ',' . $position['longitude'];
                    if (isset($allAddresses[$key])) {
                        $position['address'] = $allAddresses[$key];
                        $enrichedCount++;
                    }
                }
            }
            
            \Log::info("MapPage: Geocoding completed, {$enrichedCount} positions enriched with addresses");
            
        } catch (\Exception $e) {
            \Log::error('MapPage: Error during geocoding: ' . $e->getMessage());
        }
    }

    public function showDeviceDetails(int $deviceId): void
    {
        \Log::info('showDeviceDetails called with deviceId: ' . $deviceId);
        
        // Encontrar el dispositivo seleccionado
        $this->selectedDevice = collect($this->devices)->firstWhere('id', $deviceId);
        $this->selectedPosition = collect($this->positions)->firstWhere('deviceId', $deviceId);
        
        \Log::info('Found device: ' . json_encode($this->selectedDevice));
        \Log::info('Found position: ' . json_encode($this->selectedPosition));
        
        if ($this->selectedDevice) {
            $this->mountAction('viewDeviceDetails');
        } else {
            \Log::warning('Device not found with id: ' . $deviceId);
        }
    }

    public function getActions(): array
    {
        return [
            $this->viewDeviceDetailsAction(),
            $this->geocodeAllAddressesAction(),
        ];
    }

    public function geocodeAllAddressesAction(): Action
    {
        return Action::make('geocodeAllAddresses')
            ->label('Geocodificar Todas las Direcciones')
            ->icon('heroicon-o-map-pin')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Geocodificar Todas las Direcciones')
            ->modalDescription('Este proceso puede tomar varios minutos para procesar todas las coordenadas. ¿Deseas continuar?')
            ->modalSubmitActionLabel('Sí, Geocodificar Todo')
            ->action(function () {
                try {
                    $this->enrichPositionsWithAddresses();
                    
                    // Refrescar el mapa con las nuevas direcciones
                    $this->dispatch('map-refresh', [
                        'devices' => $this->devices,
                        'positions' => $this->positions,
                        'timestamp' => time()
                    ]);
                    
                    Notification::make()
                        ->title('Geocodificación Completada')
                        ->body('Todas las direcciones han sido procesadas exitosamente.')
                        ->success()
                        ->send();
                        
                } catch (\Exception $e) {
                    \Log::error('Error during manual geocoding: ' . $e->getMessage());
                    
                    Notification::make()
                        ->title('Error en Geocodificación')
                        ->body('Ocurrió un error durante el proceso: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    public function viewDeviceDetailsAction(): Action
    {
        return Action::make('viewDeviceDetails')
            ->modalHeading('Informaciónnnn del Vehículo')
            ->modalDescription('Detalles del dispositivo y posición')
            ->modalWidth(MaxWidth::Medium)
            ->icon('heroicon-o-truck')
            ->modalIcon('heroicon-o-truck')
            ->slideOver()
            ->modalContent(fn () => view('filament.modals.device-details', [
                'device' => $this->selectedDevice,
                'position' => $this->selectedPosition,
            ]))
            ->modalFooterActions([
                Action::make('viewMoreDetails')
                    ->label('Ver Más Detalles')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn () => $this->selectedDevice ? route('filament.admin.resources.devices.edit', $this->selectedDevice['id']) : '#')
                    ->openUrlInNewTab(),
                Action::make('close')
                    ->label('Cerrar')
                    ->color('gray')
                    ->modalCancelAction(),
            ])
            ->closeModalByClickingAway(false);
    }
}
