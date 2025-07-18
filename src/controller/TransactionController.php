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
          $this->validator = App::getDependency('core','validator');
          $this->securityService = App::getDependency('services', 'securityServ');
          $this->imageService = App::getDependency('core', 'imageServ');
          $this->compteService = \App\Core\App::getDependency('services', 'compteServ');
          $this->transactionService = App::getDependency('services', 'transactionServ');

    }

     public function index(){

        $user_id = $this->session->get('user')['id'];
     
        $transaction = $this->transactionService->selectByClient($user_id);
        $this->render("compte/home.php", ['transaction' => $transaction]);
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
}
