@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-3 md:p-4 text-white">
            <div class="text-xs md:text-sm opacity-90">Trajets</div>
            <div class="text-xl md:text-2xl font-bold">{{ $stats['total_trajets'] }}</div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-3 md:p-4 text-white">
            <div class="text-xs md:text-sm opacity-90">Passagers</div>
            <div class="text-xl md:text-2xl font-bold">{{ $stats['total_passagers'] }}</div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-3 md:p-4 text-white">
            <div class="text-xs md:text-sm opacity-90">Gains</div>
            <div class="text-xl md:text-2xl font-bold">{{ number_format($stats['gains_totaux'], 0) }} DH</div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-3 md:p-4 text-white">
            <div class="text-xs md:text-sm opacity-90">Note</div>
            <div class="text-xl md:text-2xl font-bold">{{ number_format($stats['note_moyenne'], 1) }}/5</div>
        </div>
    </div>
    
    <!-- Prochains trajets -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-xl font-bold">Prochains trajets</h2>
            <a href="{{ route('conducteur.mes-trajets') }}" class="text-blue-600 text-xs md:text-sm hover:underline">Voir tous</a>
        </div>
        
        @if(count($prochains_trajets) > 0)
            <div class="space-y-4">
                @foreach($prochains_trajets as $trajet)
                    <div class="border rounded-lg p-3 md:p-4 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                            <div class="flex-1 w-full">
                                <!-- Trajet -->
                                <div class="flex items-center justify-between md:justify-start md:space-x-4 mb-2">
                                    <div class="text-center">
                                        <div class="font-bold text-sm md:text-base">{{ $trajet->villeDepart->nom }}</div>
                                        <div class="text-xs text-gray-500">{{ date('H:i', strtotime($trajet->date_depart)) }}</div>
                                    </div>
                                    <div class="text-gray-400 text-sm">→</div>
                                    <div class="text-center">
                                        <div class="font-bold text-sm md:text-base">{{ $trajet->villeArrivee->nom }}</div>
                                        <div class="text-xs text-gray-500">{{ date('H:i', strtotime($trajet->date_arrivee)) }}</div>
                                    </div>
                                </div>
                                <!-- Infos -->
                                <div class="grid grid-cols-2 gap-2 text-xs md:text-sm text-gray-600">
                                    <div>{{ date('d/m/Y', strtotime($trajet->date_depart)) }}</div>
                                    <div>{{ number_format($trajet->prix, 2) }} DH/place</div>
                                    <div>{{ $trajet->places_disponibles }} places</div>
                                    <div>{{ $trajet->vehicule->marque }} {{ $trajet->vehicule->modele }}</div>
                                </div>
                            </div>
                            <div class="flex flex-row md:flex-col space-x-2 md:space-x-0 md:space-y-2 ml-0 md:ml-4 w-full md:w-auto">
                                <span class="px-2 py-1 text-xs rounded-full text-center w-24 md:w-auto
                                    {{ $trajet->statut == 'programme' ? 'bg-blue-100 text-blue-700' : 
                                       ($trajet->statut == 'en_cours' ? 'bg-green-100 text-green-700' : 
                                       ($trajet->statut == 'termine' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700')) }}">
                                    @if($trajet->statut == 'programme') Programme
                                    @elseif($trajet->statut == 'en_cours') En cours
                                    @elseif($trajet->statut == 'termine') Terminé
                                    @else Annulé
                                    @endif
                                </span>
                                <a href="{{ route('conducteur.trajet.passagers', $trajet->id) }}" class="text-blue-600 text-xs md:text-sm hover:underline text-center">Passagers</a>
                                <a href="{{ route('conducteur.trajet.edit', $trajet->id) }}" class="text-green-600 text-xs md:text-sm hover:underline text-center">Modifier</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 text-sm">Aucun trajet à venir</p>
                <a href="{{ route('conducteur.creer-trajet') }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                    Proposer un trajet
                </a>
            </div>
        @endif
    </div>
    
    <!-- Dernières réservations -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-xl font-bold">Dernières réservations</h2>
            <a href="{{ route('conducteur.mes-trajets') }}" class="text-blue-600 text-xs md:text-sm hover:underline">Voir tous</a>
        </div>
        
        @if(count($dernieres_reservations) > 0)
            <div class="space-y-3">
                @foreach($dernieres_reservations as $reservation)
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-3 border rounded-lg gap-3">
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-blue-600 text-sm">{{ substr($reservation->passager->utilisateur->nom, 0, 2) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm md:text-base">{{ $reservation->passager->utilisateur->nom }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right w-full md:w-auto">
                            <div class="font-bold text-green-600 text-sm md:text-base">{{ number_format($reservation->prix_total, 2) }} DH</div>
                            <div class="text-xs text-gray-500">{{ $reservation->nombre_places }} place(s)</div>
                            <div class="text-xs text-gray-400">{{ date('d/m/Y', strtotime($reservation->created_at)) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-8 text-sm">Aucune réservation récente</p>
        @endif
    </div>
</div>
@endsection