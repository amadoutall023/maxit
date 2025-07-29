

<div class="flex h-screen"> 
        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-[100%] h-screen overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-semibold text-gray-800">Tableau de bord</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher" class="w-80 bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        <button class="sidebar-toggle w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                <div class="max-w-4xl mx-auto">
                    <!-- Balance Card -->
                    <div class="balance-card rounded-2xl p-8 mb-8 relative overflow-hidden">
                        <div class=" bg-[url('tall1.png')] bg-no-repeat bg-cover  absolute inset-0"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">A</span>
                                    </div>
                                    <div>
                                        <select class="bg-white bg-opacity-90 border border-gray-300 rounded-full px-4 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500">
                                            <option><a href="/comptePrincipal">Principale</a></option>
                                            <option><a href="/addCompte">Epargne</a></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                 <span class="text-3xl font-bold text-gray-800">
    <?= isset($comptes[0]) ? $comptes[0]->getSolde() : 0; ?> FCFA
</span>
                                </div>
                            </div>
                            
                            <button class="text-orange-600 font-medium flex items-center space-x-2 hover:text-orange-700 transition-colors">
                                <span>Voir l'historique</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <button class="action-button bg-white rounded-xl p-8 shadow-sm border border-gray-100 hover:border-orange-200 transition-all">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-800 text-lg">Transfert</span>
                            </div>
                        </button>
                        
                        <button class="action-button bg-white rounded-xl p-8 shadow-sm border border-gray-100 hover:border-orange-200 transition-all">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-800 text-lg">Paiement</span>
                            </div>
                        </button>
                    </div>
                    
                    <!-- Transaction History -->
                 <div class="max-h-96 overflow-y-auto divide-y divide-gray-100">

<div class="max-h-96 overflow-y-auto divide-y divide-gray-100">

<?php if (!empty($transactions)): ?>
    <?php foreach (array_slice($transactions, 0, 4) as $transaction): ?>
        <div class="transaction-item p-6 rounded-lg mx-3 my-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800 text-lg"><?= htmlspecialchars($transaction->getCompteId()) ?></div>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($transaction->getTypetransaction()) ?></div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($transaction->getMontant()) ?> FCFA</div>
                    <div class="text-sm text-gray-500"><?= htmlspecialchars($transaction->getDate()) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="p-6 text-gray-500">Aucune transaction trouvée.</div>
<?php endif; ?>

</div>
                      
                        
                  
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>