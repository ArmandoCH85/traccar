<?php

namespace App\Http\Controllers;

use App\Services\TraccarService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MapDataController extends Controller
{
    /**
     * Obtener datos del mapa sin re-renderizar componente Livewire
     */
    public function getMapData(): JsonResponse
    {
        try {
            $traccarService = app(TraccarService::class);
            
            // Intentar autenticarse automáticamente si no está autenticado
            if (!$traccarService->isAuthenticated()) {
                \Log::info('MapDataController: Attempting to authenticate with Traccar...');
                $authResult = $traccarService->login('administrador@lubarsa.com', 'administrador');
                \Log::info('MapDataController: Authentication result: ' . ($authResult ? 'SUCCESS' : 'FAILED'));
            }
            
            if (!$traccarService->isAuthenticated()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to authenticate with Traccar',
                    'devices' => [],
                    'positions' => []
                ], 401);
            }
            
            // Obtener datos
            $devices = $traccarService->getDevices();
            $positions = $traccarService->getLastPositions();
            
            // Ensure we have arrays
            $devices = is_array($devices) ? $devices : [];
            $positions = is_array($positions) ? $positions : [];
            
            // Add status information to devices
            foreach ($devices as &$device) {
                if (!isset($device['status'])) {
                    // Find corresponding position to determine status
                    $position = collect($positions)->firstWhere('deviceId', $device['id']);
                    if ($position && isset($position['fixTime'])) {
                        $lastUpdate = \Carbon\Carbon::parse($position['fixTime']);
                        $minutesAgo = $lastUpdate->diffInMinutes(now());
                        $device['status'] = $minutesAgo < 10 ? 'online' : 'offline';
                    } else {
                        $device['status'] = 'offline';
                    }
                }
            }
            
            \Log::info('MapDataController: Successfully loaded ' . count($devices) . ' devices and ' . count($positions) . ' positions');
            
            return response()->json([
                'success' => true,
                'devices' => $devices,
                'positions' => $positions,
                'timestamp' => time()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('MapDataController: Exception loading data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'devices' => [],
                'positions' => []
            ], 500);
        }
    }
}