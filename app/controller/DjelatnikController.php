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

            Djelatnik::dodajNovog($this->entitet);
            $this->index();

    }

    private function noviEntitet()
    {
            $this->entitet = new stdClass();
            $this->entitet->ime='';
            $this->entitet->prezime='';
            $this->entitet->oib='';
            $this->entitet->email='';
            $this->entitet->iban='';
            $this->poruka='Unesite tražene podatke';
            $this->novoView();
    }

    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }
    
}