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
    
}