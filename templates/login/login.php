
    <!-- Container principal -->
    <div class="relative min-h-screen flex flex-col">
        
        <!-- Section image avec overlay -->
        <div class="relative flex-1">
            <img 
                src="./tall.jpeg"
                alt="Femme souriante au téléphone"
                class="w-full h-[50vh] md:h-[60vh] object-cover"
                onerror="this.src='https://via.placeholder.com/1000x600/4a5568/ffffff?text=Image+de+connexion'"
            />
            
            <!-- Overlay gradient -->
            <div class="absolute inset-0 image-overlay"></div>
        </div>

        <!-- Section formulaire -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-4 py-8 form-container">
            
            <!-- Indicateurs de progression -->
            <div class="flex space-x-3 ">
                <div class="h-1 w-8 bg-white rounded-full progress-bar"></div>
                <div class="h-1 w-6 bg-white/40 rounded-full progress-bar"></div>
                <div class="h-1 w-6 bg-white/40 rounded-full progress-bar"></div>
                <div class="h-1 w-6 bg-white/40 rounded-full progress-bar"></div>
            </div>

            <!-- Formulaire de connexion -->
            <form class="space-y-6" action="login" method="post">
             <div class="w-full max-w-md mx-auto">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Login
                            </label>
                            <input 
                                type="tel" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-200 bg-gray-50"
                                placeholder="Entrez votre login"
                                name="login"
                            >
                            <?php if(!empty($_SESSION['errors']['email'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['email']; ?> <p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe
                            </label>
                            <input 
                                type="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-200 bg-gray-50"
                                placeholder="Entrez votre mot de passe"
                                name="password"
                            >
                            <?php if(!empty($_SESSION['errors']['password'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['password']; ?> <p>
                            </div>
                            <?php endif; ?>
                        </div>
 <p class="text-gray-600">
                            Vous n'avez pas de compte ? 
                            <a href="/comptePrincipal" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200">
                                Créer un compte
                            </a>
                <!-- Bouton Suivant -->
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 disabled:from-gray-600 disabled:to-gray-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 btn-hover btn-active shadow-lg shadow-orange-500/25 disabled:cursor-not-allowed"
                  
                >
                    <span id="btnText">Suivant</span>
                    <span id="btnLoader" class="hidden">
                        <svg class="loading-spinner inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Connexion...
                    </span>
                </button>

             
            </div>
            </form>
        </div>
    </div>

  

    
