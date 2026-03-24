@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Proposer un nouveau trajet</h2>
        
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('conducteur.trajet.store') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Ville de départ *</label>
                    <select name="ville_depart" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                        <option value="">Sélectionnez</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ old('ville_depart') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                    @error('ville_depart')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Ville d'arrivée *</label>
                    <select name="ville_arrivee" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                        <option value="">Sélectionnez</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ old('ville_arrivee') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                    @error('ville_arrivee')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Date et heure de départ *</label>
                    <input type="datetime-local" name="date_depart" value="{{ old('date_depart') }}" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                    @error('date_depart')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Date et heure d'arrivée *</label>
                    <input type="datetime-local" name="date_arrivee" value="{{ old('date_arrivee') }}" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                    @error('date_arrivee')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Véhicule *</label>
                <select name="vehicule_id" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                    <option value="">Sélectionnez un véhicule</option>
                    @foreach($vehicules as $vehicule)
                        <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                            {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->capacite }} places)
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('conducteur.vehicules') }}" class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                    + Ajouter un véhicule
                </a>
                @error('vehicule_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Prix par place (DH) *</label>
                    <input type="number" step="0.01" name="prix" value="{{ old('prix') }}" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                    @error('prix')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Nombre de places *</label>
                    <input type="number" name="places_disponibles" value="{{ old('places_disponibles') }}" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                    @error('places_disponibles')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="bg-blue-50 p-3 md:p-4 rounded-lg">
                <h3 class="font-semibold mb-2 text-sm md:text-base">Informations importantes :</h3>
                <ul class="text-xs md:text-sm text-gray-600 space-y-1">
                    <li>• Assurez-vous d'avoir un véhicule enregistré</li>
                    <li>• Les horaires sont en heure locale</li>
                    <li>• Vous pourrez modifier ou annuler le trajet plus tard</li>
                </ul>
            </div>
            
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 pt-4">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm md:text-base">
                    Proposer le trajet
                </button>
                <a href="{{ route('conducteur.mes-trajets') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400 transition text-sm md:text-base">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="date_depart"]').addEventListener('change', function() {
    const dateDepart = new Date(this.value);
    if(dateDepart && !isNaN(dateDepart)) {
        const dateArrivee = new Date(dateDepart);
        dateArrivee.setHours(dateArrivee.getHours() + 2);
        document.querySelector('input[name="date_arrivee"]').value = dateArrivee.toISOString().slice(0, 16);
    }
});
</script>
@endsection