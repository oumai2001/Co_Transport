<div class="md:col-span-1">
    <!-- Version desktop -->
    <div class="bg-white rounded-lg shadow-md p-4 fixed top-16 left-0 w-1/4 h-[calc(100%-64px)] hidden md:block overflow-y-auto">

        <div class="text-center border-b pb-4 mb-4">
            <h3 class="font-bold text-gray-700 mb-3 pb-2 border-b"> Menu</h3>
        </div>

        <ul class="space-y-2">

            <!-- Dashboard -->
            <li>
                <a href="/conducteur/dashboard"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <!-- Créer trajet -->
            <li>
                <a href="/conducteur/creer-trajet"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/creer-trajet') ? 'bg-blue-50 text-blue-700 font-semibold' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Proposer un trajet</span>
                </a>
            </li>

            <!-- Mes trajets -->
            <li>
                <a href="/conducteur/mes-trajets"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/mes-trajets') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Mes trajets</span>
                </a>
            </li>

            <!-- Véhicules -->
            <li>
                <a href="/conducteur/vehicules"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/vehicules') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <span>Mes véhicules</span>
                </a>
            </li>

            <!-- Statistiques -->
            <li>
                <a href="/conducteur/statistiques"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/statistiques') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistiques</span>
                </a>
            </li>

            <!-- Avis -->
            <li>
                <a href="/conducteur/mes-avis"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('conducteur/mes-avis') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span>Mes avis</span>
                </a>
            </li>

            <!-- Profil -->
            <li>
                <a href="/profil/modifier"
                   class="flex items-center space-x-3 p-3 rounded-lg transition
                   {{ request()->is('profil/modifier') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Modifier profil</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="pt-4 mt-2 border-t">
                <a href="/logout"
                   class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Déconnexion</span>
                </a>
            </li>

        </ul>
    </div>

    <!-- Version mobile (menu hamburger) -->
    <div class="md:hidden fixed top-16 left-0 w-full bg-white shadow-md z-40">
        <div class="flex justify-between items-center p-3 border-b">
            <h3 class="font-bold text-gray-700"> Menu</h3>
            <button id="menuToggle" class="text-gray-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden bg-white border-b shadow-lg">
            <ul class="space-y-1 p-3">
                <li>
                    <a href="/conducteur/dashboard" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('conducteur/dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="/conducteur/creer-trajet" class="flex items-center space-x-3 p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Proposer un trajet</span>
                    </a>
                </li>
                <li>
                    <a href="/conducteur/mes-trajets" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('conducteur/mes-trajets') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span>Mes trajets</span>
                    </a>
                </li>
                <li>
                    <a href="/conducteur/vehicules" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('conducteur/vehicules') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span>Mes véhicules</span>
                    </a>
                </li>
                <li>
                    <a href="/conducteur/statistiques" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('conducteur/statistiques') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Statistiques</span>
                    </a>
                </li>
                <li>
                    <a href="/conducteur/mes-avis" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('conducteur/mes-avis') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <span>Mes avis</span>
                    </a>
                </li>
                <li>
                    <a href="/profil/modifier" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 {{ request()->is('profil/modifier') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Modifier profil</span>
                    </a>
                </li>
                <li class="border-t pt-2 mt-2">
                    <a href="/logout" class="flex items-center space-x-3 p-2 rounded-lg text-red-600 hover:bg-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    if(menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>