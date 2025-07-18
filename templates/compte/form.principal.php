<body class="main-body bg-[url('tall1.png')] bg-no-repeat bg-cover min-h-screen relative overflow-x-hidden ">
    <!-- Décoration courbe -->
    <div class="curve-decoration"></div>

    <!-- Conteneur principal -->
    <div class="relative z-10 max-w-4xl mx-auto px-4  ">
        
        <!-- En-tête -->
        <div class="text-center mb-1">
            <h1 class="text-4xl font-bold text-gray-800 ">
                <span class="text-orange-500">Max</span> it
            </h1>
            <p class="text-gray-600">Créez votre compte en quelques étapes</p>
        </div>


        <!-- Formulaire -->
        <form id="registrationForm" action="/principalCreated"  method="POST" class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 md:p-12 overflow-hidden">
            
            <!-- Section Informations personnelles -->
            <div class="grid md:grid-cols-2 gap-3 ">
                <div>
                    <label for="firstName" class="block text-sm font-semibold text-gray-700 ">
                        Prénom
                    </label>
                    <input
                        type="text"
                        id="firstName"
                        name="prenom"
                        placeholder="Entrez votre prénom"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                      
                    />
                    <?php if(!empty($_SESSION['errors']['prenom'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['prenom']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>

                <div>
                    <label for="lastName" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom
                    </label>
                    <input
                        type="text"
                        id="lastName"
                        name="nom"
                        placeholder="Entrez votre nom"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                     
                    />
                    <?php if(!empty($_SESSION['errors']['nom'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['nom']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Coordonnées</h3>

                <div class="mb-4">
                    <input
                        type="tel"
                        id="phone"
                        name="numero"
                        placeholder="Entrez votre numéro de téléphone"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                     
                    />
                     <?php if(!empty($_SESSION['errors']['numero'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['numero']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>

                <div>
                    <input
                        type="text"
                        id="address"
                        name="adresse"
                        placeholder="Entrez votre adresse"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                      
                    />
                        <?php if(!empty($_SESSION['errors']['adresse'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['adresse']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>
            </div>

            <!-- Identifiants -->
            <div class="">
                <h3 class="text-lg font-semibold text-gray-800 ">Identifiants de connexion</h3>

                <div class="mb-4">
                    <input
                        type="text"
                        id="login"
                        name="login"
                        placeholder="Entrez un identifiant (login)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                      
                    />
                     <?php if(!empty($_SESSION['errors']['login'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['login']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>

                <div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Entrez un mot de passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                       
                    />
                      <?php if(!empty($_SESSION['errors']['password'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['password']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>
            </div>

            <!-- CNI -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Carte Nationale d'Identité</h3>

                <div class="mb-6">
                    <input
                        type="text"
                        id="cniNumber"
                        name="numeroCarteIdentite"
                        placeholder="Numéro national d'identité"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                       
                    />
                     <?php if(!empty($_SESSION['errors']['numeroCarteIdentite'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['numeroCarteIdentite']; ?> <p>
                            </div>
                            <?php endif; ?>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <div 
                            id="frontUpload"
                            class="drag-drop-area border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer"
                            onclick="document.getElementById('frontFile').click()"
                        >
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600 font-medium mb-2">Drag and Drop or Click To Upload</p>
                            <p class="text-sm text-gray-500">Front</p>
                            <input
                                type="file"
                                id="frontFile"
                                name="photoRecto"
                                class="hidden"
                                accept="image/*"
                               
                            />
                        </div>
                    </div>

                    <div>
                        <div 
                            id="backUpload"
                            class="drag-drop-area border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer"
                            onclick="document.getElementById('backFile').click()"
                        >
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600 font-medium mb-2">Drag and Drop or Click To Upload</p>
                            <p class="text-sm text-gray-500">Back</p>
                            <input
                                type="file"
                                id="backFile"
                                name="photoVerso"
                                class="hidden"
                                accept="image/*"
                             
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div id="errorMessage" class="hidden mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <p class="font-medium">Erreur</p>
                <p id="errorText" class="text-sm mt-1"></p>
            </div>

            <div id="successMessage" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                <p class="font-medium">Succès</p>
                <p id="successText" class="text-sm mt-1">Compte créé avec succès !</p>
            </div>

            <!-- Bouton -->
            <div class="text-center">
                <button
                    type="submit"
                    id="submitBtn"
                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-4 px-12 rounded-full shadow-lg shadow-orange-500/25 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span id="btnText">Créer un compte</span>
                    <span id="btnLoader" class="hidden">
                        <svg class="animate-spin inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Création en cours...
                    </span>
                </button>
            </div>
        </form>
    </div>

  