@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Rechercher un trajet</h2>
    
    <form method="GET" action="{{ route('trajets.filtrer') }}" class="mb-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Départ</label>
            <select name="ville_depart" class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                <option value="">Toutes</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ request('ville_depart') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Arrivée</label>
            <select name="ville_arrivee" class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
                <option value="">Toutes</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ request('ville_arrivee') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Date</label>
            <input type="date" name="date_depart" value="{{ request('date_depart') }}" class="w-full px-3 py-2 border rounded-lg text-sm md:text-base">
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm md:text-base">
                Filtrer
            </button>
        </div>
    </form>
    
    <div id="trajets-list" class="space-y-4">
        @forelse($trajets as $trajet)
            <div class="border rounded-lg p-3 md:p-4 hover:shadow-lg transition">
                <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                    <div class="flex-1 w-full">
                        <div class="flex items-center justify-between md:justify-start md:space-x-4 mb-2">
                            <span class="font-bold text-base md:text-lg">{{ $trajet->villeDepart->nom }}</span>
                            <span class="text-gray-400">→</span>
                            <span class="font-bold text-base md:text-lg">{{ $trajet->villeArrivee->nom }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs md:text-sm text-gray-600">
                            <div>{{ date('d/m/Y', strtotime($trajet->date_depart)) }}</div>
                            <div>{{ date('H:i', strtotime($trajet->date_depart)) }}</div>
                            <div>{{ $trajet->places_disponibles }} places</div>
                            <div>{{ $trajet->conducteur->utilisateur->nom }}</div>
                        </div>
                    </div>
                    <div class="text-left md:text-right w-full md:w-auto">
                        <div class="text-xl md:text-2xl font-bold text-blue-600">{{ number_format($trajet->prix, 2) }} DH</div>
                        <div class="flex flex-row md:flex-col gap-2 mt-2">
                            @if(session('user_role') == 'passager')
                                @if(isset($trajet->reservation_passager))
                                    <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-sm text-center">
                                        Réservé
                                    </span>
                                @else
                                    <a href="{{ route('reservation.choisir', $trajet->id) }}" 
                                       class="inline-block bg-green-600 text-white px-3 py-1 md:px-4 rounded-lg hover:bg-green-700 text-sm text-center">
                                        Réserver
                                    </a>
                                @endif
                            @endif
                            <a href="{{ route('trajet.show', $trajet->id) }}" class="inline-block text-blue-600 text-sm text-center">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-500 text-sm md:text-base">Aucun trajet trouvé</p>
            </div>
        @endforelse
    </div>
</div>
@endsection