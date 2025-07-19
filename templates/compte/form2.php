
<body class="bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen p-4">
    <!-- Header -->
    <div class="text-center text-white mb-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-3 drop-shadow-lg">📋 Maxit Board</h1>
        <p class="text-lg md:text-xl opacity-90">Gestion des numéros et soldes</p>
    </div>

    <!-- Board Container -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Carte Formulaire -->
        <div class="bg-gray-50 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="bg-green-500 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold text-center">➕ Ajouter un Enregistrement</h2>
            </div>
            
            <div class="p-6">
                <form method="post" action="#" class="space-y-6">
                    <!-- Champ Numéro -->
                    <div>
                        <label for="numero" class="block text-sm font-semibold text-gray-700 mb-2">
                            📱 Numéro
                        </label>
                        <input 
                            type="text" 
                            id="numero" 
                            name="numero" 
                            placeholder="Ex: 77 123 45 67" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        >
                    </div>

                    <!-- Champ Solde -->
                    <div>
                        <label for="solde" class="block text-sm font-semibold text-gray-700 mb-2">
                            💰 Solde (FCFA)
                        </label>
                        <input 
                            type="number" 
                            id="solde" 
                            name="solde" 
                            placeholder="Ex: 25000" 
                            step="0.01" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        >
                    </div>

                    <!-- Boutons -->
                    <div class="flex gap-3">
                        <button 
                            type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition-all duration-200 hover:-translate-y-0.5"
                        >
                            Ajouter
                        </button>
                        <button 
                            type="reset" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-md transition-all duration-200 hover:-translate-y-0.5"
                        >
                            Effacer
                        </button>
                    </div>
                </form>

                <!-- Labels -->
                <div class="flex gap-2 mt-6">
                    <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">Actif</span>
                    <span class="bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded">Formulaire</span>
                    <span class="bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">Maxit</span>
                </div>
            </div>
        </div>

        <!-- Carte Instructions -->
        <div class="bg-gray-50 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="bg-orange-500 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold text-center">ℹ️ Instructions</h2>
            </div>
            
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="text-green-500 font-bold text-lg mr-3">✓</span>
                        <span class="text-gray-700">Saisissez le numéro de téléphone</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 font-bold text-lg mr-3">✓</span>
                        <span class="text-gray-700">Entrez le solde en FCFA</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 font-bold text-lg mr-3">✓</span>
                        <span class="text-gray-700">Cliquez sur "Ajouter" pour valider</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-green-500 font-bold text-lg mr-3">✓</span>
                        <span class="text-gray-700">Utilisez "Effacer" pour vider les champs</span>
                    </li>
                </ul>

                <!-- Note -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mt-6">
                    <p class="text-yellow-800 text-sm">
                        <strong>Note :</strong> Assurez-vous que le numéro est au format correct et que le solde est un montant valide.
                    </p>
                </div>

                <!-- Labels -->
                <div class="flex gap-2 mt-6">
                    <span class="bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded">Guide</span>
                    <span class="bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">Aide</span>
                </div>
            </div>
        </div>

        <!-- Carte Exemples -->
        <div class="bg-gray-50 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="bg-red-500 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold text-center">📝 Exemples</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <!-- Exemple 1 -->
                <div class="bg-white p-4 rounded-md border-l-4 border-red-500">
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">Numéro Standard</h4>
                    <p class="text-gray-600 text-sm">77 123 45 67 - Format classique</p>
                </div>

                <!-- Exemple 2 -->
                <div class="bg-white p-4 rounded-md border-l-4 border-red-500">
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">Solde Typique</h4>
                    <p class="text-gray-600 text-sm">25000 - Vingt-cinq mille FCFA</p>
                </div>

                <!-- Exemple 3 -->
                <div class="bg-white p-4 rounded-md border-l-4 border-red-500">
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">Solde avec Décimales</h4>
                    <p class="text-gray-600 text-sm">12500.50 - Avec centimes</p>
                </div>

                <!-- Labels -->
                <div class="flex gap-2 mt-6">
                    <span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">Exemples</span>
                    <span class="bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">Référence</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section supplémentaire pour plus de fonctionnalités -->
    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-gray-50 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">🎯 Actions Rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-6 rounded-md transition-colors">
                    📊 Voir Statistiques
                </button>
                <button class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-md transition-colors">
                    📋 Exporter Données
                </button>
                <button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-6 rounded-md transition-colors">
                    🔄 Synchroniser
                </button>
            </div>
        </div>
    </div>
