select * from ue;
select * from etudiant;
select * from cursus;
select * from elem_formation;

describe elem_formation;
alter table elem_formation add constraint primary key(sem_seq,sigle,resultat);

select distinct sigle from elem_cursus;
select sigle from ue where branche='ISI';

select sum(credit) from elem_cursus where affectation='TCBR' and categorie in ('CS','TM')	;

SELECT SUM(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='12546' and id=cursus.id_elem_formation and affectation='TCBR' and categorie in ('CS','TM');
SELECT elem_formation.categorie, cursus.n_etu FROM elem_formation, cursus WHERE n_etu='12546' and id=cursus.id_elem_formation and categorie='NPML' ;

SELECT date_modif FROM cursus WHERE n_etu='99304' ORDER BY date_modif DESC LIMIT 1;

SELECT SUM(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='99304' and elem_formation.id=cursus.id_elem_formation and affectation='BR' and categorie='CS';

select mdp from authetification where n_etu='kkkk';

SELECT SUM(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='99304' and elem_formation.id=cursus.id_elem_formation;

SELECT elem_formation.sem_seq, elem_formation.sem_label, elem_formation.sigle, elem_formation.categorie, elem_formation.affectation, elem_formation.utt, elem_formation.profil, elem_formation.credit, elem_formation.resultat FROM elem_formation, cursus WHERE n_etu='12546' and elem_formation.id=cursus.id_elem_formation order by sem_seq;

SELECT distinct sigle FROM elem_formation, cursus WHERE elem_formation.id=cursus.id_elem_formation and n_etu='99304' order by sigle;