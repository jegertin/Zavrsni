<?php

class UslugaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'usluga'
                        . DIRECTORY_SEPARATOR;
    private $usluga=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'usluge'=>Usluga::ucitajSve()
        ]);
    }

    public function novo()
    {
            if($_SERVER['REQUEST_METHOD']==='GET'){
                $this->novaUsluga();
                return;
            }
            $this->usluga = (object) $_POST;
            if(!$this->kontrolaNaziv()){return;}
            if(!$this->kontrolaCijena()){return;}
            Usluga::dodajNovu($this->usluga);
            $this->index();

    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
            }
            $this->usluga = Usluga::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }

        $this->usluga = (object) $_POST;
        if(!$this->kontrolaNaziv()){return;}
        if(!$this->kontrolaCijena()){return;}
        Usluga::promjeniPostojecu($this->usluga);
        $this->index();

    }

    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
        }
        Usluga::obrisiPostojecu($_GET['sifra']);
        header('location: ' . App::config('url') . 'usluga/index');
        
    }

    private function novaUsluga()
    {
        $this->usluga = new stdClass();
            $this->usluga->naziv='';
            $this->usluga->cijena='';
            $this->poruka='Unesite tražene podatke';
            $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'usluga'=>$this->usluga,
            'poruka'=>$this->poruka
        ]);
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'usluga'=>$this->usluga,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrolaNaziv()
    {
        if(strlen(trim($this->usluga->naziv))===0){
            $this->poruka='Naziv obavezno';
            $this->novoView();
            return false;
        }

        if(strlen(trim($this->usluga->naziv))>50){
            $this->poruka='Naziv ne može imati više od 50 znakova';
            $this->novoView();
            return false;
        }
    return true;
    }

    private function kontrolaCijena()
    {
        $this->usluga->cijena=str_replace(',','.',$this->usluga->cijena);
        if(!is_numeric($this->usluga->cijena)
            || ((float)$this->usluga->cijena)<=0){
                $this->poruka='Cijena mora biti pozitivan broj';
                $this->novoView();
            return false;
            }
    return true;
    }
}