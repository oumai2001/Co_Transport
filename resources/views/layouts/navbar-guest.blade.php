<!-- Navbar pour visiteurs -->
<nav class="bg-white shadow-lg sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-14 sm:h-16">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>

                <span class="text-lg sm:text-xl font-bold text-gray-800">
                    Co<span class="text-blue-600">Transport</span>
                </span>
            </a>

            <!-- RIGHT -->
            <div class="flex items-center space-x-2 sm:space-x-6">

                <!-- MENU (desktop) -->
                <div class="hidden md:flex items-center space-x-6">

                    <a href="{{ url('/') }}"
                       class="font-medium transition text-sm sm:text-base
                       {{ request()->is('/') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Accueil
                    </a>

                    <a href="{{ url('/trajets') }}"
                       class="font-medium transition text-sm sm:text-base
                       {{ request()->is('trajets*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Rechercher un trajet
                    </a>

                </div>

                <!-- AUTH -->
                <div class="hidden sm:flex items-center space-x-3">

                    <a href="{{ url('/login') }}"
                       class="px-3 sm:px-4 py-2 font-medium transition text-sm sm:text-base
                       {{ request()->is('login') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Connexion
                    </a>

                    <a href="{{ url('/register') }}"
                       class="px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm sm:text-base">
                        Inscription
                    </a>

                </div>

                <!-- MOBILE BUTTON -->
                <button id="menuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>

        </div>

    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="md:hidden hidden px-4 pb-4 bg-white border-t">

        <a href="{{ url('/') }}"
           class="block py-2 font-medium
           {{ request()->is('/') ? 'text-blue-600' : 'text-gray-700' }}">
            Accueil
        </a>

        <a href="{{ url('/trajets') }}"
           class="block py-2 font-medium
           {{ request()->is('trajets*') ? 'text-blue-600' : 'text-gray-700' }}">
            Rechercher un trajet
        </a>

        <div class="mt-3 border-t pt-3 space-y-2">

            <a href="{{ url('/login') }}"
               class="block py-2 font-medium
               {{ request()->is('login') ? 'text-blue-600' : 'text-gray-700' }}">
                Connexion
            </a>

            <a href="{{ url('/register') }}"
               class="block py-2 bg-blue-600 text-white rounded-lg text-center font-medium">
                Inscription
            </a>

        </div>

    </div>

</nav>

<!-- SCRIPT -->
<script>
document.getElementById('menuBtn').addEventListener('click', function () {
    document.getElementById('mobileMenu').classList.toggle('hidden');
});
</script>