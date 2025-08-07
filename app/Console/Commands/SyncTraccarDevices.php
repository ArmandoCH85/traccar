<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Services\TraccarService;
use Illuminate\Console\Command;

class SyncTraccarDevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traccar:sync-devices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar dispositivos desde Traccar Server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sincronización de dispositivos desde Traccar...');

        $traccarService = app(TraccarService::class);
        
        // Autenticarse si no está autenticado
        if (!$traccarService->isAuthenticated()) {
            $this->info('Autenticándose con Traccar...');
            $success = $traccarService->login('administrador@lubarsa.com', 'administrador');
            
            if (!$success) {
                $this->error('Error al autenticarse con Traccar');
                return 1;
            }
        }

        // Obtener dispositivos de Traccar
        $traccarDevices = $traccarService->getDevices();
        
        if (empty($traccarDevices)) {
            $this->warn('No se encontraron dispositivos en Traccar');
            return 0;
        }

        $this->info('Encontrados ' . count($traccarDevices) . ' dispositivos en Traccar');

        $synced = 0;
        $updated = 0;

        foreach ($traccarDevices as $traccarDevice) {
            // Buscar si el dispositivo ya existe en la base de datos local
            $device = Device::where('traccar_id', $traccarDevice['id'])->first();

            if ($device) {
                // Actualizar dispositivo existente
                $device->update([
                    'name' => $traccarDevice['name'],
                    'unique_id' => $traccarDevice['uniqueId'],
                    'status' => $traccarDevice['status'] ?? 'unknown',
                    'last_update' => $traccarDevice['lastUpdate'] ?? null,
                    'phone' => $traccarDevice['phone'] ?? null,
                    'model' => $traccarDevice['model'] ?? null,
                    'contact' => $traccarDevice['contact'] ?? null,
                    'category' => $traccarDevice['category'] ?? null,
                ]);
                $updated++;
            } else {
                // Crear nuevo dispositivo
                Device::create([
                    'traccar_id' => $traccarDevice['id'],
                    'name' => $traccarDevice['name'],
                    'unique_id' => $traccarDevice['uniqueId'],
                    'status' => $traccarDevice['status'] ?? 'unknown',
                    'last_update' => $traccarDevice['lastUpdate'] ?? null,
                    'phone' => $traccarDevice['phone'] ?? null,
                    'model' => $traccarDevice['model'] ?? null,
                    'contact' => $traccarDevice['contact'] ?? null,
                    'category' => $traccarDevice['category'] ?? null,
                ]);
                $synced++;
            }
        }

        $this->info("Sincronización completada:");
        $this->info("- Dispositivos nuevos: $synced");
        $this->info("- Dispositivos actualizados: $updated");
        $this->info("- Total en base de datos: " . Device::count());

        return 0;
    }
}
