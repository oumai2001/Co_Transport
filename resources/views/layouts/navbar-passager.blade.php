<!-- Navbar pour Passager -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14 sm:h-16">

            <!-- Logo -->
            <a href="/passager/dashboard" class="flex items-center space-x-2">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                    </path>
                </svg>

                <span class="text-lg sm:text-xl font-bold text-gray-800">
                    Co<span class="text-blue-600">Transport</span>
                </span>
            </a>

            <!-- USER -->
            <div class="flex items-center space-x-2 sm:space-x-4">

                <!-- Avatar -->
                <div class="relative">
                    <button id="userMenuBtn" class="flex items-center space-x-2 sm:space-x-3 p-1.5 sm:p-2 rounded-lg hover:bg-gray-100">

                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                            {{ strtoupper(substr(session('user_nom'), 0, 2)) }}
                        </div>

                        <div class="hidden md:block text-left">
                            <div class="text-sm font-medium text-gray-800">
                                {{ session('user_nom') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                 Passager
                            </div>
                        </div>

                    </button>

                    <!-- Dropdown -->
                    <div id="userDropdown" class="absolute right-0 mt-2 w-48 sm:w-56 bg-white rounded-lg shadow-xl hidden z-50">

                        <div class="p-3 border-b bg-gray-50 rounded-t-lg">
                            <div class="font-medium text-gray-800 text-sm">
                                {{ session('user_nom') }}
                            </div>
                            <div class="text-xs text-gray-500 break-words">
                                {{ session('user_email') }}
                            </div>
                        </div>

                        <div class="py-2 text-sm sm:text-base">
                            <a href="/profil/modifier" class="block px-4 py-2 hover:bg-gray-100">
                                 Mon profil
                            </a>
                            <hr class="my-1">

                            <a href="/logout" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                 Déconnexion
                            </a>
                        </div>
     
                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</nav>