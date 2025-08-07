# Trackar - Traccar Integration with Laravel & Filament

A GPS tracking application that integrates with Traccar server using Laravel and Filament v3 for device management and real-time location visualization.

## Features

- **Authentication**: Secure login integration with Traccar API
- **Device Management**: View, manage, and sync devices from Traccar server
- **Real-time Map**: Interactive map showing device locations using Leaflet
- **Admin Panel**: Modern admin interface built with Filament v3
- **Responsive Design**: Works on desktop and mobile devices

## Requirements

- PHP 8.1+
- Laravel 12.x
- Traccar Server (running on http://localhost:8082 by default)
- SQLite/MySQL database

## Installation

1. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

2. **Environment Configuration**
   The `.env` file is already configured with:
   ```env
   APP_NAME=Trackar
   TRACCAR_API_URL=http://localhost:8082/api
   TRACCAR_WEBSOCKET_URL=ws://localhost:8082/api/socket
   ```

3. **Database is ready**
   - SQLite database is already set up
   - Migrations have been run
   - Admin user created: admin@trackar.com / password

## Usage

### Starting the Application

1. **Start Laravel development server**
   ```bash
   php artisan serve
   ```

2. **Access the application**
   - Main App: http://localhost:8000 (redirects to admin)
   - Admin Panel: http://localhost:8000/admin
   - Traccar Login: http://localhost:8000/traccar/login

### Authentication Flow

1. **Admin Panel Login**
   - Email: admin@trackar.com
   - Password: password

2. **Traccar Integration**
   - Navigate to the Map page in admin panel
   - If not authenticated with Traccar, you'll be prompted to login
   - Use your Traccar server credentials

### Features Overview

#### Device Management (`/admin/devices`)
- View all devices from Traccar server
- Sync devices manually with "Sync from Traccar" button
- Filter by status, category, and other attributes
- Edit device information
- View device details and attributes

#### Map Visualization (`/admin/map-page`)
- Interactive map showing all device locations
- Real-time position updates with "Refresh" button
- Device status indicators (online/offline)
- Detailed popup information for each device
- Statistics dashboard showing device counts

## API Integration

### Traccar Service Features
- Session-based authentication with Traccar API
- Device listing and synchronization
- Position data retrieval
- Automatic cookie handling
- Error handling and fallbacks

### Routes
- `GET /traccar/login` - Show Traccar login form
- `POST /traccar/login` - Authenticate with Traccar
- `POST /traccar/logout` - Logout from Traccar
- `/admin/*` - Filament admin panel routes

## Technical Details

### Key Components

1. **TraccarService** (`app/Services/TraccarService.php`)
   - Handles all Traccar API communication
   - Methods: login(), logout(), getDevices(), getPositions()

2. **DeviceResource** (`app/Filament/Resources/DeviceResource.php`)
   - Filament resource for device management
   - Sync functionality from Traccar API
   - Comprehensive table views and forms

3. **MapPage** (`app/Filament/Pages/MapPage.php`)
   - Custom Filament page for map visualization
   - Leaflet.js integration for interactive maps
   - Real-time data loading and refresh

### Database Structure
- `devices` - Stores device information synced from Traccar
- `positions` - Stores position data for device tracking
- Standard Laravel tables (users, cache, jobs, etc.)

## Configuration

### Traccar Server Setup
Ensure your Traccar server is running and accessible:
- Default: http://localhost:8082
- API: http://localhost:8082/api
- WebSocket: ws://localhost:8082/api/socket

Update `.env` if your Traccar server runs on different host/port.

## Development

### Adding Features
To extend functionality:
1. Add new methods to `TraccarService` for additional API endpoints
2. Create new Filament resources/pages as needed
3. Extend Device/Position models with new relationships
4. Add new routes in `routes/web.php`

### Testing
```bash
php artisan serve
# Visit http://localhost:8000/admin
# Login with admin@trackar.com / password
# Navigate to Map page and test Traccar integration
```

## Troubleshooting

### Common Issues

1. **Traccar Connection Failed**
   - Verify Traccar server is running at configured URL
   - Check TRACCAR_API_URL in `.env`
   - Test with browser: visit http://localhost:8082

2. **Map Not Loading**
   - Check browser console for errors
   - Ensure Leaflet CSS/JS are loading from CDN
   - Verify device positions are available in Traccar

3. **Admin Panel Issues**
   - Clear cache: `php artisan config:clear`
   - Check storage permissions
   - Verify database connection

### Logs
```bash
tail -f storage/logs/laravel.log
```

## Project Structure

```
app/
├── Services/TraccarService.php          # Traccar API integration
├── Models/Device.php, Position.php      # Data models
├── Filament/
│   ├── Resources/DeviceResource.php     # Device management
│   └── Pages/MapPage.php                # Interactive map
└── Http/Controllers/TraccarAuthController.php

resources/views/
├── filament/pages/map-page.blade.php    # Map page template
└── traccar/login.blade.php              # Traccar login form
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
