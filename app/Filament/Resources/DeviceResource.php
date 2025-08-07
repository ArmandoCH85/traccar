<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use App\Services\TraccarService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationGroup = 'Tracking';

    protected static ?string $navigationLabel = 'Devices';

    protected static ?string $modelLabel = 'Device';

    protected static ?string $pluralModelLabel = 'Devices';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unique_id')
                    ->label('Unique ID')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact')
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->options([
                        'default' => 'Default',
                        'animal' => 'Animal',
                        'bicycle' => 'Bicycle',
                        'boat' => 'Boat',
                        'bus' => 'Bus',
                        'car' => 'Car',
                        'crane' => 'Crane',
                        'helicopter' => 'Helicopter',
                        'motorcycle' => 'Motorcycle',
                        'offroad' => 'Offroad',
                        'person' => 'Person',
                        'pickup' => 'Pickup',
                        'plane' => 'Plane',
                        'ship' => 'Ship',
                        'tractor' => 'Tractor',
                        'train' => 'Train',
                        'tram' => 'Tram',
                        'trolleybus' => 'Trolleybus',
                        'truck' => 'Truck',
                        'van' => 'Van',
                    ])
                    ->default('default'),
                Forms\Components\Toggle::make('disabled')
                    ->label('Disabled'),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Expires At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unique_id')
                    ->label('Unique ID')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'online',
                        'warning' => 'offline',
                        'danger' => 'unknown',
                    ]),
                Tables\Columns\TextColumn::make('category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_update')
                    ->label('Last Update')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('disabled')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                        'unknown' => 'Unknown',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'default' => 'Default',
                        'car' => 'Car',
                        'truck' => 'Truck',
                        'motorcycle' => 'Motorcycle',
                        'person' => 'Person',
                    ]),
                Tables\Filters\TernaryFilter::make('disabled')
                    ->label('Disabled'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('sync')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function () {
                        static::syncDevicesFromTraccar();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Sync Devices')
                    ->modalDescription('This will sync all devices from Traccar API. Continue?'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('sync_all')
                    ->label('Sync from Traccar')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function () {
                        static::syncDevicesFromTraccar();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Sync All Devices')
                    ->modalDescription('This will sync all devices from Traccar API. Continue?'),
            ]);
    }

    protected static function syncDevicesFromTraccar(): void
    {
        $traccarService = app(TraccarService::class);
        
        if (!$traccarService->isAuthenticated()) {
            $traccarService->login('administrador@lubarsa.com', 'administrador');
        }

        $devices = $traccarService->getDevices();
        
        foreach ($devices as $deviceData) {
            Device::updateOrCreate(
                ['traccar_id' => $deviceData['id']],
                [
                    'name' => $deviceData['name'],
                    'unique_id' => $deviceData['uniqueId'],
                    'status' => $deviceData['status'] ?? 'unknown',
                    'last_update' => isset($deviceData['lastUpdate']) ? new \DateTime($deviceData['lastUpdate']) : null,
                    'position_id' => $deviceData['positionId'] ?? null,
                    'group_id' => $deviceData['groupId'] ?? null,
                    'phone' => $deviceData['phone'] ?? null,
                    'model' => $deviceData['model'] ?? null,
                    'contact' => $deviceData['contact'] ?? null,
                    'category' => $deviceData['category'] ?? 'default',
                    'disabled' => $deviceData['disabled'] ?? false,
                    'expires_at' => isset($deviceData['expirationTime']) ? new \DateTime($deviceData['expirationTime']) : null,
                    'attributes' => $deviceData['attributes'] ?? [],
                ]
            );
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
