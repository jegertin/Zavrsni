<?php

class Djelatnik
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

        select a.*, count(b.sifra) as ukupnoracuna from djelatnik a
        inner join racun b on a.sifra =b.djelatnik
        group by a.sifra,a.ime,a.prezime,a.oib,a.email,a.iban;

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
}