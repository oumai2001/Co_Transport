@extends('layouts.app')

@section('content')
<div class="space-y-6 px-4 md:px-0">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
        <h2 class="text-xl md:text-2xl font-bold">Mes avis</h2>
        <div class="text-sm text-gray-500">
            {{ $avisStats['total'] }} avis reçus
        </div>
    </div>

    <!-- STATS -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Moyenne -->
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-bold text-yellow-500">
                    {{ number_format($avisStats['moyenne'], 1) }}
                </div>
                <div class="text-xs md:text-sm text-gray-500">sur 5</div>

                <div class="flex justify-center mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-xl md:text-2xl {{ $i <= round($avisStats['moyenne']) ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                    @endfor
                </div>
            </div>

            <!-- Répartition -->
            <div class="space-y-2">
                @for($note = 5; $note >= 1; $note--)
                    <div class="flex items-center space-x-2">
                        <div class="w-8 md:w-10 text-xs md:text-sm">{{ $note }}★</div>

                        <div class="flex-1 bg-gray-200 h-2 rounded-full">
                            <div class="bg-yellow-500 h-2 rounded-full"
                                style="width: {{ $avisStats['total'] > 0
                                    ? (($avisStats['repartition'][$note] ?? 0) / $avisStats['total']) * 100
                                    : 0 }}%">
                            </div>
                        </div>

                        <div class="w-8 md:w-10 text-xs md:text-sm text-gray-600 text-right">
                            {{ $avisStats['repartition'][$note] ?? 0 }}
                        </div>
                    </div>
                @endfor
            </div>

        </div>
    </div>

    <!-- LISTE -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <div class="p-3 md:p-4 border-b bg-gray-50">
            <h3 class="font-bold text-gray-700 text-sm md:text-base">Tous les avis reçus</h3>
        </div>

        <div class="divide-y">
            @forelse($avis as $a)
                <div class="p-3 md:p-4 hover:bg-gray-50">

                    <div class="flex justify-between flex-wrap gap-2">

                        <div>

                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="font-bold text-blue-600 text-xs md:text-sm">
                                        {{ substr($a->passager->utilisateur->nom ?? '??', 0, 2) }}
                                    </span>
                                </div>

                                <div>
                                    <div class="font-medium text-sm md:text-base">
                                        {{ $a->passager->utilisateur->nom ?? 'Passager' }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        {{ $a->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- stars -->
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm md:text-base {{ $i <= $a->note ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>

                            @if($a->commentaire)
                                <p class="text-xs md:text-sm text-gray-600 mt-2">
                                    "{{ $a->commentaire }}"
                                </p>
                            @endif

                        </div>

                        <div class="text-xs text-gray-400">
                            {{ $a->created_at->diffForHumans() }}
                        </div>

                    </div>

                </div>
            @empty
                <div class="text-center py-10 text-gray-500 text-sm">
                    Aucun avis pour le moment
                </div>
            @endforelse
        </div>

        @if(method_exists($avis, 'links'))
            <div class="p-3 md:p-4 border-t">
                {{ $avis->links() }}
            </div>
        @endif

    </div>

</div>
@endsection