<?php


class PapirController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'papir'
                        . DIRECTORY_SEPARATOR;
    
    private $entitet=null;
    private $poruka='';
    private $usluge=null;
    private $racuni=null;

    public function __construct()
    {
        parent::__construct();
        $this->usluge=Usluga::ucitajSve();
        
        $s=new stdClass();
        $s->sifra=-1;
        $s->naziv='Odaberite uslugu';
        array_unshift($this->usluge,$s);


        $this->racuni=Racun::ucitajSve();
        $s=new stdClass();
        $s->sifra=-1;
        $s->ime='Odaberite';
        $s->prezime='Račun';
        array_unshift($this->racuni,$s);
    }

    public function index()
    {

        $papiri=Papir::ucitajSve();

        foreach($papiri as $p){
            $p->datumpocetka=date('d.m.Y. H:i', strtotime($g->datumpocetka));
            if($g->predavac==null){
                $g->predavac='[nije postavljeno]';
            }
        }

        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>$grupe
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->noviEntitet();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            $zadnjaSifraGrupe=Grupa::dodajNovi($this->entitet);
            header('location: ' . App::config('url') . 
            'grupa/promjena?sifra=' . $zadnjaSifraGrupe);
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->novoView();
        }       
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
               $ic = new IndexController();
               $ic->logout();
               return;
            }
            $this->entitet = Grupa::ucitaj($_GET['sifra']);
            $datum=date('Y-m-d\TH:i', strtotime($this->entitet->datumpocetka));
            $this->entitet->datumpocetka=$datum;
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            Grupa::promjeniPostojeci($this->entitet);
            $this->index();
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->promjenaView();
        }       
    }


    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
            $ic = new IndexController();
            $ic->logout();
            return;
        }
        Grupa::obrisiPostojeci($_GET['sifra']);
        header('location: ' . App::config('url') . 'grupa/index');
       
    }

    public function dodajpolaznika()
    {
        Grupa::dodajPolaznika();
        echo 'OK';
    }

    public function obrisipolaznika()
    {
        Grupa::obrisiPolaznika();
        echo 'OK';
    }







    

    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->naziv='';
        $this->entitet->smjer=-1;
        $this->entitet->predavac=-1;
        $this->entitet->datumpocetka=date('Y-m-d\TH:i');
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
            'smjerovi'=>$this->smjerovi,
            'predavaci'=>$this->predavaci,
            'css'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">',
            'js'=>'<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="' . App::config('url') . 'public/js/grupa/promjena.js"></script>'
        ]);
    }


    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
            'smjerovi'=>$this->smjerovi,
            'predavaci'=>$this->predavaci
        ]);
    }

    private function kontrola()
    {
        $this->kontrolaNaziv();
        $this->kontrolaSmjer();
        $this->kontrolaPredavac();
    }

    private function kontrolaNaziv()
    {
        if(strlen(trim($this->entitet->naziv))==0){
            throw new Exception('Naziv obavezno');
        }

        if(strlen(trim($this->entitet->naziv))>20){
            throw new Exception('Naziv predugačko');
        }
    }

    private function kontrolaSmjer()
    {
        if($this->entitet->smjer==-1){
            throw new Exception('Smjer obavezno');
        }
    }

    private function kontrolaPredavac()
    {
        if($this->entitet->predavac==-1){
            throw new Exception('Predavač obavezno');
        }
    }



}