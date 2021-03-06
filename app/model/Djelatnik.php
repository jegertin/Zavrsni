<?php

class Djelatnik
{
    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            select * from djelatnik where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            select d.*, count(r.sifra) as ukupnoracuna from djelatnik d
            left join racun r on d.sifra = r.djelatnik
            group by d.sifra

        ');
        $izraz->execute();

        // echo var_dump($izraz->errorInfo());
        // exit;
        return $izraz->fetchAll();
    }

    public static function dodajNovog($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('insert into djelatnik (ime,prezime,oib,email,iban) values (:ime,:prezime,:oib,:email,:iban)');
        $izraz->execute([
            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'oib'=>$entitet->oib,
            'email'=>$entitet->email,
            'iban'=>$entitet->iban
        ]);
        
        $veza->commit();
    }

    public static function promjeniPostojeci($djelatnik)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update djelatnik set ime = :ime, prezime = :prezime, oib = :oib, email = :email, iban = :iban where sifra = :sifra');
        $izraz->execute((array)$djelatnik);
    }


    public static function obrisiPostojeceg($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            delete from djelatnik where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}