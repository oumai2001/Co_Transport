@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/image.png') }}"
         class="w-full h-full object-cover" />

    <div class="absolute inset-0"></div>
</div>
      
        <div class="relative px-8 py-12 md:py-16 text-center">
            
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                CoTransport
            </h1>
            <p class="text-lg md:text-xl font-bold text-white mb-8 max-w-2xl mx-auto">
                La solution simple, économique et écologique pour partager vos trajets
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/register" 
                   class="group inline-flex items-center justify-center gap-2 bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    S'inscrire gratuitement
                </a>
                <a href="/trajets" 
                   class="group inline-flex items-center justify-center gap-2 bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-400 hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Rechercher un trajet
                </a>
            </div>
        </div>
    </div>

    <!-- Avantages -->
    <div class="grid md:grid-cols-3 gap-6 mb-12">
        <!-- Économique -->
<div class="group bg-black rounded-xl p-6 text-center border-4 border-white shadow-xl shadow-black/20 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-white">Économique</h3>
            <p class="text-white leading-relaxed">Partagez vos frais de route et réalisez jusqu'à 70% d'économies sur vos déplacements quotidiens.</p>
        </div>

        <!-- Confiance -->
      <div class="group bg-black  rounded-xl p-6 text-center border-4 border-white shadow-xl shadow-black/20 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-white">Confiance</h3>
            <p class="text-white leading-relaxed">Système de notation et d'avis vérifiés pour voyager en toute sérénité avec des membres de confiance.</p>
        </div>

        <!-- Sécurisé -->
<div class="group bg-black  rounded-xl p-6 text-center border-4 border-white shadow-xl shadow-black/20 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-white">Sécurisé</h3>
            <p class="text-white leading-relaxed">Paiement 100% sécurisé et traçable. Une équipe de support disponible 7j/7 pour vous accompagner.</p>
        </div>
    </div>

    <!-- Comment ça marche -->
<div id="comment-ca-marche"
     class="bg-black  border-2 border-white rounded-2xl p-8 mb-12 shadow-2xl ">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-10 text-white">
            Comment ça marche ?
        </h2>
        
        <div class="grid md:grid-cols-4 gap-6">
            <!-- Étape 1 -->
            <div class="text-center group">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-7 h-7 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">1</div>
                </div>
                <h3 class="font-bold text-lg mb-1  text-white">Inscription</h3>
                <p class="text-sm  text-white">Créez votre compte gratuitement en 2 minutes</p>
            </div>

            <!-- Étape 2 -->
            <div class="text-center group">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-7 h-7 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">2</div>
                </div>
                <h3 class="font-bold text-lg mb-1  text-white">Recherche</h3>
                <p class="text-sm  text-white">Trouvez un trajet qui correspond à vos besoins</p>
            </div>

            <!-- Étape 3 -->
            <div class="text-center group">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-7 h-7 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">3</div>
                </div>
                <h3 class="font-bold text-lg mb-1  text-white">Réservation</h3>
                <p class="text-sm  text-white">Réservez votre place en quelques clics</p>
            </div>

            <!-- Étape 4 -->
            <div class="text-center group">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-7 h-7 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">4</div>
                </div>
                <h3 class="font-bold text-lg mb-1  text-white">Voyage</h3>
                <p class="text-sm  text-white">Profitez de votre trajet en toute sérénité</p>
            </div>
        </div>
    

</div>
@endsection
