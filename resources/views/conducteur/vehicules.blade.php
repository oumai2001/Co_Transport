@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-0">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Mes vehicules</h2>
        
        <!-- Formulaire d'ajout -->
        <form method="POST" action="/conducteur/vehicule" class="border-b pb-6 mb-6">
            @csrf
            <h3 class="font-bold text-base md:text-lg mb-4">Ajouter un vehicule</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="immatriculation" placeholder="Immatriculation" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm md:text-base">
                </div>
                <div>
                    <input type="text" name="marque" placeholder="Marque" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm md:text-base">
                </div>
                <div>
                    <input type="text" name="modele" placeholder="Modele" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm md:text-base">
                </div>
                <div>
                    <input type="number" name="capacite" placeholder="Capacite (places)" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm md:text-base">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm md:text-base">
                Ajouter le vehicule
            </button>
        </form>
        
        <!-- Liste des vehicules -->
        <div class="space-y-4">
            @forelse($vehicules as $vehicule)
                <div class="border rounded-lg p-3 md:p-4 hover:shadow-md transition" id="vehicule-{{ $vehicule->id }}">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                        <div class="flex-1 w-full">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="font-bold text-base md:text-lg">{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $vehicule->statut == 'disponible' ? 'bg-green-100 text-green-700' : 
                                       ($vehicule->statut == 'maintenance' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $vehicule->statut }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs md:text-sm text-gray-600">
                                <div>Immatriculation : {{ $vehicule->immatriculation }}</div>
                                <div>Capacite : {{ $vehicule->capacite }} places</div>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button onclick="openEditModal({{ $vehicule->id }}, '{{ $vehicule->statut }}')" 
                                    class="flex-1 md:flex-none text-blue-600 hover:text-blue-800 text-sm px-3 py-1 rounded border border-blue-200 hover:bg-blue-50">
                                Modifier
                            </button>
                            <button onclick="openDeleteModal({{ $vehicule->id }}, '{{ $vehicule->marque }} {{ $vehicule->modele }}')" 
                                    class="flex-1 md:flex-none text-red-600 hover:text-red-800 text-sm px-3 py-1 rounded border border-red-200 hover:bg-red-50">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-sm md:text-base">Aucun vehicule enregistre</p>
                    <p class="text-xs text-gray-400 mt-1">Ajoutez votre premier vehicule pour commencer</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal MODIFIER STATUT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">Modifier le statut</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4 text-sm md:text-base">Choisissez le nouveau statut du vehicule :</p>
            <div class="space-y-3">
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <input type="radio" name="edit_statut" value="disponible" class="w-4 h-4 text-green-600">
                    <span class="ml-3">
                        <span class="font-medium text-green-700">Disponible</span>
                        <span class="text-xs text-gray-500 block">Le vehicule peut etre utilise pour les trajets</span>
                    </span>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-yellow-50 transition">
                    <input type="radio" name="edit_statut" value="en_trajet" class="w-4 h-4 text-yellow-600">
                    <span class="ml-3">
                        <span class="font-medium text-yellow-700">En trajet</span>
                        <span class="text-xs text-gray-500 block">Le vehicule est actuellement en route</span>
                    </span>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-red-50 transition">
                    <input type="radio" name="edit_statut" value="maintenance" class="w-4 h-4 text-red-600">
                    <span class="ml-3">
                        <span class="font-medium text-red-700">Maintenance</span>
                        <span class="text-xs text-gray-500 block">Le vehicule est en reparation</span>
                    </span>
                </label>
            </div>
            <input type="hidden" id="edit_vehicule_id" value="">
        </div>
        <div class="flex justify-end space-x-3 p-4 border-t bg-gray-50 rounded-b-xl">
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </button>
            <button onclick="confirmEdit()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Confirmer
            </button>
        </div>
    </div>
</div>

<!-- Modal SUPPRIMER -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-bold text-red-600">Supprimer le vehicule</h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center">
                <p class="text-gray-700 mb-2 text-sm md:text-base">Etes-vous sur de vouloir supprimer ce vehicule ?</p>
                <p class="text-sm text-gray-500" id="delete_vehicule_nom"></p>
                <p class="text-xs text-red-500 mt-2">Cette action est irreversible</p>
            </div>
            <input type="hidden" id="delete_vehicule_id" value="">
        </div>
        <div class="flex justify-end space-x-3 p-4 border-t bg-gray-50 rounded-b-xl">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </button>
            <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Oui, supprimer
            </button>
        </div>
    </div>
</div>

<script>
let currentVehiculeId = null;

// MODIFIER
function openEditModal(id, currentStatut) {
    currentVehiculeId = id;
    document.getElementById('edit_vehicule_id').value = id;
    
    const radios = document.querySelectorAll('input[name="edit_statut"]');
    radios.forEach(radio => {
        if(radio.value === currentStatut) {
            radio.checked = true;
        }
    });
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
    currentVehiculeId = null;
}

function confirmEdit() {
    const selectedRadio = document.querySelector('input[name="edit_statut"]:checked');
    if(!selectedRadio) {
        alert('Veuillez selectionner un statut');
        return;
    }
    
    const nouveauStatut = selectedRadio.value;
    const id = document.getElementById('edit_vehicule_id').value;
    
    fetch(`/conducteur/vehicule/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ statut: nouveauStatut })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            closeEditModal();
            location.reload();
        } else {
            alert('Erreur lors de la modification');
        }
    })
    .catch(() => alert('Erreur de connexion'));
}

// SUPPRIMER
function openDeleteModal(id, nom) {
    currentVehiculeId = id;
    document.getElementById('delete_vehicule_id').value = id;
    document.getElementById('delete_vehicule_nom').innerText = nom;
    
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    currentVehiculeId = null;
}

function confirmDelete() {
    const id = document.getElementById('delete_vehicule_id').value;
    
    fetch(`/conducteur/vehicule/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            closeDeleteModal();
            location.reload();
        } else {
            alert('Erreur lors de la suppression');
        }
    })
    .catch(() => alert('Erreur de connexion'));
}

// Fermer les modales en cliquant a l'exterieur
document.getElementById('editModal').addEventListener('click', function(e) {
    if(e.target === this) closeEditModal();
});
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if(e.target === this) closeDeleteModal();
});
</script>
@endsection