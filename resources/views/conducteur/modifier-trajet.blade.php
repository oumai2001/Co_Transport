@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Modifier le trajet</h2>
        
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('conducteur.trajet.update', $trajet->id) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Départ</label>
                    <select name="ville_depart" required class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ $trajet->ville_depart_id == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Arrivée</label>
                    <select name="ville_arrivee" required class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ $trajet->ville_arrivee_id == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Date départ</label>
                    <input type="datetime-local" name="date_depart" value="{{ date('Y-m-d\TH:i', strtotime($trajet->date_depart)) }}" required 
                           class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Date arrivée</label>
                    <input type="datetime-local" name="date_arrivee" value="{{ date('Y-m-d\TH:i', strtotime($trajet->date_arrivee)) }}" required 
                           class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Prix (DH)</label>
                    <input type="number" step="0.01" name="prix" value="{{ $trajet->prix }}" required 
                           class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm md:text-base">Places</label>
                    <input type="number" name="places_disponibles" value="{{ $trajet->places_disponibles }}" required 
                           class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm md:text-base">
                    Enregistrer
                </button>
                <a href="{{ route('conducteur.mes-trajets') }}" class="flex-1 bg-gray-300 text-center py-2 rounded-lg hover:bg-gray-400 transition text-sm md:text-base">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection