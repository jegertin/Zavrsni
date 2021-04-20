<?php

class Racun
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

        select r.*, u.cijena as cijena, u.naziv as nazivUsluge, concat(d.ime, \' \', d.prezime) as nazivDjelatnika, p.vrstapapira as vrstaPapira
        from racun r 
        left join usluga u on u.sifra = r.usluga
        left join djelatnik d on d.sifra = r.djelatnik
        left join papir p on p.sifra = r.papir
        group by r.sifra

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($racun)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            insert into racun (djelatnik, klijent, usluga, papir)
            values (:djelatnik, :klijent, :usluga, :papir)

        ');
        $izraz->execute((array)$racun);
    }

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