@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Statistiques</h2>
    </div>
    
    <!-- Cartes statistiques - Desktop -->
    <div class="hidden md:grid md:grid-cols-4 gap-4">
        <div class="bg-blue-500 rounded-lg p-4 text-white text-center">
            <div class="text-2xl font-bold">{{ $stats['total_passagers'] ?? 0 }}</div>
            <div class="text-sm">Passagers</div>
        </div>
        <div class="bg-green-500 rounded-lg p-4 text-white text-center">
            <div class="text-2xl font-bold">{{ $stats['total_conducteurs'] ?? 0 }}</div>
            <div class="text-sm">Conducteurs</div>
        </div>
        <div class="bg-purple-500 rounded-lg p-4 text-white text-center">
            <div class="text-2xl font-bold">{{ $stats['total_trajets'] ?? 0 }}</div>
            <div class="text-sm">Trajets</div>
        </div>
        <div class="bg-yellow-500 rounded-lg p-4 text-white text-center">
            <div class="text-2xl font-bold">{{ number_format($stats['chiffre_affaires_total'] ?? 0, 0) }} DH</div>
            <div class="text-sm">CA total</div>
        </div>
    </div>

    <!-- Cartes statistiques - Mobile -->
    <div class="grid grid-cols-2 gap-3 md:hidden">
        <div class="bg-blue-500 rounded-lg p-3 text-white text-center">
            <div class="text-xl font-bold">{{ $stats['total_passagers'] ?? 0 }}</div>
            <div class="text-xs">Passagers</div>
        </div>
        <div class="bg-green-500 rounded-lg p-3 text-white text-center">
            <div class="text-xl font-bold">{{ $stats['total_conducteurs'] ?? 0 }}</div>
            <div class="text-xs">Conducteurs</div>
        </div>
        <div class="bg-purple-500 rounded-lg p-3 text-white text-center">
            <div class="text-xl font-bold">{{ $stats['total_trajets'] ?? 0 }}</div>
            <div class="text-xs">Trajets</div>
        </div>
        <div class="bg-yellow-500 rounded-lg p-3 text-white text-center">
            <div class="text-xl font-bold">{{ number_format($stats['chiffre_affaires_total'] ?? 0, 0) }} DH</div>
            <div class="text-xs">CA total</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="font-bold mb-4">Evolution des utilisateurs</h3>
            <div class="w-full overflow-x-auto">
                <canvas id="usersChart" height="200" style="min-width: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Graphique chiffre d'affaires -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="font-bold mb-4">Chiffre d'affaires mensuel</h3>
            <div class="w-full overflow-x-auto">
                <canvas id="revenueChart" height="200" style="min-width: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Graphique répartition des trajets -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="font-bold mb-4">Repartition des trajets</h3>
            <div class="w-full overflow-x-auto">
                <canvas id="trajetsChart" height="200" style="min-width: 300px;"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 text-sm">
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span> Programmes: {{ $stats['trajets_programmes'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span> En cours: {{ $stats['trajets_en_cours'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span> Termines: {{ $stats['trajets_termines'] ?? 0 }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span> Annules: {{ $stats['trajets_annules'] ?? 0 }}</div>
            </div>
        </div>
        
        <!-- Top conducteurs -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="font-bold mb-4">Top 5 conducteurs</h3>
            <div class="space-y-2">
                @if(isset($top_conducteurs) && count($top_conducteurs) > 0)
                    @foreach($top_conducteurs as $index => $c)
                        <div class="flex justify-between items-center p-2 border-b">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                <span>{{ $c['nom'] ?? $c->nom ?? 'N/A' }}</span>
                            </div>
                            <span class="font-bold">{{ $c['trajets_count'] ?? $c->trajets_count ?? 0 }} trajets</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-4">Aucun conducteur</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Donnees pour les graphiques
const chartMonths = {!! isset($chart_months) ? json_encode($chart_months) : json_encode([]) !!};
const chartPassagers = {!! isset($chart_passagers) ? json_encode($chart_passagers) : json_encode([]) !!};
const chartConducteurs = {!! isset($chart_conducteurs) ? json_encode($chart_conducteurs) : json_encode([]) !!};
const chartRevenues = {!! isset($chart_revenues) ? json_encode($chart_revenues) : json_encode([]) !!};

// Graphique utilisateurs
if(document.getElementById('usersChart') && chartMonths.length > 0) {
    new Chart(document.getElementById('usersChart'), {
        type: 'line',
        data: {
            labels: chartMonths,
            datasets: [
                {
                    label: 'Passagers',
                    data: chartPassagers,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Conducteurs',
                    data: chartConducteurs,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } }
            }
        }
    });
}

// Graphique revenus
if(document.getElementById('revenueChart') && chartMonths.length > 0) {
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: chartMonths,
            datasets: [{
                label: 'CA (DH)',
                data: chartRevenues,
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: '#22c55e',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { y: { beginAtZero: true, title: { display: true, text: 'Montant (DH)', font: { size: 11 } } } },
            plugins: { legend: { labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });
}

// Graphique trajets
if(document.getElementById('trajetsChart')) {
    new Chart(document.getElementById('trajetsChart'), {
        type: 'doughnut',
        data: {
            labels: ['Programmes', 'En cours', 'Termines', 'Annules'],
            datasets: [{
                data: [
                    {{ $stats['trajets_programmes'] ?? 0 }},
                    {{ $stats['trajets_en_cours'] ?? 0 }},
                    {{ $stats['trajets_termines'] ?? 0 }},
                    {{ $stats['trajets_annules'] ?? 0 }}
                ],
                backgroundColor: ['#3b82f6', '#10b981', '#9ca3af', '#ef4444']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });
}
</script>
@endsection