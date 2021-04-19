<?php
$dev=$_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;
if($dev){
    $baza=[
        'server'=>'localhost',
        'baza'=>'kopirnica',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    ];
}else{
    $baza=[
        'server'=>'localhost',
        'baza'=>'feba_pp22',
        'korisnik'=>'feba_edunova',
        'lozinka'=>'edunova123.'
    ];
}
return [
    'url'=>'http://polaznik28.hr/',
    'nazivApp'=>'Kopirnica',
    'baza'=>$baza
];