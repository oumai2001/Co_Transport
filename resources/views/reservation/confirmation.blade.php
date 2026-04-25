@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 ">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r px-6 py-4">
            <h2 class="text-2xl font-bold text-black">Confirmation de réservation</h2>
            <p class="text-blue-600 text-sm mt-1">Vérifiez les informations et choisissez le nombre de places</p>
        </div>

        <div class="p-6 md:p-8">
            <!-- Carte récapitulative du trajet -->
            <div class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-gray-800">{{ $trajet->villeDepart->nom }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ \Carbon\Carbon::parse($trajet->date_depart)->format('H:i') }}</div>
                    </div>
                    <div class="text-gray-400 text-xl px-4">→</div>
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-gray-800">{{ $trajet->villeArrivee->nom }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ \Carbon\Carbon::parse($trajet->date_arrivee)->format('H:i') }}</div>
                    </div>
                </div>
                <div class="text-center text-gray-500 text-sm mt-3">
                    {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                </div>
            </div>

            <!-- Détails du trajet -->
            <div class="space-y-4 mb-6">
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <span class="text-gray-600">Conducteur</span>
                    <span class="font-semibold text-gray-800">{{ $trajet->conducteur->utilisateur->nom }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <span class="text-gray-600">Prix par place</span>
                    <span class="font-bold text-blue-600 text-lg">{{ number_format($trajet->prix, 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <span class="text-gray-600">Places disponibles</span>
                    <span class="font-semibold text-green-600">{{ $trajet->places_disponibles }}</span>
                </div>
            </div>

            <!-- Formulaire de réservation -->
            <form action="{{ route('reservation.confirmer', $trajet->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Nombre de places</label>
                    <div class="flex items-center space-x-4">
                        <input type="number" name="nombre_places" id="nb_places" value="1" min="1" max="{{ $trajet->places_disponibles }}" 
                               class="w-24 text-center px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <div class="text-gray-600">
                            <span class="font-medium" id="total_price">{{ number_format($trajet->prix, 2) }}</span> DH
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Maximum {{ $trajet->places_disponibles }} places</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('trajet.show', $trajet->id) }}" 
                       class="flex-1 text-center bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition font-medium">
                        ← Retour
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition font-medium shadow-sm">
                        Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mise à jour dynamique du prix total
    const prixUnitaire = {{ $trajet->prix }};
    const inputPlaces = document.getElementById('nb_places');
    const totalSpan = document.getElementById('total_price');

    inputPlaces.addEventListener('input', function() {
        let places = parseInt(this.value) || 1;
        if (places < 1) places = 1;
        if (places > {{ $trajet->places_disponibles }}) places = {{ $trajet->places_disponibles }};
        let total = places * prixUnitaire;
        totalSpan.innerText = total.toFixed(2);
    });
</script>
@endsection