       <div class="bg-black w-64 flex-shrink-0">
            <div class="flex flex-col h-full">
                <!-- User Profile -->
                <div class="p-6 border-b border-gray-600">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">papa tall</h3>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Items -->
                <nav class="flex-1 p-4">
                    <div class="space-y-2">
                        <a href="/addCompte" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-3 transition-colors">
                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">+</span>
                            </div>
                            <span>Nouveau</span>
                        </a>
                    </div>
                </nav>
                
                <!-- Account Switch -->
                <div class="p-4 border-t border-gray-600">
                    <button class="w-full text-left text-orange-500 border border-orange-500 rounded-lg px-4 py-2 hover:bg-orange-500 hover:text-white transition-colors">
                        Changer de compte
                    </button>
                </div>
                
                <!-- Logout -->
                <div class="p-4">
                    <button class="flex items-center space-x-3 text-gray-300 hover:text-white w-full p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <a href="/logout">Deconnexion</a>
                    </button>
                </div>
            </div>
        </div>