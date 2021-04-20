<?php

class RacunController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'racun'
                        . DIRECTORY_SEPARATOR;
    private $racun=null;
    private $vrsteUsluga=[];
    private $vrstePapira=[];
    private $djelatnici=[];
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'racuni'=>Racun::ucitajSve()
        ]);
    }

    public function novo()
    {
            if($_SERVER['REQUEST_METHOD']==='GET'){
                $this->noviRacun();
                return;
            }
            $this->racun = (object) $_POST;
            if(!$this->kontrolaKlijent()){return;}
            Racun::dodajNovi($this->racun);
            $this->index();
    }

    // public function promjena()
    // {
    //     if($_SERVER['REQUEST_METHOD']==='GET'){
    //         if(!isset($_GET['sifra'])){
    //             $ic = new IndexController();
    //             $ic->logout();
    //             return;
    //         }
    //         $this->usluga = Usluga::ucitaj($_GET['sifra']);
    //         $this->poruka='Promjenite željene podatke';
    //         $this->promjenaView();
    //         return;
    //     }

    //     $this->usluga = (object) $_POST;
    //     if(!$this->kontrolaNaziv()){return;}
    //     if(!$this->kontrolaCijena()){return;}
    //     Usluga::promjeniPostojecu($this->usluga);
    //     $this->index();

    // }

    // public function brisanje()
    // {
    //     if(!isset($_GET['sifra'])){
    //             $ic = new IndexController();
    //             $ic->logout();
    //             return;
    //     }
    //     Usluga::obrisiPostojecu($_GET['sifra']);
    //     header('location: ' . App::config('url') . 'usluga/index');
        
    // }

    private function noviRacun()
    {
            $this->racun = new stdClass();
            $this->racun->klijent = '';
            $this->djelatnici = Djelatnik::ucitajSve();
            $this->vrsteUsluga = Usluga::ucitajSve();
            $this->vrstePapira = Papir::ucitajSve();
            $this->poruka='Unesite tražene podatke';
            $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'racun'=>$this->racun,
            'poruka'=>$this->poruka,
            'djelatnici'=>$this->djelatnici,
            'vrsteUsluga'=>$this->vrsteUsluga,
            'vrstePapira'=>$this->vrstePapira
        ]);
    }

    // private function promjenaView()
    // {
    //     $this->view->render($this->viewDir . 'promjena',[
    //         'usluga'=>$this->usluga,
    //         'poruka'=>$this->poruka
    //     ]);
    // }

    private function kontrolaKlijent()
    {
        if(strlen(trim($this->racun->klijent))===0){
            $this->poruka='Naziv obavezno';
            $this->novoView();
            return false;
        }

        if(strlen(trim($this->racun->klijent))>50){
            $this->poruka='Naziv ne može imati više od 50 znakova';
            $this->novoView();
            return false;
        }
        return true;
    }

    // private function kontrolaCijena()
    // {
    //     $this->usluga->cijena=str_replace(',','.',$this->usluga->cijena);
    //     if(!is_numeric($this->usluga->cijena)
    //         || ((float)$this->usluga->cijena)<=0){
    //             $this->poruka='Cijena mora biti pozitivan broj';
    //             $this->novoView();
    //         return false;
    //         }
    // return true;
    // }
}