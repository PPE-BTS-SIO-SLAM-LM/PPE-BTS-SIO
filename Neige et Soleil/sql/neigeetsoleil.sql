/***************************************Création de la bdd ********************************/
drop database if exists neigeetsoleil;
create database neigeetsoleil;
use neigeetsoleil;




/************************************* Création des tables **********************************/
drop table if exists utilisateur;
CREATE TABLE utilisateur (
    id_user INT AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL,
    tel VARCHAR(15) NOT NULL,
    role ENUM('client', 'proprietaire', 'admin') NOT NULL DEFAULT 'client',
    PRIMARY KEY (id_user)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

drop table if exists admin;
create table admin (
    id_a int not null,
    primary key(id_a),
    constraint fk_admin_user foreign key (id_a) references utilisateur(id_user) on delete cascade
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

drop table if exists client;
create table client(
    id_c int not null,
    adresse varchar(100),
    cp varchar(10),
    ville varchar(50),
    RIB varchar(50),
    nb_resa int default 0,
    primary key(id_c),
    constraint fk_client_user foreign key(id_c) references utilisateur(id_user) on delete cascade
)ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

drop table if exists proprietaire;
create table proprietaire(
    id_p int not null,
    adresse varchar(100),
    cp varchar(10),
    ville varchar(50),
    RIB varchar(50),
    nb_contrat int default 0,
    primary key(id_p),
    constraint fk_proprietaire_user foreign key(id_p) references utilisateur(id_user) on delete cascade
)ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

create table habitation(
    ref_hab int(5) not null auto_increment,
    type_hab varchar(20) not null,
    adr_hab varchar(120) not null,
    cp_hab varchar(5) not null,
    ville_hab varchar(50) not null,
    tarif_hab_bas float(5) not null,
    tarif_hab_moy float(5) not null,
    tarif_hab_hau float(5) not null,
    surface varchar(10) not null,
    id_p int(5) not null,
    description_hab text,
    titre_hab varchar(60) not null,
    capacite_hab int(2) not null,
    primary key (ref_hab),
    foreign key (id_p) references proprietaire(id_p)
)ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

create table appartement(
    ref_hab int(5) not null auto_increment,
    type_hab varchar(20) not null,
    adr_hab varchar(120) not null,
    cp_hab varchar(5) not null,
    ville_hab varchar(50) not null,
    tarif_hab_bas float(5) not null,
    tarif_hab_moy float(5) not null,
    tarif_hab_hau float(5) not null,
    surface varchar(10) not null,
    id_p int(5) not null,
    description_hab text,
    titre_hab varchar(60) not null,
    capacite_hab int(2) not null,
    etage_ap int(2) not null,
    type_ap varchar(3),
    primary key (ref_hab)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

create table maison(
    ref_hab int(5) not null auto_increment,
    type_hab varchar(20) not null,
    adr_hab varchar(120) not null,
    cp_hab varchar(5) not null,
    ville_hab varchar(50) not null,
    tarif_hab_bas float(5) not null,
    tarif_hab_moy float(5) not null,
    tarif_hab_hau float(5) not null,
    surface varchar(10) not null,
    id_p int(5) not null,
    description_hab text,
    titre_hab varchar(60) not null,
    capacite_hab int(2) not null,
    carac_m varchar(50) not null,
    primary key (ref_hab)
) ENGINE = InnoDB CHARSET = utf8mb4;

create table reservation(
    ref_res int(5) not null auto_increment,
    date_res date not null,
    nb_perso int(2) not null,
    date_debut date not null,
    date_fin date not null,
    etat_res enum("Validee","En attente","Annulee"),
    id_c int(5) not null,
    ref_hab int(5) not null,
    prix_a_payer float not null default 0,
    primary key (ref_res),
    foreign key (id_c) references client(id_c),
    foreign key (ref_hab) references habitation(ref_hab)
);

create table contrat(
    ref_c int(20) not null auto_increment,
    status_c enum("En validation","En cours","Annule","Resilie"),
    annee_signature date,
    annee_fin date,
    id_p int(5) not null,
    ref_hab int(5) not null,
    primary key (ref_c),
    foreign key (id_p) references proprietaire(id_p),
    foreign key (ref_hab) references habitation(ref_hab)
)ENGINE = InnoDB CHARSET = utf8mb4;

create table image(
    ref_image int(5) not null auto_increment,
    url_image varchar(200) not null,
    ref_hab int(5) not null,
    primary key (ref_image),
    foreign key (ref_hab) references habitation(ref_hab)
);

create table if not exists photos(
    id_photo int not null auto_increment,
    ref_hab int not null,
    url_photo varchar(255) not null,
    is_principal boolean default false,
    primary key(id_photo),
    foreign key(ref_hab) references habitation(ref_hab) on delete cascade on update cascade
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

drop table if exists reset_mdp;
create table reset_mdp(
    email varchar(100) not null,
    code varchar(6) not null,
    created_at datetime default now(),
    primary key(email)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

create table archiveReservation like reservation;
alter table archivereservation add column datehisto date;

create table archiveContrat like contrat;
alter table archiveContrat add column datehisto date;




/**************************************** Triggers ******************************************/
drop trigger if exists insert_appart;
delimiter //
create trigger insert_appart
before insert on appartement for each row BEGIN
    if new.ref_hab is null or new.ref_hab in (select ref_hab from habitation) or new.ref_hab = 0 
    then
   set new.ref_hab = ifnull((select ref_hab from habitation where ref_hab >= all
    (select ref_hab from habitation)), 0) +1 ;
end if;
insert into habitation values(new.ref_hab,new.type_hab,new.adr_hab,new.cp_hab,new.ville_hab,new.tarif_hab_bas,new.tarif_hab_moy,new.tarif_hab_hau,new.surface,new.id_p,new.description_hab,new.titre_hab,new.capacite_hab);
end //
delimiter ;

drop trigger if exists update_appart;
delimiter //
create trigger update_appart
before update on appartement for each row BEGIN
    update habitation set ref_hab=new.ref_hab,type_hab=new.type_hab,adr_hab=new.adr_hab,cp_hab=new.cp_hab,ville_hab=new.ville_hab,tarif_hab_bas=new.tarif_hab_bas,tarif_hab_moy=new.tarif_hab_moy,tarif_hab_hau=new.tarif_hab_hau,surface=new.surface,id_p=new.id_p,description_hab=new.description_hab,titre_hab=new.titre_hab,capacite_hab=new.capacite_hab where habitation.ref_hab=new.ref_hab;
end //
delimiter ;

drop trigger if exists delete_appart;
delimiter //
create trigger delete_appart
before delete on appartement for each row BEGIN
    delete from habitation where habitation.ref_hab=old.ref_hab;
end //
delimiter ;

drop trigger if exists insert_maison;
delimiter //
create trigger insert_maison
before insert on maison for each row BEGIN
if new.ref_hab is null or new.ref_hab in (select ref_hab from habitation) or new.ref_hab = 0 
    then
set new.ref_hab = ifnull((select ref_hab from habitation where ref_hab >= all
    (select ref_hab from habitation)), 0) +1 ;
end if;
insert into habitation values(new.ref_hab,new.type_hab,new.adr_hab,new.cp_hab,new.ville_hab,new.tarif_hab_bas,new.tarif_hab_moy,new.tarif_hab_hau,new.surface,new.id_p,new.description_hab,new.titre_hab,new.capacite_hab);
end //
delimiter ;

drop trigger if exists update_maison;
delimiter //
create trigger update_maison
before update on maison for each row BEGIN
    update habitation set ref_hab=new.ref_hab,type_hab=new.type_hab,adr_hab=new.adr_hab,cp_hab=new.cp_hab,ville_hab=new.ville_hab,tarif_hab_bas=new.tarif_hab_bas,tarif_hab_moy=new.tarif_hab_moy,tarif_hab_hau=new.tarif_hab_hau,surface=new.surface,id_p=new.id_p,description_hab=new.description_hab,titre_hab=new.titre_hab,capacite_hab=new.capacite_hab where habitation.ref_hab=new.ref_hab;
end //
delimiter ;

drop trigger if exists delete_maison;
delimiter //
create trigger delete_maison
before delete on maison for each row BEGIN
    delete from habitation where habitation.ref_hab=old.ref_hab;
end //
delimiter ;

drop trigger if exists insert_contrat;
delimiter //
create trigger insert_contrat
after insert on habitation 
for each row
begin 
insert into contrat values (null,'En validation',null,null,new.id_p,new.ref_hab);
end //
delimiter ;

drop trigger if exists delete_contrat;
delimiter //
create trigger delete_contrat
after delete on habitation
for each row
begin
delete from contrat where contrat.ref_hab = old.ref_hab;
end //
delimiter ;

drop trigger if exists updateNbContratInsert;
delimiter //
create trigger updateNbContratInsert
after insert on contrat
for each row
begin 
update proprietaire set nb_contrat = nb_contrat + 1 
where id_p = new.id_p;
end //
delimiter ;

drop trigger if exists updateNbContratDelete;
delimiter //
create trigger updateNbContratDelete
after delete on contrat
for each row
begin 
update proprietaire set nb_contrat = nb_contrat - 1 
where id_p = old.id_p;
end //
delimiter ;

drop trigger if exists formeNomsPrenomsUtilisateurInsert;
delimiter //
create trigger formeNomsPrenomsUtilisateurInsert
before insert on utilisateur
for each row
begin
set new.nom = upper(new.nom), new.prenom = capitalisation(new.prenom);
end//
delimiter ;

drop trigger if exists formeNomsPrenomsUtilisateurUpdate;
delimiter //
create trigger formeNomsPrenomsUtilisateurUpdate
before insert on utilisateur
for each row
begin
set new.nom = upper(new.nom), new.prenom = capitalisation(new.prenom);
end//
delimiter ;

drop trigger if exists tr_insertAdmin;
delimiter //
create trigger tr_insertAdmin
after insert on utilisateur
for each row
begin
    if 
        new.role = 'admin'
    then
        insert into admin values (new.id_user);
    end if;
end //
delimiter ;

/* historisation contrats */
drop trigger if exists histoContratResilieAnnule;
delimiter //
create trigger histoContratResilieAnnule
after update on contrat
for each row 
BEGIN
if new.status_c = 'Resilie' or new.status_c = 'Annule' 
then
    insert into archivecontrat
    values(new.ref_c,new.status_c,new.annee_signature,new.annee_fin,new.id_p,
            new.ref_hab, curdate()
          );
end if;
end // 
delimiter ;

/* historisation reservations*/
drop trigger if exists histoReservationAnnulee;
delimiter //
create trigger histoReservationAnnulee
after update on reservation
for each row
begin
if new.etat_res = 'Annulee'
then insert into archivereservation
        values(new.ref_res, new.date_res, new.nb_perso, new.date_debut, new.date_fin,
                new.etat_res, new.id_c, new.ref_hab, new.prix_a_payer, curdate() 
               );
end if;
end //
delimiter ;




/****************************************** events ******************************************/
set global event_scheduler = on;

delimiter //

create event archiveReservationExpiree
on schedule every 1 day
starts curdate()
on completion preserve
enable
do
begin
insert into archivereservation
select *, curdate() from reservation where date_fin < curdate();
delete from reservation where date_fin < curdate();

end //

delimiter ;




/****************************************** fonctions ***************************************/
drop function if exists capitalisation;
delimiter //
create function capitalisation(chaine varchar(50))
returns varchar(50)
begin
declare x VARCHAR(1);
declare y varchar(49);
set x = substring(chaine,1,1);
set y = substring(chaine,2);
set x = upper(x);
set y = lower(y);
return concat(x,y);
end//
delimiter ;

/***************************************** procedures ***************************************/







/**************************************** Modif 07/04 **************************************/
/*gestion changement mdp expiré chaque 3 mois*/
alter table utilisateur add column date_mdp date after mdp;

/*gestion ajout champ nb resa des clients*/
alter table client add column nb_resa int;

drop trigger if exists tr_nbResa;
delimiter //
create trigger tr_nbResa
after insert on reservation
for each row
begin
update client set nb_resa = nb_resa + 1 where id_c = new.id_c;
end //
delimiter ;

update client c set c.nb_resa = (select count(*) from reservation r where r.id_c = c.id_c);





