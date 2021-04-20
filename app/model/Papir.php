<?php

class Papir
{
    // public static function ucitaj($sifra)
    // {
    //     $veza = DB::getInstanca();
    //     $izraz=$veza->prepare('

    //         select * from usluga where sifra=:sifra

    //     ');
    //     $izraz->execute(['sifra'=>$sifra]);
    //     return $izraz->fetch();
    // }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

        select * from papir

        ');
        $izraz->execute();
        // echo var_dump($izraz->errorInfo());
        // exit;
        return $izraz->fetchAll();
    }

    // public static function dodajNovu($usluga)
    // {
    //     $veza = DB::getInstanca();
    //     $izraz=$veza->prepare('

    //         insert into usluga (naziv,cijena)
    //         values (:naziv,:cijena)

    //     ');
    //     $izraz->execute((array)$usluga);
    // }

    // public static function promjeniPostojecu($usluga)
    // {
    //     $veza = DB::getInstanca();
    //     $izraz=$veza->prepare('update usluga set naziv = :naziv, cijena = :cijena where sifra = :sifra');
    //     $izraz->execute((array)$usluga);
    // }

    // public static function obrisiPostojecu($sifra)
    // {
    //     $veza = DB::getInstanca();
    //     $izraz=$veza->prepare('

    //         delete from usluga where sifra=:sifra

    //     ');
    //     $izraz->execute(['sifra'=>$sifra]);
    // }
}