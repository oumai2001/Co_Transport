@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <a href="{{ route('conducteur.mes-trajets') }}" class="text-blue-600 hover:underline text-sm md:text-base">← Retour à mes trajets</a>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold">Passagers du trajet</h2>
            <p class="text-gray-600 text-sm md:text-base mt-1">
                {{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}
                - {{ date('d/m/Y H:i', strtotime($trajet->date_depart)) }}
            </p>
        </div>
        <div class="text-right">
            <div class="text-xs md:text-sm text-gray-600">Places disponibles</div>
            <div class="text-xl md:text-2xl font-bold text-green-600">{{ $places_restantes ?? $trajet->places_disponibles }}/{{ $trajet->vehicule->capacite }}</div>
        </div>
    </div>
    
    <!-- Liste des passagers -->
    <div class="space-y-4">
        @if(count($reservations) > 0)
            @foreach($reservations as $reservation)
                <div class="border rounded-lg p-3 md:p-4 hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xl md:text-2xl font-bold text-blue-600">{{ substr($reservation->passager->utilisateur->nom, 0, 2) }}</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-base md:text-lg">{{ $reservation->passager->utilisateur->nom }}</h3>
                                <div class="text-xs md:text-sm text-gray-600 space-y-1">
                                    <div> {{ $reservation->passager->utilisateur->telephone }}</div>
                                    <div> {{ $reservation->passager->utilisateur->email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <div class="text-xs md:text-sm text-gray-600">Nombre de places</div>
                            <div class="text-xl md:text-2xl font-bold text-blue-600">{{ $reservation->nombre_places }}</div>
                            <div class="text-xs text-gray-500 mt-1">Réservé le {{ date('d/m/Y', strtotime($reservation->date_reservation)) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-sm md:text-base">Aucun passager pour ce trajet</p>
            </div>
        @endif
    </div>
    
    <!-- Actions sur le trajet -->
    <div class="mt-6 pt-6 border-t">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <label class="block text-gray-700 mb-2 text-sm md:text-base">Statut du trajet</label>
                <select id="statutTrajet" class="px-3 py-2 border rounded-lg text-sm md:text-base" onchange="changerStatut({{ $trajet->id }})">
                    <option value="programme" {{ $trajet->statut == 'programme' ? 'selected' : '' }}>Programmé</option>
                    <option value="en_cours" {{ $trajet->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="termine" {{ $trajet->statut == 'termine' ? 'selected' : '' }}>Terminé</option>
                    <option value="annule" {{ $trajet->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            
            @if($trajet->statut == 'programme')
                <button onclick="annulerTrajet({{ $trajet->id }})" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm md:text-base">
                    Annuler le trajet
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function changerStatut(trajetId) {
    const nouveauStatut = document.getElementById('statutTrajet').value;
    
    fetch(`/conducteur/trajet/${trajetId}/statut`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ statut: nouveauStatut })
    }).then(response => {
        if(response.ok) {
            location.reload();
        }
    }).catch(() => alert('Erreur'));
}

function annulerTrajet(id) {
    if(confirm('Annuler ce trajet ? Toutes les réservations seront annulées.')) {
        fetch(`/conducteur/trajet/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if(response.ok) {
                window.location.href = '{{ route("conducteur.mes-trajets") }}';
            }
        }).catch(() => alert('Erreur'));
    }
}
</script>
@endsection