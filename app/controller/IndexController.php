<?php

class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('index');
    }
    public function era()
    {
        $this->view->render('era');
    }
    public function kontakt()
    {
        $this->view->render('kontakt');
    }
    public function login()
    {
        $this->loginView('','');
    }
    public function logout()
    {
        unset($_SESSION['autoriziran']);
        session_destroy();
        $this->index();
    }
    public function autorizacija()
    {
        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return;
        }

        if(strlen(trim($_POST['email']))===0){
            $this->loginView('','Obavezno email');
            return;
        }
        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView($_POST['email'],'Obavezno lozinka');
            return;
        }

        if(!($_POST['email']==='edunova@edunova.hr' &&
            $_POST['lozinka']==='e') ){
                $this->loginView($_POST['email'],'Neispravna kombinacija emaila i lozinke');
                return;
        }

        $_SESSION['autoriziran']='Edunova Korisnik';
        $np = new NadzornaplocaController();
        $np->index();
    }

    private function loginView($email,$poruka)
    {
        $this->view->render('login',[
            'email'=>$email,
            'poruka'=>$poruka
        ]);
    }

    /*
    public function test()
    {
        echo password_hash('o',PASSWORD_BCRYPT);
    }
    */
}