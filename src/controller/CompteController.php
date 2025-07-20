<?php

namespace App\Controller;
use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Core\Validator;
use App\Service\SecurityService;
use App\Core\ImageService;
use App\Service\CompteService;
use App\Service\TransactionService;

class CompteController extends AbstractController{

    private Validator $validator;
    private SecurityService $securityService;
    private CompteService $compteService;
private TransactionService $transactionService;
    private ImageService $imageService;
    

    public function __construct(){
           parent::__construct();
          $this->validator = App::getDependency('validator');
          $this->securityService = App::getDependency('securityServ');
          $this->imageService = App::getDependency('imageServ');
          $this->compteService = \App\Core\App::getDependency('compteServ');
            $this->transactionService = App::getDependency('transactionServ');
    }
     public function index(){

        $user_id = $this->session->get('user')['id'];
       $compte=$this->compteService->getCompteByUserId($user_id);
        $transaction = $this->transactionService->getTransactionsByUserId($user_id);
       
        $this->render("compte/home.php", ['compte' => $compte , 'transaction' => $transaction]);
     }
     public function create(){
        $this->layout = 'security';
        $this->render('compte/form.principal.php');
     }
     public function store(){}
     public function edit(){}
    // abstract public function destroy();
    public function show(){
    
    }
  
public function createCompteEpargne(){
    $this->render('compte/form2.php');
}



public function createComptePrincipal() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $files = $_FILES;

        $this->validator->isEmpty('nom', $data['nom']);
        $this->validator->isEmpty('prenom', $data['prenom']);
        $this->validator->isEmpty('login', $data['login']);
        $this->validator->isEmpty('password', $data['password']);
        $this->validator->isEmpty('adresse', $data['adresse']);
        $this->validator->isEmpty('numero', $data['numero']);
        $this->validator->isEmpty('numeroCarteIdentite', $data['numeroCarteIdentite']);

        $photoPath = '';
        var_dump($_FILES);
        die;
        try {
    $uploads = ImageService::uploadMultipleImages([
        'photoRecto' => $_FILES['photoRecto'],
        'photoVerso' => $_FILES['photoVerso']
    ], __DIR__ . '/../../public/images/uploads/');

    $photoPath = json_encode([
        'recto' => $uploads['photoRecto']['url'],
        'verso' => $uploads['photoVerso']['url']
    ]);
} catch (\Exception $e) {
    $this->validator->addError('photoIdentite', $e->getMessage());
}


        

        if ($this->validator->isValid()) {
            $userData = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'login' => $data['login'],
                // 'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'adresse' => $data['adresse'],
                'numeros' => $data['numeros'],
                'numeroCNI' => $data['numeroCNI'],
                'photoIdentite' => $photoPath,
                'type_user_id' => 3,
            ];

            $compteData = []; 

            $result = $this->securityService->creerComptePrincipal($userData, $compteData);
            if ($result === true) {
                header("Location: ".$_ENV['APP_URL']."/");
                exit;
            } else {
                $this->session->set('errors', ['compte' => $result]);
            }
        } else {
            $this->session->set('errors', $this->validator->getErrors());
        }
        $this->layout = 'security';
        $this->render("compte/form.principal.php");
    } else {
        $this->layout = 'security';

        $this->render("compte/form.principal.php");
    }
}

 

}