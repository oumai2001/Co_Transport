@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 md:p-6 overflow-x-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
        <h2 class="text-xl md:text-2xl font-bold"> Gestion des passagers</h2>
        <button onclick="ouvrirModalAjout()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm whitespace-nowrap">
            + Ajouter
        </button>
    </div>
    
    <!-- Messages flash -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Version Desktop: tableau -->
    <div class="overflow-x-auto -mx-4 md:mx-0 hidden md:block">
        <table class="min-w-[700px] md:min-w-full w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">ID</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Nom</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Email</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Téléphone</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Statut</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs md:text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="passagersTableBody">
                @forelse($passagers as $passager)
                    <tr class="border-t hover:bg-gray-50" id="passager-row-{{ $passager->id }}">
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $passager->id }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm font-medium">{{ $passager->utilisateur->nom ?? 'N/A' }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $passager->utilisateur->email ?? 'N/A' }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">{{ $passager->utilisateur->telephone ?? 'N/A' }}</td>
                        <td class="px-3 md:px-4 py-2 text-sm">
                            <span class="statut-badge inline-block px-2 py-1 text-xs rounded-full min-w-[70px] text-center {{ $passager->est_bloque ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $passager->est_bloque ? 'Bloqué' : 'Actif' }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 text-sm">
                            <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                <button onclick="bloquerPassager({{ $passager->id }})" class="btn-bloquer text-yellow-600 hover:text-yellow-800 text-sm">
                                    {{ $passager->est_bloque ? 'Débloquer' : 'Bloquer' }}
                                </button>
                                <button onclick="supprimerPassager({{ $passager->id }})" class="text-red-600 hover:text-red-800 text-sm">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">Aucun passager trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Version Mobile: cartes -->
    <div class="md:hidden space-y-4" id="passagersMobileList">
        @forelse($passagers as $passager)
            <div class="border rounded-lg p-4 bg-white shadow-sm" id="passager-mobile-{{ $passager->id }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="font-bold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $passager->utilisateur->nom ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $passager->utilisateur->email ?? 'N/A' }}
                        </div>
                    </div>
                    <span class="statut-badge-mobile px-2 py-1 text-xs rounded-full {{ $passager->est_bloque ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $passager->est_bloque ? 'Bloqué' : 'Actif' }}
                    </span>
                </div>
                
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                    </svg>
                    ID: {{ $passager->id }}
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $passager->utilisateur->telephone ?? 'N/A' }}
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $passager->points_fidelite ?? 0 }} points
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button onclick="bloquerPassager({{ $passager->id }})" class="flex-1 btn-bloquer-mobile text-yellow-600 border border-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-50 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        {{ $passager->est_bloque ? 'Débloquer' : 'Bloquer' }}
                    </button>
                    <button onclick="supprimerPassager({{ $passager->id }})" class="flex-1 text-red-600 border border-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-50 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">Aucun passager trouvé</div>
        @endforelse
    </div>
</div>

<!-- MODAL AJOUT PASSAGER -->
<div id="modalAjoutPassager" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-bold text-gray-800"> Ajouter un passager</h3>
            <button onclick="fermerModalAjout()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="formAjoutPassager" method="POST" action="{{ route('admin.passager.ajouter') }}">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nom complet</label>
                    <input type="text" name="nom" id="nom_passager" required class="w-full px-3 py-2 border rounded-lg">
                    @error('nom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email_passager" required class="w-full px-3 py-2 border rounded-lg">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone_passager" required class="w-full px-3 py-2 border rounded-lg">
                    @error('telephone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password_passager" required class="w-full px-3 py-2 border rounded-lg">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
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

document.getElementById('formAjoutPassager')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '⏳...';
    btn.disabled = true;
    
    fetch('{{ route("admin.passager.ajouter") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showFlashMessage(data.message, 'success');
            fermerModalAjout();
            setTimeout(() => location.reload(), 1000);
        } else {
            showFlashMessage(data.error || 'Erreur lors de l\'ajout', 'error');
        }
    })
    .catch(() => showFlashMessage('Erreur de connexion', 'error'))
    .finally(() => { 
        btn.innerHTML = originalText; 
        btn.disabled = false; 
    });
});

function bloquerPassager(id) {
    if(confirm('Confirmer le changement de statut ?')) {
        fetch(`/admin/passager/${id}/bloquer`, { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            } 
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showFlashMessage(data.error || 'Erreur', 'error');
            }
        })
        .catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}

function supprimerPassager(id) {
    if(confirm('Supprimer définitivement ce passager ? Cette action est irréversible.')) {
        fetch(`/admin/passager/${id}`, { 
            method: 'DELETE', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            } 
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showFlashMessage(data.message, 'success');
                document.getElementById(`passager-row-${id}`)?.remove();
                document.getElementById(`passager-mobile-${id}`)?.remove();
                
                // Vérifier s'il reste des passagers
                const tbody = document.getElementById('passagersTableBody');
                if(tbody && tbody.children.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-500">Aucun passager trouvé</td></tr>';
                }
                const mobileList = document.getElementById('passagersMobileList');
                if(mobileList && mobileList.children.length === 0) {
                    mobileList.innerHTML = '<div class="text-center py-8 text-gray-500">Aucun passager trouvé</div>';
                }
            } else {
                showFlashMessage(data.error || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(() => showFlashMessage('Erreur de connexion', 'error'));
    }
}

function ouvrirModalAjout() { 
    document.getElementById('modalAjoutPassager').classList.remove('hidden'); 
    document.getElementById('modalAjoutPassager').classList.add('flex'); 
}

function fermerModalAjout() { 
    document.getElementById('modalAjoutPassager').classList.add('hidden'); 
    document.getElementById('modalAjoutPassager').classList.remove('flex'); 
    document.getElementById('formAjoutPassager')?.reset();
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('modalAjoutPassager')?.addEventListener('click', function(e) { 
    if(e.target === this) fermerModalAjout(); 
});
</script>
@endsection