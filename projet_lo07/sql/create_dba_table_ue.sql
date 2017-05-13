drop table if exists ue;
drop table if exists etudiant;
drop table if exists categorie;
drop table if exists cursus;
drop table if exists branche;

use utt_dba;

create table ue (
	sigle varchar(4),
    nom varchar(45) not null,
    categorie varchar(4) not null check(categorie in ('CS','TM','EC','HT','ME','ST','SE','HP','NPML')),
    affectation varchar(4) not null check(affecation in ('TC', 'TCBR', 'FCBR', 'BR')),
    branche varchar(3) not null check(branche in ('ISI','RT','MTE','A2I','GM','GI','MM')),
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

create table categorie (
	nom varchar(45) not null,
    label varchar(4) not null,
    credit int(2) not null,
    primary key (label)
);

create table branche (
	sigle_branche varchar(3) not null,
    sigle_filiere varchar(4) not null,
    nom_branche varchar (45) not null,
    nom_filiere varchar(45) not null,
    primary key (sigle_branche, sigle_filiere)
);

create table cursus (
	sem_seq int(2) not null check(sem_seq between 1 and 10),
    sem_label varchar(4) not null,
    sigle varchar(4),
    categorie varchar(4) not null,
    affectation varchar(4) not null,
    utt varchar(1) not null check(utt in('Y','N')),
    profil varchar(1) not null check(utt in('Y','N')),
    credit int(2) not null check(credit between 1 and 30),
    resultat varchar(3) not null check(resultat in('A','B','C','D','E','F','FX','EQU','ABS','RES','ADM')),
    foreign key (sigle) references ue(sigle),
    foreign key (categorie) references categorie(label)    
);

alter table ue engine = InnoDB;

SELECT CONCAT('ALTER TABLE ',table_schema,'.',table_name,' ENGINE=InnoDB;')
FROM information_schema.tables
WHERE 1=1
AND engine = 'MyISAM'
AND table_schema NOT IN ('information_schema', 'mysql', 'performance_schema');