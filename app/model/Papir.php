<?php

class Papir
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            select * from papir where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

        select p.*, count(r.sifra) as ukupnoRacuna from papir p left join racun r on r.papir = p.sifra group by p.sifra

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($papir)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            insert into papir (vrstapapira)
            values (:vrstapapira)

        ');
        $izraz->execute((array)$papir);
    }

    public static function promjeniPostojeci($papir)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update papir set vrstapapira = :vrstapapira where sifra = :sifra');
        $izraz->execute((array)$papir);
    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            delete from papir where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}