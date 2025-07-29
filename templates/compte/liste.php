
<div class="my-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Comptes secondaires créés</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        var_dump($_SESSION['comptes']);
        $hasSecondaire = false;
        if (!empty($_SESSION['comptes'])):
            foreach ($_SESSION['comptes'] as $compte):
                if (trim($compte->getTypecompte()) === 'CompteSecondaire'):
                    $hasSecondaire = true;
        ?>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border border-gray-100">
                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700 mb-1">N° <?= htmlspecialchars($compte->getNumero()) ?></div>
                <div class="text-gray-500 mb-2"><?= htmlspecialchars($compte->getSolde()) ?> FCFA</div>
                <span class="inline-block bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">Secondaire</span>
            </div>
        <?php
                endif;
            endforeach;
        endif;
        if (!$hasSecondaire):
        ?>
            <div class="col-span-2 text-center text-gray-400 text-lg">Aucun compte secondaire créé.</div>
        <?php endif; ?>
    </div>
</div>