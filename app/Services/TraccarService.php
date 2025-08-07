<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TraccarService
{
    private string $baseUrl;
    private array $cookies = [];

    public function __construct()
    {
        $this->baseUrl = config('services.traccar.api_url', env('TRACCAR_API_URL', 'http://localhost:8082/api'));
    }

    public function login(string $email, string $password): bool
    {
        try {
            $response = Http::asForm()->post($this->baseUrl . '/session', [
                'email' => $email,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $user = $response->json();
                $this->storeCookies($response);
                
                Session::put('traccar_user', $user);
                Session::put('traccar_cookies', $this->cookies);
                
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function logout(): bool
    {
        try {
            $this->loadCookies();
            
            $response = Http::withCookies($this->cookies, parse_url($this->baseUrl, PHP_URL_HOST))
                ->delete($this->baseUrl . '/session');

            Session::forget(['traccar_user', 'traccar_cookies']);
            $this->cookies = [];

            return $response->status() === 204;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getDevices(?int $userId = null, bool $all = false): array
    {
        try {
            $this->loadCookies();
            
            $params = [];
            if ($userId) {
                $params['userId'] = $userId;
            }
            if ($all) {
                $params['all'] = 'true';
            }

            $response = Http::withCookies($this->cookies, parse_url($this->baseUrl, PHP_URL_HOST))
                ->get($this->baseUrl . '/devices', $params);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getPositions(?int $deviceId = null, ?string $from = null, ?string $to = null): array
    {
        try {
            $this->loadCookies();
            
            $params = [];
            if ($deviceId) {
                $params['deviceId'] = $deviceId;
            }
            if ($from) {
                $params['from'] = $from;
            }
            if ($to) {
                $params['to'] = $to;
            }

            $response = Http::withCookies($this->cookies, parse_url($this->baseUrl, PHP_URL_HOST))
                ->get($this->baseUrl . '/positions', $params);

            if ($response->successful()) {
                $positions = $response->json();
                
                // DEBUG: Log raw response from Traccar
                \Log::info('TraccarService: Raw positions response from API: ' . json_encode(array_slice($positions, 0, 2))); // Solo primeras 2 para no saturar logs
                
                return $positions;
            }

            \Log::error('TraccarService: Failed to get positions. Status: ' . $response->status() . ', Body: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            \Log::error('TraccarService: Exception getting positions: ' . $e->getMessage());
            return [];
        }
    }

    public function getServer(): array
    {
        try {
            $response = Http::get($this->baseUrl . '/server');

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getUser(): ?array
    {
        return Session::get('traccar_user');
    }
    
    /**
     * Get last known positions for all devices
     * This endpoint typically returns the most recent position for each device with complete data
     */
    public function getLastPositions(): array
    {
        try {
            $this->loadCookies();
            
            $response = Http::withCookies($this->cookies, parse_url($this->baseUrl, PHP_URL_HOST))
                ->get($this->baseUrl . '/positions', [
                    'all' => 'true' // Get all devices' last positions
                ]);

            if ($response->successful()) {
                $positions = $response->json();
                
                // DEBUG: Log to see what we get
                \Log::info('TraccarService: Last positions response count: ' . count($positions));
                if (count($positions) > 0) {
                    \Log::info('TraccarService: Sample last position: ' . json_encode($positions[0]));
                }
                
                return $positions;
            }

            \Log::error('TraccarService: Failed to get last positions. Status: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            \Log::error('TraccarService: Exception getting last positions: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Alternative method to get positions - try different Traccar endpoints
     */
    public function getLatestPositions(): array
    {
        try {
            $this->loadCookies();
            
            // Try the reports/route endpoint which sometimes has more complete data
            $response = Http::withCookies($this->cookies, parse_url($this->baseUrl, PHP_URL_HOST))
                ->get($this->baseUrl . '/positions');

            if ($response->successful()) {
                $positions = $response->json();
                \Log::info('TraccarService: Latest positions method returned: ' . count($positions) . ' positions');
                return $positions;
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('TraccarService: Exception in getLatestPositions: ' . $e->getMessage());
            return [];
        }
    }

    public function isAuthenticated(): bool
    {
        return Session::has('traccar_user') && Session::has('traccar_cookies');
    }

    private function storeCookies(Response $response): void
    {
        $cookies = [];
        $setCookieHeaders = $response->header('Set-Cookie');
        
        if (is_array($setCookieHeaders)) {
            foreach ($setCookieHeaders as $cookieHeader) {
                $cookie = explode(';', $cookieHeader)[0];
                $parts = explode('=', $cookie, 2);
                if (count($parts) === 2) {
                    $cookies[$parts[0]] = $parts[1];
                }
            }
        } elseif ($setCookieHeaders) {
            $cookie = explode(';', $setCookieHeaders)[0];
            $parts = explode('=', $cookie, 2);
            if (count($parts) === 2) {
                $cookies[$parts[0]] = $parts[1];
            }
        }
        
        $this->cookies = $cookies;
    }

    private function loadCookies(): void
    {
        $this->cookies = Session::get('traccar_cookies', []);
    }
}