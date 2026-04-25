@extends('layouts.app')

@section('content')

<div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/image.png') }}"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0"></div>
</div>

<!-- Content -->
<div class="min-h-screen flex justify-center items-center px-4 sm:px-6">

    <div class="w-full max-w-md">

        <!-- Glass form -->
        <div class="bg-black border border-white rounded-2xl p-6 sm:p-8 shadow-2xl text-white">

            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-6">
                Inscription
            </h2>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/50 text-white rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Nom complet</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('nom')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('email')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('telephone')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Mot de passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('password')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation Password -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Je suis</label>
                    <select name="role" id="role"
                        class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/30 text-white
                               focus:outline-none focus:ring-2 focus:ring-blue-400 appearance-none text-sm sm:text-base">

                        <option value="passager" class="text-black" {{ old('role') == 'passager' ? 'selected' : '' }}>Passager</option>
                        <option value="conducteur" class="text-black" {{ old('role') == 'conducteur' ? 'selected' : '' }}>Conducteur</option>

                    </select>
                    @error('role')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permis (visible uniquement pour conducteur) -->
                <div id="permisField" class="mb-6 {{ old('role') == 'conducteur' ? '' : 'hidden' }}">
                    <label class="block mb-2 font-bold text-sm sm:text-base">Numéro de permis</label>
                    <input type="text" name="numero_permis" value="{{ old('numero_permis') }}"
                           class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                    @error('numero_permis')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 sm:py-2 rounded-lg transition font-bold text-sm sm:text-base">
                    S'inscrire
                </button>
            </form>

            <p class="text-center mt-6 text-white font-bold text-sm sm:text-base">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-blue-300 hover:underline font-bold">
                    Connectez-vous
                </a>
            </p>

        </div>
    </div>

</div>

<!-- Script -->
<script>
document.getElementById('role').addEventListener('change', function () {
    const permisField = document.getElementById('permisField');
    permisField.classList.toggle('hidden', this.value !== 'conducteur');
});

// Pour préserver la valeur après erreur de validation
document.addEventListener('DOMContentLoaded', function() {
    const role = document.getElementById('role').value;
    const permisField = document.getElementById('permisField');
    if (role === 'conducteur') {
        permisField.classList.remove('hidden');
    } else {
        permisField.classList.add('hidden');
    }
});
</script>

@endsection