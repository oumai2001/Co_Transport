@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 mb-6">
        <h2 class="text-xl md:text-2xl font-bold">Mes trajets</h2>

        <a href="{{ route('conducteur.creer-trajet') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm md:text-base text-center">
            + Nouveau trajet
        </a>
    </div>

    <!-- Filtres -->
    <div class="mb-6 flex flex-col sm:flex-row gap-3">
        <select id="filtreStatut" class="px-3 py-2 border rounded-lg text-sm" onchange="filtrerTrajets()">
            <option value="all">Tous les statuts</option>
            <option value="en_attente">En attente</option>
            <option value="programme">Programmés</option>
            <option value="en_cours">En cours</option>
            <option value="termine">Terminés</option>
            <option value="annule">Annulés</option>
            <option value="refuse">Refusés</option>
        </select>

        <select id="filtrePeriode" class="px-3 py-2 border rounded-lg text-sm" onchange="filtrerTrajets()">
            <option value="all">Toutes périodes</option>
            <option value="upcoming">À venir</option>
            <option value="past">Passés</option>
        </select>
    </div>

    <!-- Liste -->
    <div class="space-y-4" id="listeTrajets">

        @forelse($trajets as $trajet)
        <div class="border rounded-lg p-3 md:p-4 trajet-item"
             data-statut="{{ $trajet->statut }}"
             data-date="{{ strtotime($trajet->date_depart) }}">

            <div class="flex flex-col md:flex-row justify-between gap-3">

                <div class="flex-1">

                    <!-- HEADER avec statut -->
                    <div class="flex justify-between items-center mb-2 flex-wrap gap-2">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($trajet->statut == 'en_attente')
                                bg-orange-100 text-orange-700
                            @elseif($trajet->statut == 'programme')
                                bg-blue-100 text-blue-700
                            @elseif($trajet->statut == 'en_cours')
                                bg-green-100 text-green-700
                            @elseif($trajet->statut == 'termine')
                                bg-gray-100 text-gray-700
                            @elseif($trajet->statut == 'annule')
                                bg-red-100 text-red-700
                            @elseif($trajet->statut == 'refuse')
                                bg-red-100 text-red-700
                            @else
                                bg-gray-100 text-gray-700
                            @endif">
                            @if($trajet->statut == 'en_attente')
                                En attente de validation
                            @elseif($trajet->statut == 'programme')
                                Programmée
                            @elseif($trajet->statut == 'en_cours')
                                En cours
                            @elseif($trajet->statut == 'termine')
                                Terminée
                            @elseif($trajet->statut == 'annule')
                                Annulée
                            @elseif($trajet->statut == 'refuse')
                                Refusée
                            @else
                                {{ ucfirst($trajet->statut) }}
                            @endif
                        </span>

                        <span class="text-green-600 font-bold text-sm md:text-base">
                            {{ number_format($trajet->prix, 2) }} DH
                        </span>
                    </div>

                    <!-- VILLES -->
                    <div class="flex justify-between mb-2 text-base md:text-lg font-semibold">
                        <div>{{ $trajet->villeDepart->nom ?? 'N/A' }}</div>
                        <div class="text-gray-400">→</div>
                        <div>{{ $trajet->villeArrivee->nom ?? 'N/A' }}</div>
                    </div>

                    <!-- INFOS -->
                    <div class="flex flex-wrap gap-3 text-xs md:text-sm text-gray-600">
                        <span>{{ date('d/m/Y H:i', strtotime($trajet->date_depart)) }}</span>
                        <span>{{ $trajet->places_disponibles }} places</span>
                        <span>{{ $trajet->vehicule->marque ?? '' }} {{ $trajet->vehicule->modele ?? '' }}</span>
                    </div>

                    <!-- Message pour trajet refusé -->
                    @if($trajet->statut == 'refuse')
                        <div class="mt-2 text-xs text-red-600">
                             Ce trajet a été refusé par l'administrateur. Veuillez contacter le support.
                        </div>
                    @endif

                    <!-- Message pour trajet en attente -->
                    @if($trajet->statut == 'en_attente')
                        <div class="mt-2 text-xs text-orange-600">
                            Ce trajet est en attente de validation par l'administrateur.
                        </div>
                    @endif

                </div>

                <!-- ACTIONS -->
                <div class="flex flex-row md:flex-col gap-2 md:space-y-2 min-w-[100px]">

                    <a href="{{ route('conducteur.trajet.passagers', $trajet->id) }}"
                       class="text-blue-600 text-sm hover:underline text-center md:text-left">
                        Passagers
                    </a>

                    @if($trajet->statut == 'en_attente' || $trajet->statut == 'programme')
                        <a href="{{ route('conducteur.trajet.edit', $trajet->id) }}"
                           class="text-green-600 text-sm hover:underline text-center md:text-left">
                             Modifier
                        </a>
                    @endif

                    @if($trajet->statut == 'en_attente' || $trajet->statut == 'programme')
                        <button onclick="annulerTrajet({{ $trajet->id }})"
                                class="text-red-600 text-sm hover:underline text-center md:text-left">
                             Annuler
                        </button>
                    @endif

                    @if($trajet->statut == 'programme' && strtotime($trajet->date_depart) <= time())
                        <button onclick="demarrerTrajet({{ $trajet->id }})"
                                class="text-blue-600 text-sm hover:underline text-center md:text-left">
                             Démarrer
                        </button>
                    @endif

                    @if($trajet->statut == 'en_cours')
                        <button onclick="terminerTrajet({{ $trajet->id }})"
                                class="text-green-600 text-sm hover:underline text-center md:text-left">
                             Terminer
                        </button>
                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="text-center py-10 text-gray-500">
            <p class="text-sm">Aucun trajet trouvé</p>
            <a href="{{ route('conducteur.creer-trajet') }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                Proposer mon premier trajet
            </a>
        </div>

        @endforelse

    </div>
</div>

<script>
function filtrerTrajets() {
    const statut = document.getElementById('filtreStatut').value;
    const periode = document.getElementById('filtrePeriode').value;
    const now = Date.now() / 1000;

    document.querySelectorAll('.trajet-item').forEach(item => {
        let show = true;

        if (statut !== 'all' && item.dataset.statut !== statut) show = false;
        if (periode === 'upcoming' && item.dataset.date < now) show = false;
        if (periode === 'past' && item.dataset.date > now) show = false;

        item.style.display = show ? 'block' : 'none';
    });
}

function demarrerTrajet(id) {
    if(confirm('Démarrer ce trajet ?')) {
        fetch(`/conducteur/trajet/${id}/statut`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ statut: 'en_cours' })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) location.reload();
            else alert(data.error || 'Erreur');
        })
        .catch(() => alert('Erreur serveur'));
    }
}

function terminerTrajet(id) {
    if(confirm('Terminer ce trajet ?')) {
        fetch(`/conducteur/trajet/${id}/statut`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ statut: 'termine' })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) location.reload();
            else alert(data.error || 'Erreur');
        })
        .catch(() => alert('Erreur serveur'));
    }
}

function annulerTrajet(id) {
    if(confirm('Annuler ce trajet ? Toutes les réservations seront annulées.')) {
        fetch(`/conducteur/trajet/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => {
            if(res.ok) location.reload();
            else alert('Erreur lors de l\'annulation');
        })
        .catch(() => alert('Erreur serveur'));
    }
}
</script>

@endsection