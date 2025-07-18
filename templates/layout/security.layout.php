<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion par Téléphone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animation personnalisée pour le bouton */
        .btn-hover:hover {
            transform: scale(1.02);
        }
        .btn-active:active {
            transform: scale(0.98);
        }
        
        /* Animation pour les indicateurs */
        .progress-bar {
            transition: all 0.3s ease;
        }
        
        /* Effet de focus personnalisé */
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.5);
        }

        /* Animation de chargement */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Overlay gradient sur l'image */
        .image-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.8));
        }

        /* Amélioration responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-black min-h-screen overflow-hidden">

<main class="p-6">
 <?php echo  $contentForLayout ?>
    </main>
</body> 

</html>