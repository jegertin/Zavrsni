# c:\xampp\mysql\bin\mysql -uedunova -pedunova < C:\PP22\polaznik28.edunova.hr\Kopirnica.sql
drop database if exists kopirnica;
create database kopirnica character set utf8mb4 COLLATE utf8mb4_croatian_ci;
use kopirnica;

create table operater(
    sifra int not null primary key auto_increment,
    email varchar(50) not null,
    lozinka varchar(60) not null,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    uloga varchar(10) not null
);

insert into operater values (null,'edunova@edunova.hr','$2y$10$Yrbpxrsw8GCNdX5GWPeOp.u3h/QMqD/Y60x7Ujc3HDPluOupPptIu','Administrator','Kopirnice','Admin');

insert into operater values (null,'oper@edunova.hr','$2y$10$bU9R9tYvUwsj33u18JsTme7NmexjN8CjdGDLNesBmpbYARXFX5hAu','Operater','Kopirnice','Oper');

insert into operater values (null,'tinjeger@edunova.hr','$2y$10$MNo2GOVSqOlkiTw8nxbOluQZOn6Pqvxw90xfkU3vj4BiS6U/bwYim','Tin','Jeger','Admin');

insert into operater values (null,'marinamidzic@edunova.hr','$2y$10$y3TGn1Dh9J4JVYL2xmkB8OxUPtdHc511vjrGthlmryblEiPXPdSmK','Marin','Amidzic','Korisnik');

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

insert into djelatnik(sifra,ime,prezime,oib,email,iban)values
(null,'Tin','Jeger','25465872012','tinjeger@edunova.hr','HR2910592150129523678'),
(null,'Marin','Amidzic','91842195123','marinamidzic@edunova.hr','HR910528102915684102104');

insert into usluga(sifra,naziv,cijena) values
(null,'Kopiranje',1),
(null,'Skeniranje',2);

insert into papir(sifra,vrstapapira,usluga) values
(null,'80gramski',1),
(null,'250gramski',2);

insert into racun(sifra,djelatnik,vrstaracuna,usluga,papir) values
(null,2,'Obican',1,1),
(null,1,'R1',2,2);