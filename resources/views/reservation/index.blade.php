@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <h2 class="text-xl md:text-2xl font-bold mb-4">Confirmation de réservation</h2>
        
        <div class="bg-gray-50 p-3 md:p-4 rounded-lg mb-4">
            <div class="flex justify-between items-center">
                <div class="text-center">
                    <div class="font-bold text-sm md:text-base">{{ $trajet->villeDepart->nom }}</div>
                    <div class="text-xs md:text-sm">{{ date('H:i', strtotime($trajet->date_depart)) }}</div>
                </div>
                <div class="text-gray-400 text-sm md:text-base">→</div>
                <div class="text-center">
                    <div class="font-bold text-sm md:text-base">{{ $trajet->villeArrivee->nom }}</div>
                    <div class="text-xs md:text-sm">{{ date('H:i', strtotime($trajet->date_arrivee)) }}</div>
                </div>
            </div>
        </div>
        
        <div class="border-b pb-3 mb-3 text-sm md:text-base">
            <p><strong>Conducteur:</strong> {{ $trajet->conducteur->utilisateur->nom }}</p>
            <p><strong>Date:</strong> {{ date('d/m/Y', strtotime($trajet->date_depart)) }}</p>
            <p><strong>Prix par place:</strong> {{ number_format($trajet->prix, 2) }} DH</p>
            <p><strong>Places disponibles:</strong> {{ $trajet->places_disponibles }}</p>
        </div>
        
        <form action="/reservation/{{ $trajet->id }}/confirmer" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-bold mb-2 text-sm md:text-base">Nombre de places</label>
                <input type="number" name="nombre_places" value="1" min="1" max="{{ $trajet->places_disponibles }}" 
                       class="w-20 md:w-24 px-3 py-2 border rounded-lg text-sm md:text-base">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm md:text-base">
                Confirmer la réservation
            </button>
        </form>
    </div>
</div>
@endsection