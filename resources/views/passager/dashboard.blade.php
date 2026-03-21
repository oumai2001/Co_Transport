@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Contenu principal -->
    <div class="md:col-span-3">
        <!-- Statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-3 md:p-4 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-xs md:text-sm opacity-90">Total voyages</div>
                        <div class="text-xl md:text-2xl font-bold">{{ $stats['total_reservations'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-3 md:p-4 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-xs md:text-sm opacity-90">Trajets confirmes</div>
                        <div class="text-xl md:text-2xl font-bold">{{ $stats['reservations_confirmees'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-3 md:p-4 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-xs md:text-sm opacity-90">Total depense</div>
                        <div class="text-xl md:text-2xl font-bold">{{ number_format($stats['total_depense'], 0) }} DH</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Prochains trajets -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg md:text-xl font-bold">Prochains trajets</h2>
                <a href="/trajets" class="text-blue-600 text-xs md:text-sm hover:underline">Voir tous</a>
            </div>
            
            @if(count($prochains_trajets) > 0)
                <div class="space-y-4">
                    @foreach($prochains_trajets as $reservation)
                        <div class="border rounded-lg p-3 md:p-4 hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                                <div class="flex-1 w-full">
                                    <div class="flex items-center justify-between md:justify-start md:space-x-4 mb-2">
                                        <div class="text-center">
                                            <div class="font-bold text-sm md:text-base">{{ $reservation->trajet->villeDepart->nom }}</div>
                                            <div class="text-xs text-gray-500">{{ date('H:i', strtotime($reservation->trajet->date_depart)) }}</div>
                                        </div>
                                        <div class="text-gray-400">→</div>
                                        <div class="text-center">
                                            <div class="font-bold text-sm md:text-base">{{ $reservation->trajet->villeArrivee->nom }}</div>
                                            <div class="text-xs text-gray-500">{{ date('H:i', strtotime($reservation->trajet->date_arrivee)) }}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs md:text-sm text-gray-600">
                                        <div>{{ date('d/m/Y', strtotime($reservation->trajet->date_depart)) }}</div>
                                        <div>{{ $reservation->trajet->conducteur->utilisateur->nom }}</div>
                                        <div>{{ $reservation->nombre_places }} place(s)</div>
                                        <div>{{ number_format($reservation->prix_total, 2) }} DH</div>
                                    </div>
                                </div>
                                <div class="flex flex-row md:flex-col gap-2 md:space-y-2 ml-0 md:ml-4 w-full md:w-auto">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 text-center w-20 md:w-auto">Confirme</span>
                                    <button onclick="annulerReservation({{ $reservation->id }})" class="text-red-600 text-xs md:text-sm hover:underline text-center">Annuler</button>
                                    <a href="/trajet/{{ $reservation->trajet_id }}" class="text-blue-600 text-xs md:text-sm hover:underline text-center">Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">Aucun trajet à venir</p>
                    <a href="/trajets" class="mt-3 inline-block text-blue-600 hover:underline text-sm">Rechercher un trajet</a>
                </div>
            @endif
        </div>
        
        <!-- Historique recent -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-xl font-bold">Trajets recents</h2>
                <a href="/passager/historique" class="text-blue-600 text-xs md:text-sm hover:underline">Voir tout</a>
            </div>
            
            @if(count($historique_recent) > 0)
                <div class="space-y-3">
                    @foreach($historique_recent as $reservation)
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-3 border rounded-lg gap-2">
                            <div>
                                <div class="font-medium text-sm md:text-base">{{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}</div>
                                <div class="text-xs text-gray-500">{{ date('d/m/Y', strtotime($reservation->trajet->date_depart)) }}</div>
                            </div>
                            <div class="text-left md:text-right w-full md:w-auto">
                                <div class="font-bold text-blue-600 text-sm md:text-base">{{ number_format($reservation->prix_total, 2) }} DH</div>
                                <div class="text-xs text-gray-500">{{ $reservation->statut }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8 text-sm">Aucun historique de trajet</p>
            @endif
        </div>
    </div>
</div>

<script>
function annulerReservation(id) {
    if(confirm('Etes-vous sur de vouloir annuler cette reservation ?')) {
        window.location.href = '/reservation/annuler/' + id;
    }
}
</script>
@endsection