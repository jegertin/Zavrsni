<?php

class DjelatnikController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'djelatnik'
                        . DIRECTORY_SEPARATOR;
    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Djelatnik::ucitajSve()
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->noviEntitet();
            return;
        }
        $this->entitet = (object) $_POST;
        if(!$this->kontrolaOib()){return;}
        if(!$this->kontrolaIban()){return;}
        Djelatnik::dodajNovog($this->entitet);
        $this->index();
    }

    private function kontrolaOib() {
        $oib = trim($this->entitet->oib);
        if(strlen($oib) !== 11 || !is_numeric($oib)){
            $this->poruka='OIB mora imati 11 brojki';
            $this->noviEntitet();
            return false;
        }

        $ostatak = 10;
        for ( $i = 0; $i < 10; $i++ ) {
            $broj = (int) $oib[$i];
   
            $zbroj = $broj + $ostatak;
   
            $meduOstatak = $zbroj % 10;
            if ( $meduOstatak == 0) {
               $meduOstatak = 10;
            }
   
            $umnozak = $meduOstatak * 2;
   
            $ostatak = $umnozak % 11;
        }
   
        if ($ostatak == 1) {
            $kontrolnaZnamenka = 0;
        } else {
            $kontrolnaZnamenka = 11 - $ostatak;
        }

        if (((int) $oib[10]) == $kontrolnaZnamenka) {
            return true;
        }

        $this->poruka='OIB neispravan';
        $this->noviEntitet();
        
        return false;
    }

    private function kontrolaIban()
    {
        $iban = trim($this->entitet->iban);
        if(strlen($iban) !== 21){
            $this->poruka='IBAN mora imati 21 znak';
            $this->noviEntitet();
            return false;
        }

        if (is_numeric($iban[0]) || is_numeric($iban[1])) {
            $this->poruka = 'IBAN mora početi sa kodom države';
            $this->noviEntitet();
            return false;
        }

        if (!is_numeric(substr($iban, 2))) {
            $this->poruka = 'Neispravan IBAN';
            $this->noviEntitet();
            return false;
        }

        return true;
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
            }
            $this->entitet = Djelatnik::ucitaj($_GET['sifra']);
            if (!$this->poruka) {
                $this->poruka='Promjenite željene podatke';
            }
            $this->promjenaView();
            return;
        }

        $this->entitet = (object) $_POST;
        if(!$this->kontrolaOib()){return;}
        if(!$this->kontrolaIban()){return;}
        Djelatnik::promjeniPostojeci($this->entitet);
        $this->index();

    }

    private function noviEntitet()
    {
        if (!$this->entitet) {
            $this->entitet = new stdClass();
            $this->entitet->ime='';
            $this->entitet->prezime='';
            $this->entitet->oib='';
            $this->entitet->email='';
            $this->entitet->iban='';    
        }
        if (!$this->poruka) {
            $this->poruka='Unesite tražene podatke';
        }
        $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
        }
        Djelatnik::obrisiPostojeceg($_GET['sifra']);
        header('location: ' . App::config('url') . 'djelatnik/index');
        
    }
    

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }
}