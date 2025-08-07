<?php

namespace App\Filament\Pages;

use App\Services\TraccarService;
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
        $traccarService = app(TraccarService::class);
        
        // Intentar autenticarse automáticamente si no está autenticado
        if (!$traccarService->isAuthenticated()) {
            $traccarService->login('administrador@lubarsa.com', 'administrador');
        }
        
        if ($traccarService->isAuthenticated()) {
            $this->devices = $traccarService->getDevices();
            $this->positions = $traccarService->getPositions();
            
            // Debug logging
            \Log::info('MapPage: Loaded ' . count($this->devices) . ' devices and ' . count($this->positions) . ' positions');
        } else {
            \Log::error('MapPage: Failed to authenticate with Traccar');
            $this->devices = [];
            $this->positions = [];
        }
    }

    public function refreshMap(): void
    {
        $this->loadMapData();
        $this->dispatch('map-refresh', [
            'devices' => $this->devices,
            'positions' => $this->positions,
        ]);
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
        ];
    }

    public function viewDeviceDetailsAction(): Action
    {
        return Action::make('viewDeviceDetails')
            ->modalHeading('Información del Vehículo')
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
            ->closeModalByClickingAway(true);
    }
}
