@extends('layouts.app')

@section('content')

<div style="background:white; border-radius:10px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="font-size:22px; font-weight:bold; margin-bottom:20px;">
        Mes conducteurs favoris
    </h2>

    <div id="favorisList" style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        @forelse($favoris as $favori)
            <div id="favori-{{ $favori->id }}" style="border:1px solid #ddd; border-radius:10px; padding:15px;">
                
                <div style="display:flex; align-items:center; margin-bottom:10px;">
                    <div style="
                        width:40px; height:40px;
                        background:#dbeafe;
                        border-radius:50%;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-weight:bold;
                        color:#2563eb;
                        margin-right:10px;
                    ">
                        {{ substr(optional($favori->conducteur)->utilisateur->nom ?? '', 0, 2) }}
                    </div>

                    <div>
                        <div style="font-weight:bold;">
                            {{ optional($favori->conducteur)->utilisateur->nom }}
                        </div>
                        <div style="font-size:12px; color:gray;">
                            {{ optional($favori->conducteur)->utilisateur->telephone }}
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:10px;">
                    <a href="{{ url('/trajets?conducteur_id='.$favori->conducteur_id) }}"
                       style="background:#2563eb; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">
                        Voir ses trajets
                    </a>

                    <button onclick="openModal({{ $favori->id }})"
                            style="color:red; border:none; background:none; cursor:pointer;">
                        Supprimer
                    </button>
                </div>

            </div>
        @empty
            <div style="grid-column:span 2; text-align:center; color:gray;">
                Aucun favori
            </div>
        @endforelse
    </div>
</div>

<!-- 🔴 MODAL -->
<div id="confirmModal" style="
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.5);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
">
    <div style="
        background:white;
        padding:20px;
        border-radius:10px;
        width:300px;
        text-align:center;
    ">
        <p style="margin-bottom:20px; font-weight:bold;">
            Êtes-vous sûr de supprimer ce favori ?
        </p>

        <div style="display:flex; justify-content:center; gap:10px;">
            <button onclick="confirmDelete()" style="background:red; color:white; padding:6px 12px; border:none; border-radius:5px;">
                Oui
            </button>

            <button onclick="closeModal()" style="background:gray; color:white; padding:6px 12px; border:none; border-radius:5px;">
                Annuler
            </button>
        </div>
    </div>
</div>

<!-- 🔔 TOAST -->
<div id="toast" style="
    position: fixed;
    top: 80px;
    right: 20px;
    background: #333;
    color: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    display: none;
    z-index: 9999;
">
    <span id="toast-message"></span>
</div>

<script>
let currentId = null;

// 🔴 ouvrir modal
function openModal(id) {
    currentId = id;
    document.getElementById('confirmModal').style.display = "flex";
}

// ❌ fermer modal
function closeModal() {
    document.getElementById('confirmModal').style.display = "none";
}

// 🔥 confirmer suppression
function confirmDelete() {
    fetch('/favori/supprimer/' + currentId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('favori-' + currentId).remove();
            showToast('✓ Favori supprimé', true);
        } else {
            showToast('✗ ' + data.message, false);
        }
        closeModal();
    })
    .catch(() => {
        showToast('Erreur serveur', false);
        closeModal();
    });
}

// 🔔 toast
function showToast(message, success = true) {
    const toast = document.getElementById('toast');
    const msg = document.getElementById('toast-message');

    msg.textContent = message;
    toast.style.background = success ? "#16a34a" : "#dc2626";
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
}
</script>

@endsection