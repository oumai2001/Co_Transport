<div class="md:col-span-1">
    <!-- Version desktop : identique à l'original avec icônes -->
    <div class="bg-white rounded-lg shadow-md p-4 fixed top-16 left-0 w-1/4 h-[calc(100%-64px)] hidden md:block overflow-y-auto">
        <div class="text-center border-b pb-4 mb-4">
            <h3 class="font-bold text-gray-700 mb-3 pb-2 border-b">Menu</h3>
        </div>

        <ul class="space-y-2">
            <li>
                <a href="/admin/dashboard" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="/admin/passagers" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/passagers') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Passagers</span>
                </a>
            </li>
            <li>
                <a href="/admin/conducteurs" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/conducteurs') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Conducteurs</span>
                </a>
            </li>
            <li>
                <a href="/admin/trajets" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/trajets') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Trajets</span>
                </a>
            </li>
            <li>
                <a href="/admin/vehicules" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/vehicules') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <span>Véhicules</span>
                </a>
            </li>
            <li>
                <a href="/admin/reservations" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/reservations') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Réservations</span>
                </a>
            </li>
            <li>
                <a href="/admin/statistiques" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 hover:bg-gray-100 {{ request()->is('admin/statistiques') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistiques</span>
                </a>
            </li>
            <li class="pt-4 mt-2 border-t">
                <a href="/logout" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Version mobile : menu hamburger avec les MÊMES icônes -->
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
                    <a href="/admin/dashboard" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/passagers" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/passagers') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Passagers</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/conducteurs" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/conducteurs') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <span>Conducteurs</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/trajets" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/trajets') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <span>Trajets</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/vehicules" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/vehicules') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span>Véhicules</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/reservations" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/reservations') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Réservations</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/statistiques" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 {{ request()->is('admin/statistiques') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Statistiques</span>
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