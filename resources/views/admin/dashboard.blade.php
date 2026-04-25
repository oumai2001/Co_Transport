@extends('layouts.app')

@section('content')

<!-- CONTENT -->
<div class="md:col-span-4 space-y-6">

    <!-- Statistiques principales - Desktop -->
    <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-90">Total Utilisateurs</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_utilisateurs'] ?? 0 }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-sm opacity-75">
                <span>+12% ce mois</span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-90">Total Trajets</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_trajets'] ?? 0 }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-sm opacity-75">
                <span>{{ $stats['trajets_programmes'] ?? 0 }} programmes</span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-90">Reservations</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_reservations'] ?? 0 }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-sm opacity-75">
                <span>{{ $stats['reservations_confirmees'] ?? 0 }} confirmees</span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-90">Chiffre d'affaires</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($stats['chiffre_affaires_total'] ?? 0, 0) }} DH</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-sm opacity-75">
                <span>+{{ number_format($stats['evolution_ca'] ?? 0, 1) }}% ce mois</span>
            </div>
        </div>
    </div>

    <!-- Cartes Statistiques - Mobile -->
    <div class="grid grid-cols-2 gap-3 md:hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-3 text-white text-center">
            <div class="text-lg font-bold">{{ $stats['total_utilisateurs'] ?? 0 }}</div>
            <div class="text-xs">Utilisateurs</div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-3 text-white text-center">
            <div class="text-lg font-bold">{{ $stats['total_trajets'] ?? 0 }}</div>
            <div class="text-xs">Trajets</div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-3 text-white text-center">
            <div class="text-lg font-bold">{{ $stats['total_reservations'] ?? 0 }}</div>
            <div class="text-xs">Reservations</div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-3 text-white text-center">
            <div class="text-lg font-bold">{{ number_format($stats['chiffre_affaires_total'] ?? 0, 0) }} DH</div>
            <div class="text-xs">CA total</div>
        </div>
    </div>

    <!-- Deuxieme ligne de statistiques - Desktop -->
    <div class="hidden md:grid md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total_passagers'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Passagers</div>
            <div class="text-xs text-green-500 mt-1">+{{ $stats['nouveaux_passagers_mois'] ?? 0 }} ce mois</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['total_conducteurs'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Conducteurs</div>
            <div class="text-xs text-green-500 mt-1">+{{ $stats['nouveaux_conducteurs_mois'] ?? 0 }} ce mois</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $stats['trajets_mois'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Trajets ce mois</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ number_format($stats['panier_moyen'] ?? 0, 2) }} DH</div>
            <div class="text-sm text-gray-500">Panier moyen</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ number_format($stats['note_moyenne_globale'] ?? 0, 1) }}/5</div>
            <div class="text-sm text-gray-500">Note moyenne</div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4">Evolution des inscriptions</h3>
            <div class="overflow-x-auto">
                <canvas id="usersChart" height="250" style="min-width: 300px;"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4">Evolution du chiffre d'affaires</h3>
            <div class="overflow-x-auto">
                <canvas id="revenueChart" height="250" style="min-width: 300px;"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4">Repartition des trajets</h3>
            <div class="overflow-x-auto">
                <canvas id="trajetsChart" height="250" style="min-width: 300px;"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 text-sm">
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span> Programmes: {{ $stats['trajets_programmes'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span> En cours: {{ $stats['trajets_en_cours'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span> Termines: {{ $stats['trajets_termines'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span> Annules: {{ $stats['trajets_annules'] ?? 0 }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4">Top 5 conducteurs</h3>
            <div class="space-y-3">
                @if(isset($top_conducteurs) && count($top_conducteurs) > 0)
                    @foreach($top_conducteurs as $index => $c)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="font-medium text-sm">{{ $c->nom }}</div>
                                    <div class="text-xs text-gray-500">{{ $c->email }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-blue-600 text-sm">{{ $c->trajets_count ?? 0 }} trajets</div>
                                <div class="text-xs text-gray-500">{{ number_format($c->note_moyenne ?? 0, 1) }} ★</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-8">Aucun conducteur</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <a href="/admin/passagers" class="bg-white rounded-xl shadow-md p-3 md:p-5 hover:shadow-lg transition text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base">Gerer les passagers</h4>
                    <p class="text-xs text-gray-500 hidden md:block">Ajouter, modifier, bloquer</p>
                </div>
            </div>
        </a>

        <a href="/admin/conducteurs" class="bg-white rounded-xl shadow-md p-3 md:p-5 hover:shadow-lg transition text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base">Gerer les conducteurs</h4>
                    <p class="text-xs text-gray-500 hidden md:block">Voir, bloquer, supprimer</p>
                </div>
            </div>
        </a>

        <a href="/admin/trajets" class="bg-white rounded-xl shadow-md p-3 md:p-5 hover:shadow-lg transition text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base">Gerer les trajets</h4>
                    <p class="text-xs text-gray-500 hidden md:block">Valider, supprimer</p>
                </div>
            </div>
        </a>

        <a href="/admin/statistiques" class="bg-white rounded-xl shadow-md p-3 md:p-5 hover:shadow-lg transition text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base">Statistiques avancees</h4>
                    <p class="text-xs text-gray-500 hidden md:block">Rapports detailles</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Dernieres activites -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-700 text-sm md:text-base">Dernieres activites</h3>
            <a href="/admin/reservations" class="text-blue-600 text-xs md:text-sm hover:underline">Voir tout →</a>
        </div>
        <div class="space-y-3">
            @if(isset($dernieres_activites) && count($dernieres_activites) > 0)
                @foreach($dernieres_activites as $activite)
                    <div class="flex items-center justify-between p-2 md:p-3 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full 
                                {{ $activite->type == 'reservation' ? 'bg-green-500' : 
                                   ($activite->type == 'trajet' ? 'bg-blue-500' : 'bg-yellow-500') }}">
                            </div>
                            <div>
                                <p class="text-xs md:text-sm">{{ $activite->description }}</p>
                                <p class="text-xs text-gray-400">{{ $activite->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-8 text-sm">Aucune activite recente</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let usersChart, revenueChart, trajetsChart;

const chartData = {
    months: {!! isset($chart_months) ? json_encode($chart_months) : json_encode(['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec']) !!},
    passagers: {!! isset($chart_passagers) ? json_encode($chart_passagers) : json_encode([0,0,0,0,0,0,0,0,0,0,0,0]) !!},
    conducteurs: {!! isset($chart_conducteurs) ? json_encode($chart_conducteurs) : json_encode([0,0,0,0,0,0,0,0,0,0,0,0]) !!},
    revenues: {!! isset($chart_revenues) ? json_encode($chart_revenues) : json_encode([0,0,0,0,0,0,0,0,0,0,0,0]) !!},
    trajetsStatus: {
        programme: {{ $stats['trajets_programmes'] ?? 0 }},
        en_cours: {{ $stats['trajets_en_cours'] ?? 0 }},
        termine: {{ $stats['trajets_termines'] ?? 0 }},
        annule: {{ $stats['trajets_annules'] ?? 0 }}
    }
};

function initCharts() {
    const ctx1 = document.getElementById('usersChart').getContext('2d');
    usersChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: chartData.months,
            datasets: [
                { label: 'Passagers', data: chartData.passagers, borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', tension: 0.4, fill: true },
                { label: 'Conducteurs', data: chartData.conducteurs, borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', tension: 0.4, fill: true }
            ]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'top' } } }
    });

    const ctx2 = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(ctx2, {
        type: 'bar',
        data: { labels: chartData.months, datasets: [{ label: 'Chiffre d\'affaires (DH)', data: chartData.revenues, backgroundColor: 'rgba(34, 197, 94, 0.5)', borderColor: '#22c55e', borderWidth: 1 }] },
        options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, title: { display: true, text: 'Montant (DH)' } } } }
    });

    const ctx3 = document.getElementById('trajetsChart').getContext('2d');
    trajetsChart = new Chart(ctx3, {
        type: 'doughnut',
        data: { labels: ['Programmes', 'En cours', 'Termines', 'Annules'], datasets: [{ data: [chartData.trajetsStatus.programme, chartData.trajetsStatus.en_cours, chartData.trajetsStatus.termine, chartData.trajetsStatus.annule], backgroundColor: ['#3b82f6', '#10b981', '#9ca3af', '#ef4444'] }] },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } }
    });
}

function updateChart() {
    fetch('/api/stats/users')
        .then(res => res.json())
        .then(data => {
            usersChart.data.datasets[0].data = data.passagers;
            usersChart.data.datasets[1].data = data.conducteurs;
            usersChart.update();
        });
}

document.addEventListener('DOMContentLoaded', function() { initCharts(); });
</script>
@endsection