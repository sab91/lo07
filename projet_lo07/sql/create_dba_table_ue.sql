drop table if exists ue;
drop table if exists etudiant;
drop table if exists cursus;
drop table if exists elem_formation;
drop table if exists authentification;

use utt_dba;

create table ue (
	sigle varchar(4),
    nom varchar(45) not null,
    categorie varchar(4) not null check(categorie in ('CS','TM','EC','HT','ME','ST','SE','HP','NPML')),
    affectation varchar(4) not null check(affecation in ('TC', 'TCBR', 'FCBR', 'BR')),
    branche varchar(3) check(branche in ('ISI','RT','MTE','A2I','GM','GI','MM')),
    utt varchar(1) not null check(utt in('Y','N')),
    filiere varchar(5),
    primary key (sigle)
);
    
create table etudiant (
	numero_etu int(6),
    nom varchar(45) not null,
    prenom varchar(45) not null,
    admission varchar(2) not null check(admission in ('TC','BR')),
    filiere varchar(4) not null check(filiere in ('?','MSI','MRI','MPL','LIB')),
    primary key (numero_etu)
);

create table elem_formation (
	id int(255) auto_increment,
    sem_seq int(2) not null check(sem_seq between 1 and 10),
    sem_label varchar(4) not null,
    sigle varchar(6) not null,
    categorie varchar(4) not null,
    affectation varchar(4) not null,
    utt varchar(1) not null check(utt in('Y','N')),
    profil varchar(1) not null check(utt in('Y','N')),
    credit int(2) not null check(credit between 1 and 30),
    resultat varchar(4) not null check(resultat in('A','B','C','D','E','F','FX','EQU','ABS','RES','ADM')),
	primary key (id)
);

create table cursus (
	n_etu int(6) not null,
    id_elem_formation int(255) not null,
    date_modif datetime not null,
    primary key (n_etu, id_elem_formation),
    foreign key (n_etu) references etudiant(numero_etu),
    foreign key (id_elem_formation) references elem_formation(id)
);

create table authentification (
	n_etu int(6),
    mdp varchar(255) not null,
    primary key (n_etu),
    foreign key (n_etu) references etudiant(numero_etu)
);

alter table ue engine = InnoDB;
drop table ue;