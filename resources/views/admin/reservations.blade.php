@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6"> Gestion des réservations</h2>
    
    <!-- Version Desktop: tableau -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-[900px] w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm">ID</th>
                    <th class="px-4 py-2 text-left text-sm">Passager</th>
                    <th class="px-4 py-2 text-left text-sm">Conducteur</th>
                    <th class="px-4 py-2 text-left text-sm">Trajet</th>
                    <th class="px-4 py-2 text-left text-sm">Places</th>
                    <th class="px-4 py-2 text-left text-sm">Montant</th>
                    <th class="px-4 py-2 text-left text-sm">Date</th>
                    <th class="px-4 py-2 text-left text-sm">Statut</th>
                    <th class="px-4 py-2 text-left text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="reservationsTableBody">
                @foreach($reservations as $reservation)
                    <tr class="border-t hover:bg-gray-50" id="reservation-row-{{ $reservation->id }}">
                        <td class="px-4 py-2 text-sm">{{ $reservation->id }}</td>
                        <td class="px-4 py-2 text-sm font-medium">{{ $reservation->passager->utilisateur->nom }}</td>
                        <td class="px-4 py-2 text-sm">{{ $reservation->trajet->conducteur->utilisateur->nom }}</td>
                        <td class="px-4 py-2 text-sm">{{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}</td>
                        <td class="px-4 py-2 text-sm text-center">{{ $reservation->nombre_places }}</td>
                        <td class="px-4 py-2 text-sm font-semibold text-blue-600">{{ number_format($reservation->prix_total, 2) }} DH</td>
                        <td class="px-4 py-2 text-sm">{{ date('d/m/Y', strtotime($reservation->date_reservation)) }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="statut-badge px-2 py-1 text-xs rounded-full
                                {{ $reservation->statut == 'confirmee' ? 'bg-green-100 text-green-700' : 
                                   ($reservation->statut == 'annulee' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                @if($reservation->statut == 'confirmee') Confirmée
                                @elseif($reservation->statut == 'annulee') Annulée
                                @else En attente
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if($reservation->statut != 'annulee')
                                <button onclick="annulerReservation({{ $reservation->id }})" class="text-red-600 hover:text-red-800">
                                    Annuler
                                </button>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Version Mobile: cartes -->
    <div class="md:hidden space-y-4" id="reservationsMobileList">
        @foreach($reservations as $reservation)
            <div class="border rounded-lg p-4 bg-white shadow-sm" id="reservation-mobile-{{ $reservation->id }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="font-bold text-lg">
                            {{ $reservation->passager->utilisateur->nom }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            Conducteur: {{ $reservation->trajet->conducteur->utilisateur->nom }}
                        </div>
                    </div>
                    <span class="statut-badge-mobile px-2 py-1 text-xs rounded-full
                        {{ $reservation->statut == 'confirmee' ? 'bg-green-100 text-green-700' : 
                           ($reservation->statut == 'annulee' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        @if($reservation->statut == 'confirmee') Confirmée
                        @elseif($reservation->statut == 'annulee') Annulée
                        @else En attente
                        @endif
                    </span>
                </div>
                
                <div class="text-sm mb-2">
                    <span class="text-gray-500">Trajet:</span> {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div><span class="text-gray-500">Places:</span> {{ $reservation->nombre_places }}</div>
                    <div><span class="text-gray-500">Montant:</span> {{ number_format($reservation->prix_total, 2) }} DH</div>
                    <div><span class="text-gray-500">Date:</span> {{ date('d/m/Y', strtotime($reservation->date_reservation)) }}</div>
                    <div><span class="text-gray-500">#ID:</span> {{ $reservation->id }}</div>
                </div>
                
                <div class="flex gap-2">
                    @if($reservation->statut != 'annulee')
                        <button onclick="annulerReservation({{ $reservation->id }})" class="flex-1 text-red-600 border border-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-50">
                            Annuler
                        </button>
                    @else
                        <span class="flex-1 text-gray-400 text-center px-3 py-1">-</span>
                    @endif
                </div>
            </div>
        @endforeach
        @if(isset($reservations) && count($reservations) == 0)
            <div class="text-center py-8 text-gray-500">Aucune réservation trouvée</div>
        @endif
    </div>
    
    @if(isset($reservations) && count($reservations) == 0)
        <div class="text-center py-8 text-gray-500 hidden md:block">Aucune réservation trouvée</div>
    @endif
</div>

<script>
function showFlashMessage(message, type) {
    const container = document.querySelector('.fixed.top-20 .w-full.max-w-md');
    if(!container) return;
    const flashDiv = document.createElement('div');
    flashDiv.className = `mb-3 p-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white rounded-lg shadow-lg flex justify-between items-center flash-message`;
    flashDiv.innerHTML = `<div class="flex items-center space-x-2"><span>${type === 'success' ? '✓' : '✗'}</span><span>${message}</span></div><button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>`;
    container.prepend(flashDiv);
    setTimeout(() => { flashDiv.style.opacity = '0'; setTimeout(() => flashDiv.remove(), 300); }, 4000);
}

function annulerReservation(id) {
    if(confirm('Annuler cette réservation ?')) {
        fetch(`/admin/reservation/${id}/annuler`, { 
            method: 'POST', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' } 
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                location.reload();
            } else showFlashMessage(data.error, 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}
</script>
@endsection