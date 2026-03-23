<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CoTransport - Covoiturage</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 pb-20 sm:pb-16">


{{-- NAVBAR --}}
@if(session('user_id'))
    @if(session('user_role') == 'passager')
        @include('layouts.navbar-passager')
    @elseif(session('user_role') == 'conducteur')
        @include('layouts.navbar-conducteur')
    @elseif(session('user_role') == 'admin')
        @include('layouts.navbar-admin')
    @endif
@else
    @include('layouts.navbar-guest')
@endif


{{-- FLASH MESSAGES --}}
<div class="fixed top-16 sm:top-20 left-0 right-0 z-50 flex justify-center pointer-events-none">
    <div class="w-full max-w-md mx-4 pointer-events-auto">
        @if(session('success'))
            <div class="mb-3 p-3 sm:p-4 bg-green-500 text-white rounded-lg shadow-lg flash-message flex justify-between items-center text-sm sm:text-base">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-3 p-3 sm:p-4 bg-red-500 text-white rounded-lg shadow-lg flash-message flex justify-between items-center text-sm sm:text-base">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>

{{-- MAIN --}}
<main class="container mx-auto px-4 sm:px-6 py-4 mt-10 sm:mt-12">

@if(session('user_role') == 'conducteur')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">

        <div class="md:col-span-1">
            @include('layouts.sidebar-conducteur')
        </div>

        <div class="md:col-span-3">
            @yield('content')
        </div>

    </div>

@elseif(session('user_role') == 'passager')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">

        <div class="md:col-span-1">
            @include('layouts.sidebar-passager')
        </div>

        <div class="md:col-span-3">
            @yield('content')
        </div>

    </div>

@elseif(session('user_role') == 'admin')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">

        <div class="md:col-span-1">
            @include('layouts.sidebar-admin')
        </div>

        <div class="md:col-span-3">
            @yield('content')
        </div>

    </div>

@else

    @yield('content')

@endif

</main>


{{-- FOOTER --}}
<footer class="fixed bottom-0 left-0 w-full bg-white border-t py-2 sm:py-3 shadow-sm z-50">
    <div class="text-center text-gray-500 text-xs sm:text-sm">
        © {{ date('Y') }} CoTransport - Tous droits réservés
    </div>
</footer>


{{-- SCRIPTS --}}
<script>

// dropdown user
const userMenuBtn = document.getElementById('userMenuBtn');
const userDropdown = document.getElementById('userDropdown');

if (userMenuBtn && userDropdown) {
    userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
    });
}

document.addEventListener('click', () => {
    if (userDropdown) {
        userDropdown.classList.add('hidden');
    }
});


// notifications
function chargerNotifications() {
    fetch('/notifications/unread/count')
        .then(res => res.json())
        .then(data => {
            const notifCount = document.getElementById('notifCount');
            if (!notifCount) return;

            if (data.count > 0) {
                notifCount.textContent = data.count;
                notifCount.classList.remove('hidden');
            } else {
                notifCount.classList.add('hidden');
            }
        })
        .catch(() => console.log('Erreur notifications'));
}

if (document.getElementById('notifBtn')) {
    chargerNotifications();
    setInterval(chargerNotifications, 30000);
}


// flash messages auto hide
setTimeout(() => {
    document.querySelectorAll('.flash-message')
        .forEach(el => {
            setTimeout(() => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            }, 4000);
        });
}, 1000);

</script>

</body>
</html>