@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6"> Gestion des vehicules</h2>
    
    <!-- Version Desktop: tableau -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-[800px] w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm">ID</th>
                    <th class="px-4 py-2 text-left text-sm">Conducteur</th>
                    <th class="px-4 py-2 text-left text-sm">Marque/Modele</th>
                    <th class="px-4 py-2 text-left text-sm">Immatriculation</th>
                    <th class="px-4 py-2 text-left text-sm">Capacite</th>
                    <th class="px-4 py-2 text-left text-sm">Statut</th>
                    <th class="px-4 py-2 text-left text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="vehiculesTableBody">
                @foreach($vehicules as $vehicule)
                    <tr class="border-t hover:bg-gray-50" id="vehicule-row-{{ $vehicule->id }}">
                        <td class="px-4 py-2 text-sm">{{ $vehicule->id }}</td>
                        <td class="px-4 py-2 text-sm font-medium">{{ $vehicule->conducteur->utilisateur->nom }}</td>
                        <td class="px-4 py-2 text-sm">{{ $vehicule->marque }} {{ $vehicule->modele }}</td>
                        <td class="px-4 py-2 text-sm">{{ $vehicule->immatriculation }}</td>
                        <td class="px-4 py-2 text-sm text-center">{{ $vehicule->capacite }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="statut-badge px-2 py-1 text-xs rounded-full
                                {{ $vehicule->statut == 'disponible' ? 'bg-green-100 text-green-700' : 
                                   ($vehicule->statut == 'maintenance' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                @if($vehicule->statut == 'disponible') Disponible
                                @elseif($vehicule->statut == 'maintenance') Maintenance
                                @else En trajet
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <button onclick="supprimerVehicule({{ $vehicule->id }})" class="text-red-600 hover:text-red-800">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Version Mobile: cartes -->
    <div class="md:hidden space-y-4" id="vehiculesMobileList">
        @foreach($vehicules as $vehicule)
            <div class="border rounded-lg p-4 bg-white shadow-sm" id="vehicule-mobile-{{ $vehicule->id }}">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="font-bold text-base">{{ $vehicule->marque }} {{ $vehicule->modele }}</div>
                        <div class="text-xs text-gray-500">#{{ $vehicule->id }}</div>
                    </div>
                    <span class="statut-badge-mobile px-2 py-1 text-xs rounded-full
                        {{ $vehicule->statut == 'disponible' ? 'bg-green-100 text-green-700' : 
                           ($vehicule->statut == 'maintenance' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        @if($vehicule->statut == 'disponible') Disponible
                        @elseif($vehicule->statut == 'maintenance') Maintenance
                        @else En trajet
                        @endif
                    </span>
                </div>
                <div class="text-sm mb-2"><span class="text-gray-500">Conducteur:</span> {{ $vehicule->conducteur->utilisateur->nom }}</div>
                <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                    <div><span class="text-gray-500">Immatriculation:</span> {{ $vehicule->immatriculation }}</div>
                    <div><span class="text-gray-500">Capacite:</span> {{ $vehicule->capacite }} places</div>
                </div>
                <button onclick="supprimerVehicule({{ $vehicule->id }})" class="w-full text-red-600 border border-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-50">
                    Supprimer
                </button>
            </div>
        @endforeach
        @if(isset($vehicules) && count($vehicules) == 0)
            <div class="text-center py-8 text-gray-500">Aucun vehicule trouve</div>
        @endif
    </div>
    
    @if(isset($vehicules) && count($vehicules) == 0)
        <div class="text-center py-8 text-gray-500 hidden md:block">Aucun vehicule trouve</div>
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

function supprimerVehicule(id) {
    if(confirm('Supprimer ce vehicule ?')) {
        fetch(`/admin/vehicule/${id}`, { 
            method: 'DELETE', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } 
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { 
                showFlashMessage(data.message, 'success'); 
                document.getElementById(`vehicule-row-${id}`)?.remove();
                document.getElementById(`vehicule-mobile-${id}`)?.remove();
            } else showFlashMessage(data.error, 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}
</script>
@endsection