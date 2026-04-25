@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Historique des reservations</h2>
    
    <div class="mb-6 flex flex-col sm:flex-row gap-3">
        <select id="filtreStatut" class="px-3 py-2 border rounded-lg text-sm" onchange="filtrerHistorique()">
            <option value="all">Tous les statuts</option>
            <option value="confirmee">Confirmees</option>
            <option value="termine">Termines</option>
            <option value="annulee">Annulees</option>
        </select>
        <input type="date" id="filtreDate" class="px-3 py-2 border rounded-lg text-sm" onchange="filtrerHistorique()">
    </div>
    
    <!-- Liste des reservations -->
    <div class="space-y-4" id="listeReservations">
        @foreach($reservations as $reservation)
            @php
                $avisExistant = App\Models\Avis::where('reservation_id', $reservation->id)->first();
            @endphp
            <div class="border rounded-lg p-3 md:p-4 reservation-item" 
                 data-statut="{{ $reservation->statut }}"
                 data-trajet-statut="{{ $reservation->trajet->statut }}"
                 data-date="{{ date('Y-m-d', strtotime($reservation->date_reservation)) }}">
                <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                    <div class="flex-1 w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-2">
                            <div class="flex items-center space-x-3">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $reservation->statut == 'confirmee' ? 'bg-green-100 text-green-700' : 
                                       ($reservation->statut == 'annulee' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                    @if($reservation->statut == 'confirmee') Confirmee
                                    @elseif($reservation->statut == 'annulee') Annulee
                                    @else En attente
                                    @endif
                                </span>
                            </div>
                            <div class="text-left sm:text-right">
                                <div class="font-bold text-blue-600 text-base md:text-xl">{{ number_format($reservation->prix_total, 2) }} DH</div>
                                <div class="text-xs text-gray-500">{{ date('d/m/Y H:i', strtotime($reservation->date_reservation)) }}</div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="text-gray-600 text-xs">Trajet</div>
                                <div class="font-semibold text-sm">
                                    {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}
                                </div>
                                <div class="text-gray-500 text-xs">{{ date('d/m/Y H:i', strtotime($reservation->trajet->date_depart)) }}</div>
                            </div>
                            <div>
                                <div class="text-gray-600 text-xs">Conducteur</div>
                                <div class="font-semibold text-sm">{{ $reservation->trajet->conducteur->utilisateur->nom }}</div>
                                <div class="text-gray-500 text-xs">{{ $reservation->trajet->conducteur->utilisateur->telephone }}</div>
                            </div>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <span class="text-gray-600 text-xs">Places : </span>
                                <span class="font-semibold text-sm">{{ $reservation->nombre_places }}</span>
                            </div>
                            <div class="flex flex-wrap gap-3">
                             @if($reservation->statut == 'confirmee' && strtotime($reservation->trajet->date_depart) > time() && $reservation->trajet->statut != 'termine')
                                <button onclick="ouvrirModalAnnulation({{ $reservation->id }})" class="text-red-600 hover:underline text-xs md:text-sm">Annuler</button>
                            @endif
                                                            
                              @if($avisExistant)
                                <button onclick="ouvrirModalModifierAvis({{ $reservation->id }}, {{ $reservation->trajet->conducteur_id }}, {{ $avisExistant->note }}, '{{ addslashes($avisExistant->commentaire) }}')" 
                                        class="text-blue-600 hover:underline text-xs md:text-sm">
                                    Modifier mon avis
                                </button>
                            @elseif($reservation->trajet->statut == 'termine')
                                <button onclick="ouvrirModalNote({{ $reservation->id }}, {{ $reservation->trajet->conducteur_id }})" 
                                        class="text-yellow-600 hover:underline text-xs md:text-sm">
                                    Noter
                                </button>
                            @endif
                                <a href="/trajet/{{ $reservation->trajet_id }}" class="text-blue-600 hover:underline text-xs md:text-sm">Details</a>
                            </div>
                        </div>
                        
                        @if($avisExistant)
                            <div class="mt-2 pt-2 border-t text-xs text-gray-500">
                                <span class="font-medium">Votre avis :</span>
                                <div class="flex items-center space-x-1 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-xs md:text-sm {{ $i <= $avisExistant->note ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                                @if($avisExistant->commentaire)
                                    <p class="italic mt-1 text-xs">"{{ $avisExistant->commentaire }}"</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- MODAL NOTATION -->
<div id="modalNote" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800" id="modalTitle">Noter le conducteur</h3>
                <p class="text-xs text-gray-500">Partagez votre experience</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-center text-sm">Votre note</label>
                <div class="flex space-x-2 justify-center" id="etoiles">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-note="{{ $i }}" class="etoile text-3xl md:text-4xl text-gray-300 hover:text-yellow-500 transition">★</button>
                    @endfor
                </div>
                <input type="hidden" id="noteValue" value="0">
                <input type="hidden" id="reservationId" value="">
                <input type="hidden" id="conducteurId" value="">
                <input type="hidden" id="isEdit" value="0">
                <input type="hidden" id="avisId" value="">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 text-sm">Votre commentaire (optionnel)</label>
                <textarea id="commentaire" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 text-sm" 
                          placeholder="Dites ce que vous avez pense du trajet..."></textarea>
            </div>
        </div>
        <div class="flex border-t">
            <button onclick="fermerModalNote()" class="flex-1 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-bl-xl transition text-sm">
                Annuler
            </button>
            <button onclick="soumettreNote()" class="flex-1 px-4 py-3 bg-blue-500 text-white hover:bg-blue-600 rounded-br-xl transition text-sm">
                Envoyer
            </button>
        </div>
    </div>
</div>

<!-- MODAL ANNULATION -->
<div id="modalAnnulation" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Annuler la reservation</h3>
            <p class="text-gray-600 text-sm mb-2">Etes-vous sur de vouloir annuler cette reservation ?</p>
            <p class="text-xs text-gray-400">Cette action est irreversible.</p>
            <input type="hidden" id="annulationReservationId" value="">
        </div>
        <div class="flex border-t">
            <button onclick="fermerModalAnnulation()" class="flex-1 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-bl-xl transition text-sm">Non, retour</button>
            <button onclick="confirmerAnnulation()" class="flex-1 px-4 py-3 bg-red-500 text-white hover:bg-red-600 rounded-br-xl transition text-sm">Oui, annuler</button>
        </div>
    </div>
</div>

<script>
let noteSelectionnee = 0;

function filtrerHistorique() {
    const statutFiltre = document.getElementById('filtreStatut').value;
    const date = document.getElementById('filtreDate').value;
    
    document.querySelectorAll('.reservation-item').forEach(item => {
        let show = true;
        const reservationStatut = item.dataset.statut;
        const trajetStatut = item.dataset.trajetStatut;
        
        if(statutFiltre !== 'all') {
            if(statutFiltre === 'termine') {
                if(trajetStatut !== 'termine') show = false;
            } else {
                if(reservationStatut !== statutFiltre) show = false;
            }
        }
        if(date && item.dataset.date !== date) show = false;
        item.style.display = show ? 'block' : 'none';
    });
}

function afficherMessage(message, type) {
    const ancienMessage = document.getElementById('flashMessage');
    if(ancienMessage) ancienMessage.remove();
    
    const msgDiv = document.createElement('div');
    msgDiv.id = 'flashMessage';
    msgDiv.className = `fixed top-20 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300 text-sm`;
    msgDiv.style.transform = 'translateX(100%)';
    msgDiv.innerHTML = `<div class="flex items-center space-x-2">${type === 'success' ? '✓' : '✗'}<span>${message}</span></div>`;
    document.body.appendChild(msgDiv);
    setTimeout(() => { msgDiv.style.transform = 'translateX(0)'; }, 10);
    setTimeout(() => { msgDiv.style.opacity = '0'; setTimeout(() => msgDiv.remove(), 300); }, 3000);
}

// ANNULATION
function ouvrirModalAnnulation(id) {
    document.getElementById('annulationReservationId').value = id;
    document.getElementById('modalAnnulation').classList.remove('hidden');
    document.getElementById('modalAnnulation').classList.add('flex');
}

function fermerModalAnnulation() {
    document.getElementById('modalAnnulation').classList.add('hidden');
    document.getElementById('modalAnnulation').classList.remove('flex');
}

function confirmerAnnulation() {
    const id = document.getElementById('annulationReservationId').value;
    fetch(`/reservation/annuler/${id}`, {
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(response => {
        if(response.ok) {
            fermerModalAnnulation();
            afficherMessage('Reservation annulee avec succes !', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            afficherMessage('Erreur lors de l\'annulation', 'error');
        }
    })
    .catch(() => afficherMessage('Erreur de connexion', 'error'));
}

//NOTATION
document.querySelectorAll('.etoile').forEach(etoile => {
    etoile.addEventListener('click', function() {
        noteSelectionnee = parseInt(this.dataset.note);
        document.getElementById('noteValue').value = noteSelectionnee;
        document.querySelectorAll('.etoile').forEach((e, index) => {
            if(index < noteSelectionnee) {
                e.classList.remove('text-gray-300');
                e.classList.add('text-yellow-500');
            } else {
                e.classList.remove('text-yellow-500');
                e.classList.add('text-gray-300');
            }
        });
    });
});

function ouvrirModalNote(reservationId, conducteurId) {
    document.getElementById('modalTitle').innerHTML = 'Noter le conducteur';
    document.getElementById('reservationId').value = reservationId;
    document.getElementById('conducteurId').value = conducteurId;
    document.getElementById('noteValue').value = 0;
    document.getElementById('commentaire').value = '';
    document.getElementById('isEdit').value = 0;
    document.getElementById('avisId').value = '';
    noteSelectionnee = 0;
    
    document.querySelectorAll('.etoile').forEach(e => {
        e.classList.remove('text-yellow-500');
        e.classList.add('text-gray-300');
    });
    
    document.getElementById('modalNote').classList.remove('hidden');
    document.getElementById('modalNote').classList.add('flex');
}

function ouvrirModalModifierAvis(reservationId, conducteurId, note, commentaire) {
    document.getElementById('modalTitle').innerHTML = 'Modifier mon avis';
    document.getElementById('reservationId').value = reservationId;
    document.getElementById('conducteurId').value = conducteurId;
    document.getElementById('noteValue').value = note;
    document.getElementById('commentaire').value = commentaire;
    document.getElementById('isEdit').value = 1;
    noteSelectionnee = note;
    
    document.querySelectorAll('.etoile').forEach((e, index) => {
        if(index < note) {
            e.classList.remove('text-gray-300');
            e.classList.add('text-yellow-500');
        } else {
            e.classList.remove('text-yellow-500');
            e.classList.add('text-gray-300');
        }
    });
    
    document.getElementById('modalNote').classList.remove('hidden');
    document.getElementById('modalNote').classList.add('flex');
}

function fermerModalNote() {
    document.getElementById('modalNote').classList.add('hidden');
    document.getElementById('modalNote').classList.remove('flex');
}

function soumettreNote() {
    const note = document.getElementById('noteValue').value;
    const reservationId = document.getElementById('reservationId').value;
    const commentaire = document.getElementById('commentaire').value;
    const isEdit = document.getElementById('isEdit').value;
    
    if(note == 0) {
        afficherMessage('Veuillez selectionner une note', 'error');
        return;
    }
    
    const url = isEdit == 1 ? `/avis/modifier/${reservationId}` : `/conducteur/noter/${reservationId}`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            note: note,
            commentaire: commentaire
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            afficherMessage(isEdit == 1 ? 'Avis modifie avec succes !' : 'Note envoyee avec succes !', 'success');
            fermerModalNote();
            setTimeout(() => location.reload(), 1000);
        } else {
            afficherMessage((data.error || 'Erreur'), 'error');
        }
    })
    .catch(() => afficherMessage('Erreur de connexion', 'error'));
}

// Fermer modales
document.getElementById('modalAnnulation').addEventListener('click', function(e) { if(e.target === this) fermerModalAnnulation(); });
document.getElementById('modalNote').addEventListener('click', function(e) { if(e.target === this) fermerModalNote(); });
</script>
@endsection