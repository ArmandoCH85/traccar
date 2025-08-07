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
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
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