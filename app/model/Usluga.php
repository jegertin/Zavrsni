<?php

class Usluga
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            select * from usluga where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            select * from usluga

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovu($usluga)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            insert into usluga (naziv,cijena)
            values (:naziv,:cijena)

        ');
        $izraz->execute((array)$usluga);
    }
}