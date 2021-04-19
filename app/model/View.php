<?php

class View
{
    private $predlozak;

    public function __construct($predlozak='predlozak')
    {
        $this->predlozak=$predlozak;
    }
    public function render($stranicaZaRender,$parametri=[])
    {
        ob_start();
        extract($parametri);
        include BP . 'view' . DIRECTORY_SEPARATOR . 
        $stranicaZaRender . '.phtml';
        $sadrzaj = ob_get_clean();
        $podnozjePodatci=$this->podnozjePodatci();
        include BP . 'view' . DIRECTORY_SEPARATOR .
        $this->predlozak . '.phtml';
    }
    private function podnozjePodatci()
    {
        if($_SERVER['SERVER_ADDR']==='127.0.0.1'){
           return '2020-' . date('Y') . ' - LOKALNO';
        }
        return '2020-' . date('Y');
    }
}