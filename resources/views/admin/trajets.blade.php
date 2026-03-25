@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6"> Gestion des trajets</h2>
    
    @php
        $trajetsTries = $trajets->sortBy('id');
    @endphp

    <!-- Version Desktop: tableau -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-[800px] w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm">ID</th>
                    <th class="px-4 py-2 text-left text-sm">Conducteur</th>
                    <th class="px-4 py-2 text-left text-sm">Trajet</th>
                    <th class="px-4 py-2 text-left text-sm">Date</th>
                    <th class="px-4 py-2 text-left text-sm">Prix</th>
                    <th class="px-4 py-2 text-left text-sm">Statut</th>
                    <th class="px-4 py-2 text-left text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="trajetsTableBody">
                @foreach($trajetsTries as $trajet)
                    <tr class="border-t hover:bg-gray-50" id="trajet-row-{{ $trajet->id }}">
                        <td class="px-4 py-2 text-sm">{{ $trajet->id }}</td>
                        <td class="px-4 py-2 text-sm font-medium">{{ $trajet->conducteur->utilisateur->nom }}</td>
                        <td class="px-4 py-2 text-sm">{{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}</td>
                        <td class="px-4 py-2 text-sm">{{ date('d/m/Y', strtotime($trajet->date_depart)) }}</td>
                        <td class="px-4 py-2 text-sm font-semibold text-blue-600">{{ number_format($trajet->prix, 2) }} DH</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="statut-badge px-2 py-1 text-xs rounded-full
                                {{ $trajet->statut == 'programme' ? 'bg-blue-100 text-blue-700' : 
                                   ($trajet->statut == 'en_cours' ? 'bg-green-100 text-green-700' :
                                   ($trajet->statut == 'termine' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700')) }}">
                                @if($trajet->statut == 'programme') Programme
                                @elseif($trajet->statut == 'en_cours') En cours
                                @elseif($trajet->statut == 'termine') Termine
                                @else Annule
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex space-x-2">
                                @if($trajet->statut != 'programme' && $trajet->statut != 'termine' && $trajet->statut != 'annule')
                                    <button onclick="validerTrajet({{ $trajet->id }})" class="text-green-600 hover:text-green-800">
                                        Valider
                                    </button>
                                @endif
                                <button onclick="supprimerTrajet({{ $trajet->id }})" class="text-red-600 hover:text-red-800">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Version Mobile: cartes -->
    <div class="md:hidden space-y-4" id="trajetsMobileList">
        @foreach($trajetsTries as $trajet)
            <div class="border rounded-lg p-4 bg-white shadow-sm" id="trajet-mobile-{{ $trajet->id }}">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="font-bold text-base">{{ $trajet->conducteur->utilisateur->nom }}</div>
                        <div class="text-xs text-gray-500">#{{ $trajet->id }}</div>
                    </div>
                    <span class="statut-badge-mobile px-2 py-1 text-xs rounded-full
                        {{ $trajet->statut == 'programme' ? 'bg-blue-100 text-blue-700' : 
                           ($trajet->statut == 'en_cours' ? 'bg-green-100 text-green-700' :
                           ($trajet->statut == 'termine' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700')) }}">
                        @if($trajet->statut == 'programme') Programme
                        @elseif($trajet->statut == 'en_cours') En cours
                        @elseif($trajet->statut == 'termine') Termine
                        @else Annule
                        @endif
                    </span>
                </div>
                <div class="text-sm font-semibold mb-2">{{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}</div>
                <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                    <div><span class="text-gray-500">Date:</span> {{ date('d/m/Y', strtotime($trajet->date_depart)) }}</div>
                    <div><span class="text-gray-500">Prix:</span> {{ number_format($trajet->prix, 2) }} DH</div>
                </div>
                <div class="flex gap-2">
                    @if($trajet->statut != 'programme' && $trajet->statut != 'termine' && $trajet->statut != 'annule')
                        <button onclick="validerTrajet({{ $trajet->id }})" class="flex-1 text-green-600 border border-green-300 px-2 py-1 rounded text-sm hover:bg-green-50">
                            Valider
                        </button>
                    @endif
                    <button onclick="supprimerTrajet({{ $trajet->id }})" class="flex-1 text-red-600 border border-red-300 px-2 py-1 rounded text-sm hover:bg-red-50">
                        Supprimer
                    </button>
                </div>
            </div>
        @endforeach
        @if(isset($trajetsTries) && count($trajetsTries) == 0)
            <div class="text-center py-8 text-gray-500">Aucun trajet trouvé</div>
        @endif
    </div>
    
    @if(isset($trajetsTries) && count($trajetsTries) == 0)
        <div class="text-center py-8 text-gray-500 hidden md:block">Aucun trajet trouvé</div>
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

function validerTrajet(id) {
    if(confirm('Valider ce trajet ?')) {
        fetch(`/admin/trajet/${id}/valider`, { 
            method: 'POST', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' } 
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                location.reload();
            } else showFlashMessage(data.error, 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}

function supprimerTrajet(id) {
    if(confirm('Supprimer ce trajet ?')) {
        fetch(`/admin/trajet/${id}`, { 
            method: 'DELETE', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } 
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { 
                showFlashMessage(data.message, 'success'); 
                document.getElementById(`trajet-row-${id}`)?.remove();
                document.getElementById(`trajet-mobile-${id}`)?.remove();
            } else showFlashMessage(data.error, 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}
</script>
@endsection