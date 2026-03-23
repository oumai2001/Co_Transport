@extends('layouts.app')

@section('content')
<div class="space-y-6 px-4 md:px-0">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Mes statistiques</h2>
        <div class="text-xs md:text-sm text-gray-500">
            Derniere mise a jour : {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-3 md:p-5 text-white">
            <div class="text-xs md:text-sm opacity-90">Total trajets</div>
            <div class="text-xl md:text-3xl font-bold">{{ $stats['total_trajets'] ?? 0 }}</div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-3 md:p-5 text-white">
            <div class="text-xs md:text-sm opacity-90">Passagers transportes</div>
            <div class="text-xl md:text-3xl font-bold">{{ $stats['total_passagers'] ?? 0 }}</div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-3 md:p-5 text-white">
            <div class="text-xs md:text-sm opacity-90">Gains totaux</div>
            <div class="text-xl md:text-3xl font-bold">
                {{ number_format($stats['gains_totaux'] ?? 0, 0) }} DH
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-3 md:p-5 text-white">
            <div class="text-xs md:text-sm opacity-90">Note moyenne</div>
            <div class="text-xl md:text-3xl font-bold">
                {{ number_format($stats['note_moyenne'] ?? 0, 1) }}/5
            </div>
        </div>

    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4 text-sm md:text-base">Trajets par mois</h3>
            <canvas id="trajetsChart" style="min-height: 250px;"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <h3 class="font-bold text-gray-700 mb-4 text-sm md:text-base">Gains par mois</h3>
            <canvas id="gainsChart" style="min-height: 250px;"></canvas>
        </div>

    </div>

    <!-- Villes -->
    @if(!empty($villes_depart) && !empty($villes_arrivee))
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6">

        <h3 class="font-bold text-gray-700 mb-4 text-sm md:text-base">Villes les plus frequentees</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Depart -->
            <div>
                <h4 class="text-xs md:text-sm font-semibold text-gray-600 mb-3">Departs frequents</h4>

                <div class="space-y-3">
                    @foreach($villes_depart as $ville)
                        <div class="flex justify-between items-center">

                            <span class="text-sm">{{ $ville->nom }}</span>

                            <div class="flex items-center space-x-2">

                                <div class="w-24 md:w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full"
                                         style="width: {{ $stats['total_trajets'] > 0 ? ($ville->total / $stats['total_trajets']) * 100 : 0 }}%">
                                    </div>
                                </div>

                                <span class="text-xs md:text-sm">{{ $ville->total }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Arrivee -->
            <div>
                <h4 class="text-xs md:text-sm font-semibold text-gray-600 mb-3">Arrivees frequentes</h4>

                <div class="space-y-3">
                    @foreach($villes_arrivee as $ville)
                        <div class="flex justify-between items-center">

                            <span class="text-sm">{{ $ville->nom }}</span>

                            <div class="flex items-center space-x-2">

                                <div class="w-24 md:w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full"
                                         style="width: {{ $stats['total_trajets'] > 0 ? ($ville->total / $stats['total_trajets']) * 100 : 0 }}%">
                                    </div>
                                </div>

                                <span class="text-xs md:text-sm">{{ $ville->total }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    @endif

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Trajets chart
    const trajetsCtx = document.getElementById('trajetsChart');

    @if(isset($trajets_par_mois))
    new Chart(trajetsCtx, {
        type: 'line',
        data: {
            labels: @json($trajets_par_mois['mois'] ?? []),
            datasets: [{
                label: 'Trajets',
                data: @json($trajets_par_mois['counts'] ?? []),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    @endif

    // Gains chart
    const gainsCtx = document.getElementById('gainsChart');

    @if(isset($gains_par_mois))
    new Chart(gainsCtx, {
        type: 'bar',
        data: {
            labels: @json($gains_par_mois['mois'] ?? []),
            datasets: [{
                label: 'Gains (DH)',
                data: @json($gains_par_mois['montants'] ?? []),
                backgroundColor: '#22c55e',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (DH)'
                    }
                }
            }
        }
    });
    @endif

});
</script>

@endsection