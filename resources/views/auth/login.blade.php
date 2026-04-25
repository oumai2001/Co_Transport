@extends('layouts.app')

@section('content')

<!-- Background global  -->
<div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/image.png') }}"
         class="w-full h-full object-cover" />

    <div class="absolute inset-0"></div>
</div>

<!-- Content -->
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6">

    <div class="w-full max-w-md">

        <!-- Form -->
        <div class="bg-black rounded-2xl p-6 sm:p-8 border border-white/30 ">
            
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-6 text-white">
                Connexion
            </h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-white mb-2 font-bold text-sm sm:text-base">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('email')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-white mb-2 font-bold text-sm sm:text-base">
                        Mot de passe
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('password')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 sm:py-2 rounded-lg transition font-bold text-sm sm:text-base">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-white mt-6 font-bold text-sm sm:text-base">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-blue-300 hover:underline font-bold">
                    Inscrivez-vous
                </a>
            </p>

        </div>
    </div>

</div>

@endsection