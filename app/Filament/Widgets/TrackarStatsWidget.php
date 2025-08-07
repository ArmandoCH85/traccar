<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\User;
use App\Services\TraccarService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrackarStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $traccarService = app(TraccarService::class);
        
        // Get basic counts
        $totalUsers = User::count();
        $totalDevices = Device::count();
        
        // Get Traccar data if authenticated
        $traccarDevices = [];
        $onlineDevices = 0;
        
        if ($traccarService->isAuthenticated()) {
            $traccarDevices = $traccarService->getDevices();
            $onlineDevices = collect($traccarDevices)
                ->where('status', 'online')
                ->count();
        }

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Devices', count($traccarDevices) ?: $totalDevices)
                ->description('GPS devices')
                ->descriptionIcon('heroicon-m-device-phone-mobile')
                ->color('info'),

            Stat::make('Online Devices', $onlineDevices)
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-signal')
                ->color($onlineDevices > 0 ? 'success' : 'danger'),

            Stat::make('Traccar Status', $traccarService->isAuthenticated() ? 'Connected' : 'Disconnected')
                ->description($traccarService->isAuthenticated() ? 'API connected' : 'Login required')
                ->descriptionIcon('heroicon-m-wifi')
                ->color($traccarService->isAuthenticated() ? 'success' : 'warning'),
        ];
    }
}