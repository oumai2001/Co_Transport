@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 transition flex items-center space-x-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Retour</span>
                </a>
            </div>
              <div class="text-center">
                    <h2 class="text-2xl font-bold text-black"> Paiement</h2>
                    <p class="text-blue-600 text-sm mt-1">Finalisez votre réservation</p>
                </div>
        </div>

        <div class="p-6 md:p-8">
            <!-- Récapitulatif de la réservation -->
            <div class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Trajet</span>
                    <span class="font-semibold text-gray-800">{{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Nombre de places</span>
                    <span class="font-semibold text-gray-800">{{ $reservation->nombre_places }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                    <span class="text-gray-800 font-bold">Total à payer</span>
                    <span class="text-2xl font-bold text-green-600">{{ number_format($reservation->prix_total, 2) }} DH</span>
                </div>
            </div>

            <!-- Formulaire de paiement -->
            <form method="POST" action="{{ route('paiement.effectuer', $reservation->id) }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Mode de paiement</label>
                    <select name="mode_paiement" id="mode_paiement" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="carte">Carte bancaire</option>
                        <option value="especes">Espèces (au conducteur)</option>
                    </select>
                </div>

                <div id="carteFields">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Numéro de carte</label>
                        <input type="text" placeholder="1234 5678 9012 3456" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Date d'expiration</label>
                            <input type="text" placeholder="MM/AA" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">CVV</label>
                            <input type="text" placeholder="123" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition shadow-md">
                    Payer {{ number_format($reservation->prix_total, 2) }} DH
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('mode_paiement').addEventListener('change', function() {
        const carteFields = document.getElementById('carteFields');
        carteFields.style.display = this.value === 'carte' ? 'block' : 'none';
    });
</script>
@endsection