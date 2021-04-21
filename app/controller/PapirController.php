<?php

class PapirController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'papir'
                        . DIRECTORY_SEPARATOR;
    private $papir=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'papiri'=>Papir::ucitajSve()
        ]);
    }

    public function novo()
    {
            if($_SERVER['REQUEST_METHOD']==='GET'){
                $this->novaPapir();
                return;
            }
            $this->papir = (object) $_POST;
            if(!$this->kontrolaNaziv()){return;}
            Papir::dodajNovi($this->papir);
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
            $this->papir = Papir::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }

        $this->papir = (object) $_POST;
        if(!$this->kontrolaNaziv()){return;}
        Papir::promjeniPostojeci($this->papir);
        $this->index();

    }

    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
        }
        Papir::obrisiPostojeci($_GET['sifra']);
        header('location: ' . App::config('url') . 'papir/index');
        
    }

    private function novaPapir()
    {
            $this->papir = new stdClass();
            $this->papir->vrstapapira='';
            $this->poruka='Unesite tražene podatke';
            $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'papir'=>$this->papir,
            'poruka'=>$this->poruka
        ]);
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'papir'=>$this->papir,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrolaNaziv()
    {
        if(strlen(trim($this->papir->vrstapapira))===0){
            $this->poruka='Naziv obavezno';
            $this->novoView();
            return false;
        }

        if(strlen(trim($this->papir->vrstapapira))>50){
            $this->poruka='Naziv ne može imati više od 50 znakova';
            $this->novoView();
            return false;
        }
        return true;
    }

    private function kontrolaCijena()
    {
        $this->papir->cijena=str_replace(',','.',$this->papir->cijena);
        if(!is_numeric($this->papir->cijena)
            || ((float)$this->papir->cijena)<=0){
                $this->poruka='Cijena mora biti pozitivan broj';
                $this->novoView();
            return false;
            }
    return true;
    }
}