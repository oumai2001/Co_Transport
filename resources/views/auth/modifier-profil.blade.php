@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">

        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Modifier mon profil</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Nom complet</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom ?? $utilisateur->nom ?? '') }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? $utilisateur->email ?? '') }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone ?? $utilisateur->telephone ?? '') }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>

            @if(isset($user->role) && $user->role == 'conducteur')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Numéro de permis</label>
                <input type="text" name="numero_permis" value="{{ old('numero_permis', $user->numero_permis ?? '') }}"
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Nouveau mot de passe</label>
                <input type="password" name="password"
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver l'ancien</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Mot de passe actuel</label>
                <input type="password" name="current_password" required
                       class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                <p class="text-xs text-gray-500 mt-1">Requis pour modifier le mot de passe</p>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm md:text-base">
                Mettre à jour
            </button>

        </form>

        <hr class="my-6">
    </div>
</div>

<script>
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if(e.target === this) this.classList.add('hidden');
});
</script>
@endsection