<?php

namespace App\Http\Controllers;

use App\Services\TraccarService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TraccarAuthController extends Controller
{
    protected TraccarService $traccarService;

    public function __construct(TraccarService $traccarService)
    {
        $this->traccarService = $traccarService;
    }

    public function showLoginForm()
    {
        if ($this->traccarService->isAuthenticated()) {
            return redirect()->route('filament.admin.pages.map-page');
        }

        return view('traccar.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $success = $this->traccarService->login(
            $request->input('email'),
            $request->input('password')
        );

        if ($success) {
            return redirect()->route('filament.admin.pages.map-page')
                ->with('success', 'Successfully connected to Traccar!');
        }

        return back()
            ->withErrors(['email' => 'Invalid credentials or Traccar server unavailable.'])
            ->withInput($request->only('email'));
    }

    public function logout(): RedirectResponse
    {
        $this->traccarService->logout();

        return redirect()->route('traccar.login')
            ->with('success', 'Logged out successfully!');
    }
}