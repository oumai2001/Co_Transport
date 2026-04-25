@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6 overflow-x-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
        <h2 class="text-xl md:text-2xl font-bold"> Gestion des conducteurs</h2>
        <button onclick="ouvrirModalAjout()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm whitespace-nowrap">
            + Ajouter
        </button>
    </div>
    
    <!-- Version Desktop -->
    <div class="overflow-x-auto -mx-4 md:mx-0 hidden md:block">
        <table class="min-w-[700px] md:min-w-full w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">ID</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Nom</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Email</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Téléphone</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Permis</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Note</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Trajets</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Statut</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="conducteursTableBody">
                @foreach($conducteurs as $conducteur)
                    <tr class="border-t hover:bg-gray-50" id="conducteur-row-{{ $conducteur->id }}">
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $conducteur->id }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm font-medium">{{ $conducteur->utilisateur->nom }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $conducteur->utilisateur->email }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $conducteur->utilisateur->telephone }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $conducteur->numero_permis }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm {{ $i <= round($conducteur->note_moyenne ?? 0) ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ number_format($conducteur->note_moyenne ?? 0, 1) }})</span>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 text-sm text-center">{{ $conducteur->trajets_count ?? 0 }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">
                            <span class="statut-badge inline-block px-2 py-1 text-xs rounded-full min-w-[70px] text-center {{ $conducteur->est_bloque ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $conducteur->est_bloque ? 'Bloqué' : 'Actif' }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 text-sm">
                            <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                <button onclick="bloquerConducteur({{ $conducteur->id }})" class="btn-bloquer text-yellow-600 hover:text-yellow-800 text-sm">
                                    {{ $conducteur->est_bloque ? 'Débloquer' : 'Bloquer' }}
                                </button>
                                <button onclick="supprimerConducteur({{ $conducteur->id }})" class="text-red-600 hover:text-red-800 text-sm">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Version Mobile-->
    <div class="md:hidden space-y-4" id="conducteursMobileList">
        @foreach($conducteurs as $conducteur)
            <div class="border rounded-lg p-4 bg-white shadow-sm" id="conducteur-mobile-{{ $conducteur->id }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="font-bold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $conducteur->utilisateur->nom }}
                        </div>
                        <div class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $conducteur->utilisateur->email }}
                        </div>
                    </div>
                    <span class="statut-badge-mobile px-2 py-1 text-xs rounded-full {{ $conducteur->est_bloque ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $conducteur->est_bloque ? 'Bloqué' : 'Actif' }}
                    </span>
                </div>
                
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                    </svg>
                    ID: {{ $conducteur->id }} | Permis: {{ $conducteur->numero_permis }}
                </div>
                
                <div class="flex items-center space-x-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-sm {{ $i <= round($conducteur->note_moyenne ?? 0) ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                    @endfor
                    <span class="text-xs text-gray-500 ml-1">({{ number_format($conducteur->note_moyenne ?? 0, 1) }})</span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $conducteur->utilisateur->telephone }}
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        {{ $conducteur->trajets_count ?? 0 }} trajets
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button onclick="bloquerConducteur({{ $conducteur->id }})" class="flex-1 btn-bloquer-mobile text-yellow-600 border border-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-50 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        {{ $conducteur->est_bloque ? 'Débloquer' : 'Bloquer' }}
                    </button>
                    <button onclick="supprimerConducteur({{ $conducteur->id }})" class="flex-1 text-red-600 border border-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-50 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer
                    </button>
                </div>
            </div>
        @endforeach
        @if(isset($conducteurs) && count($conducteurs) == 0)
            <div class="text-center py-8 text-gray-500">Aucun conducteur trouvé</div>
        @endif
    </div>
    
    @if(isset($conducteurs) && count($conducteurs) == 0)
        <div class="text-center py-8 text-gray-500 hidden md:block" id="emptyMessage">
            Aucun conducteur trouvé
        </div>
    @endif
</div>

<!-- MODAL AJOUT CONDUCTEUR -->
<div id="modalAjoutConducteur" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-bold text-gray-800"> Ajouter un conducteur</h3>
            <button onclick="fermerModalAjout()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="formAjoutConducteur" method="POST" action="/admin/conducteur/ajouter">
            @csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-gray-700 mb-2">Nom complet</label><input type="text" name="nom" id="nom_conducteur" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><label class="block text-gray-700 mb-2">Email</label><input type="email" name="email" id="email_conducteur" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><label class="block text-gray-700 mb-2">Téléphone</label><input type="tel" name="telephone" id="telephone_conducteur" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><label class="block text-gray-700 mb-2">Numéro de permis</label><input type="text" name="numero_permis" id="permis_conducteur" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><label class="block text-gray-700 mb-2">Mot de passe</label><input type="password" name="password" id="password_conducteur" required class="w-full px-3 py-2 border rounded-lg"></div>
            </div>
            <div class="flex justify-end space-x-3 p-4 border-t bg-gray-50 rounded-b-xl">
                <button type="button" onclick="fermerModalAjout()" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<script>
function showFlashMessage(message, type) {
    const container = document.querySelector('.fixed.top-20 .w-full.max-w-md');
    if(!container) return;
    const flashDiv = document.createElement('div');
    flashDiv.className = `mb-3 p-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white rounded-lg shadow-lg flex justify-between items-center flash-message`;
    flashDiv.innerHTML = `<div class="flex items-center space-x-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path></svg><span>${message}</span></div><button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>`;
    container.prepend(flashDiv);
    setTimeout(() => { flashDiv.style.opacity = '0'; setTimeout(() => flashDiv.remove(), 300); }, 4000);
}

document.getElementById('formAjoutConducteur')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '⏳...';
    btn.disabled = true;
    fetch('/admin/conducteur/ajouter', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showFlashMessage(data.message, 'success');
            fermerModalAjout();
            location.reload();
        } else showFlashMessage(data.error || 'Erreur', 'error');
    })
    .catch(() => showFlashMessage('Erreur de connexion', 'error'))
    .finally(() => { btn.innerHTML = originalText; btn.disabled = false; });
});

function bloquerConducteur(id) {
    if(confirm('Confirmer le changement de statut ?')) {
        fetch(`/admin/conducteur/${id}/bloquer`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' } })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                location.reload();
            } else showFlashMessage(data.error || 'Erreur', 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}

function supprimerConducteur(id) {
    if(confirm('Supprimer définitivement ce conducteur ?')) {
        fetch(`/admin/conducteur/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' } })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                document.getElementById(`conducteur-row-${id}`)?.remove();
                document.getElementById(`conducteur-mobile-${id}`)?.remove();
            } else showFlashMessage(data.error || 'Erreur', 'error');
        }).catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}

function ouvrirModalAjout() { document.getElementById('modalAjoutConducteur').classList.remove('hidden'); document.getElementById('modalAjoutConducteur').classList.add('flex'); }
function fermerModalAjout() { document.getElementById('modalAjoutConducteur').classList.add('hidden'); document.getElementById('modalAjoutConducteur').classList.remove('flex'); }
function escapeHtml(text) { const div = document.createElement('div'); div.textContent = text; return div.innerHTML; }
document.getElementById('modalAjoutConducteur').addEventListener('click', function(e) { if(e.target === this) fermerModalAjout(); });
</script>
@endsection