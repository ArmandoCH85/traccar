@php
    $isMapPage = request()->is('admin/map-page') || request()->is('admin/map');
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @if (filament()->hasTopNavigation() || (! filament()->hasNavigation()))
        <div class="fi-layout flex min-h-screen w-full overflow-x-clip">
            <div class="fi-main-ctn flex w-full flex-col">
                @if (filament()->hasTopNavigation())
                    <x-filament-panels::topbar :navigation="$navigation" />
                @endif

                <main class="fi-main mx-auto h-full w-full px-4 md:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <x-filament-panels::footer />
            </div>
        </div>
    @else
        <div class="fi-layout flex min-h-screen w-full overflow-x-clip">
            @unless($isMapPage)
                <!-- Botón de toggle del sidebar (solo visible cuando no es la página del mapa) -->
                <button
                    id="sidebar-toggle"
                    type="button"
                    class="fixed top-4 left-4 z-50 flex h-10 w-10 items-center justify-center rounded-lg bg-white shadow-lg border border-gray-200 hover:bg-gray-50 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                    title="Ocultar/Mostrar Sidebar"
                >
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            @endunless

            <aside class="fi-sidebar-nav fi-sidebar flex h-screen w-[--sidebar-width] flex-col overflow-hidden bg-white shadow-xl ring-1 ring-gray-950/5 transition-all duration-300 dark:bg-gray-900 dark:ring-white/10 lg:z-0">
                <x-filament-panels::sidebar.header />

                <nav class="fi-sidebar-nav flex flex-1 flex-col gap-y-7 overflow-y-auto px-6 py-8">
                    <x-filament-panels::sidebar.group
                        :collapsible="false"
                        :icon="null"
                        :items="$navigation"
                        :label="null"
                        :sidebar-collapsible="filament()->isSidebarCollapsibleOnDesktop()"
                    />
                </nav>

                <x-filament-panels::sidebar.footer />
            </aside>

            <div class="fi-main-ctn flex w-full flex-col transition-all duration-300">
                <main class="fi-main mx-auto h-full w-full px-4 md:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <x-filament-panels::footer />
            </div>
        </div>
    @endif

    @unless($isMapPage)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButton = document.getElementById('sidebar-toggle');
                const sidebar = document.querySelector('.fi-sidebar');
                const mainContent = document.querySelector('.fi-main-ctn');
                
                if (toggleButton && sidebar && mainContent) {
                    // Estado inicial del sidebar (visible por defecto)
                    let sidebarVisible = localStorage.getItem('sidebar-visible') !== 'false';
                    
                    // Aplicar estado inicial
                    if (!sidebarVisible) {
                        sidebar.style.marginLeft = '-100%';
                        mainContent.style.marginLeft = '0';
                        toggleButton.style.left = '1rem';
                    }
                    
                    toggleButton.addEventListener('click', function() {
                        sidebarVisible = !sidebarVisible;
                        
                        if (sidebarVisible) {
                            // Mostrar sidebar
                            sidebar.style.marginLeft = '0';
                            mainContent.style.marginLeft = 'var(--sidebar-width)';
                            toggleButton.style.left = 'calc(var(--sidebar-width) + 1rem)';
                        } else {
                            // Ocultar sidebar
                            sidebar.style.marginLeft = '-100%';
                            mainContent.style.marginLeft = '0';
                            toggleButton.style.left = '1rem';
                        }
                        
                        // Guardar estado en localStorage
                        localStorage.setItem('sidebar-visible', sidebarVisible);
                    });
                    
                    // Actualizar posición del botón según el estado del sidebar
                    if (sidebarVisible) {
                        toggleButton.style.left = 'calc(var(--sidebar-width) + 1rem)';
                    }
                }
            });
        </script>
    @endunless

    <style>
        :root {
            --sidebar-width: 20rem;
        }
        
        .fi-sidebar {
            width: var(--sidebar-width);
        }
        
        #sidebar-toggle {
            transition: left 0.3s ease;
        }
    </style>
</x-filament-panels::layout.base>