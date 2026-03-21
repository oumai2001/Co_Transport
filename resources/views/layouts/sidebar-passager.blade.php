<div class="md:col-span-1">
    <!-- Version desktop -->
    <div class="bg-white rounded-lg shadow-md p-4 fixed top-16 left-0 w-1/4 h-[calc(100%-64px)] hidden md:block overflow-y-auto">

        <div class="text-center border-b pb-4 mb-4">
            <h3 class="font-bold text-gray-700 mb-3 pb-2 border-b"> Menu</h3>
        </div>

        <ul class="space-y-1 text-sm">

            <li>
                <a href="/passager/dashboard"
                   class="flex items-center gap-3 p-3 rounded-lg transition
                   {{ request()->is('passager/dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <li>
                <a href="/trajets"
                   class="flex items-center gap-3 p-3 rounded-lg transition
                   {{ request()->is('trajets*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Rechercher un trajet</span>
                </a>
            </li>

            <li>
                <a href="/passager/historique"
                   class="flex items-center gap-3 p-3 rounded-lg transition
                   {{ request()->is('passager/historique') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Historique</span>
                </a>
            </li>

            <li>
                <a href="/passager/favoris"
                   class="flex items-center gap-3 p-3 rounded-lg transition
                   {{ request()->is('passager/favoris') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>Favoris</span>
                </a>
            </li>


            <li>
                <a href="/profil/modifier"
                   class="flex items-center gap-3 p-3 rounded-lg transition
                   {{ request()->is('profil/modifier') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profil</span>
                </a>
            </li>

            <li class="pt-3 border-t mt-3">
                <a href="/logout"
                   class="flex items-center gap-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition">
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
            <ul class="space-y-1 p-3 text-sm">
                <li>
                    <a href="/passager/dashboard"
                       class="flex items-center gap-3 p-2 rounded-lg transition
                       {{ request()->is('passager/dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="/trajets"
                       class="flex items-center gap-3 p-2 rounded-lg transition
                       {{ request()->is('trajets*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Rechercher un trajet</span>
                    </a>
                </li>
                <li>
                    <a href="/passager/historique"
                       class="flex items-center gap-3 p-2 rounded-lg transition
                       {{ request()->is('passager/historique') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Historique</span>
                    </a>
                </li>
                <li>
                    <a href="/passager/favoris"
                       class="flex items-center gap-3 p-2 rounded-lg transition
                       {{ request()->is('passager/favoris') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span>Favoris</span>
                    </a>
                </li>
                <li>
                    <a href="/profil/modifier"
                       class="flex items-center gap-3 p-2 rounded-lg transition
                       {{ request()->is('profil/modifier') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="border-t pt-2 mt-2">
                    <a href="/logout"
                       class="flex items-center gap-3 p-2 rounded-lg text-red-600 hover:bg-red-50">
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