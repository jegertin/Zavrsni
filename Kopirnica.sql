# c:\xampp\mysql\bin\mysql -uedunova -pedunova < C:\PP22\polaznik28.edunova.hr\Kopirnica.sql
drop database if exists kopirnica;
create database kopirnica character set utf8mb4 COLLATE utf8mb4_croatian_ci;
use kopirnica;

create table operater(
    sifra int not null primary key auto_increment,
    email varchar(50) not null,
    lozinka char(60) not null,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    uloga varchar(10) not null
);

insert into operater values(null,'edunova@edunova.hr','$2y$10$Yrbpxrsw8GCNdX5GWPeOp.u3h/QMqD/Y60x7Ujc3HDPluOupPptIu','Administrator','Kopirnice','Admin');

insert into operater values(null,'oper@edunova.hr','$2y$10$bU9R9tYvUwsj33u18JsTme7NmexjN8CjdGDLNesBmpbYARXFX5hAu','Operater','Kopirnice','Oper');

create table djelatnik(
    sifra int not null primary key auto_increment,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    oib char(11),
    email varchar(50) not null,
    iban varchar(50) not null
);

create table usluga(
    sifra int not null primary key auto_increment,
    naziv varchar(25),
    cijena decimal(6,2)
);

create table papir(
    sifra int not null primary key auto_increment,
    vrstapapira varchar(30),
    usluga int not null
);

create table racun(
    sifra int not null primary key auto_increment,
    djelatnik int not null,
    vrstaracuna varchar(30),
    usluga int not null,
    papir int not null
);

alter table racun add foreign key (usluga) references usluga(sifra);
alter table papir add foreign key (usluga) references usluga(sifra);
alter table racun add foreign key (djelatnik) references djelatnik(sifra);
alter table racun add foreign key (papir) references papir(sifra);