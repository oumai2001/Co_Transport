@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <a href="{{ route('trajets.index') }}" class="text-blue-600 hover:underline mb-4 inline-block text-sm md:text-base">← Retour</a>
        <h2 class="text-center text-xl md:text-2xl font-bold mb-4">Détails du trajet</h2>

        <div class="space-y-4">
            <!-- TRAJET -->
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div class="text-center flex-1">
                        <div class="font-bold text-base md:text-xl">{{ optional($trajet->villeDepart)->nom }}</div>
                        <div class="text-gray-600 text-xs md:text-sm">{{ \Carbon\Carbon::parse($trajet->date_depart)->format('H:i') }}</div>
                        <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}</div>
                    </div>
                    <div class="text-xl md:text-2xl text-gray-400">→</div>
                    <div class="text-center flex-1">
                        <div class="font-bold text-base md:text-xl">{{ optional($trajet->villeArrivee)->nom }}</div>
                        <div class="text-gray-600 text-xs md:text-sm">{{ \Carbon\Carbon::parse($trajet->date_arrivee)->format('H:i') }}</div>
                        <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($trajet->date_arrivee)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="border rounded-lg p-3 md:p-4">
                <h3 class="font-bold mb-2 text-sm md:text-base">Conducteur</h3>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="font-bold text-sm md:text-base">{{ substr(optional($trajet->conducteur)->utilisateur->nom ?? '', 0, 2) }}</span>
                    </div>
                    <div>
                        <div class="font-semibold text-sm md:text-base">{{ optional($trajet->conducteur)->utilisateur->nom }}</div>
                        <div class="text-gray-600 text-xs md:text-sm">{{ optional($trajet->conducteur)->utilisateur->telephone }}</div>
                    </div>
                </div>

                @if(session('user_role') == 'passager')
                    @php
                        $passagerId = session('role_id');
                        $estFavori = App\Models\Favori::where('passager_id', $passagerId)
                            ->where('conducteur_id', $trajet->conducteur_id)
                            ->exists();
                    @endphp
                    
                    @if($estFavori)
                        <button onclick="retirerFavori({{ $trajet->conducteur_id }})" class="mt-3 text-yellow-600 text-xs md:text-sm flex items-center space-x-1 hover:text-yellow-700 transition">
                            <svg class="w-4 h-4 fill-current text-yellow-500" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span>Dans mes favoris</span>
                        </button>
                    @else
                        <button onclick="ajouterFavori({{ $trajet->conducteur_id }})" class="mt-3 text-gray-500 text-xs md:text-sm flex items-center space-x-1 hover:text-yellow-600 transition">
                            <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span>Ajouter aux favoris</span>
                        </button>
                    @endif
                @endif
            </div>

            <!-- VEHICULE -->
            <div class="border rounded-lg p-3 md:p-4">
                <h3 class="font-bold mb-2 text-sm md:text-base">Véhicule</h3>
                <div class="text-sm md:text-base">{{ optional($trajet->vehicule)->marque }} {{ optional($trajet->vehicule)->modele }}</div>
                <div class="text-gray-600 text-xs md:text-sm">{{ optional($trajet->vehicule)->capacite }} places</div>
            </div>

            <!-- PRIX -->
            <div class="border rounded-lg p-3 md:p-4 flex justify-between items-center">
                <div>
                    <div class="text-gray-600 text-xs md:text-sm">Prix par place</div>
                    <div class="text-2xl md:text-3xl font-bold text-blue-600">{{ number_format($trajet->prix, 2) }} DH</div>
                </div>
                <div>
                    <div class="text-gray-600 text-xs md:text-sm">Places disponibles</div>
                    <div class="text-xl md:text-2xl font-bold text-green-600">{{ $trajet->places_disponibles }}</div>
                </div>
            </div>

            @if(session('user_role') == 'passager')
                @if($dejaReserve)
                    @if($reservationExistante->statut == 'en_attente')
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-3 md:p-4 rounded-lg text-center">
                            <div class="font-bold mb-1 text-sm md:text-base"> Réservation en attente</div>
                            <p class="text-xs md:text-sm mb-3">
                                Vous avez réservé <strong>{{ $reservationExistante->nombre_places }} place(s)</strong>.<br>
                                Le paiement n'est pas encore effectué.
                            </p>
                            <a href="{{ route('paiement.show', $reservationExistante->id) }}" class="inline-block bg-yellow-600 text-white px-3 md:px-4 py-1 md:py-2 rounded-lg hover:bg-yellow-700 text-xs md:text-sm">
                                Payer maintenant
                            </a>
                        </div>
                    @elseif($reservationExistante->statut == 'confirmee')
                        <div class="bg-green-100 border border-green-400 text-green-700 p-3 md:p-4 rounded-lg text-center">
                            <div class="font-bold mb-1 text-sm md:text-base"> Réservation confirmée</div>
                            <p class="text-xs md:text-sm">
                                Vous avez réservé <strong>{{ $reservationExistante->nombre_places }} place(s)</strong> pour ce trajet (payé).
                            </p>
                            <a href="{{ route('passager.historique') }}" class="inline-block text-green-700 underline text-xs md:text-sm mt-2">Voir mon historique →</a>
                        </div>
                    @endif
                @else
                    @if($trajet->places_disponibles > 0)
                        <a href="{{ route('reservation.choisir', $trajet->id) }}" class="block bg-green-600 text-white text-center py-2 md:py-3 rounded-lg hover:bg-green-700 transition text-sm md:text-base">
                            Réserver maintenant
                        </a>
                    @else
                        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded-lg text-center text-sm">
                            Plus de places disponibles pour ce trajet
                        </div>
                    @endif
                @endif
            @elseif(session('user_role') != 'passager')
                 <a href="{{ route('login') }}" 
       class="block bg-green-600 text-white text-center py-2 md:py-3 rounded-lg hover:bg-green-700 transition text-sm md:text-base">
        Connectez-vous en tant que passager pour réserver
    </a>
            @endif
        </div>
    </div>
</div>

<script>
function ajouterFavori(conducteurId) {
    fetch('/favori/ajouter/' + conducteurId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(data => {
        if(data.success) location.reload();
        else alert(data.message || 'Erreur lors de l\'ajout');
    })
    .catch(error => alert('Erreur: ' + error.message));
}

function retirerFavori(conducteurId) {
    if(confirm('Retirer ce conducteur de vos favoris ?')) {
        fetch('/favori/retirer/' + conducteurId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            if(data.success) location.reload();
            else alert(data.message || 'Erreur lors du retrait');
        })
        .catch(error => alert('Erreur: ' + error.message));
    }
}
</script>
@endsection