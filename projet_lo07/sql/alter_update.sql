ALTER TABLE dba_nf19_median2016.medecin ENGINE=InnoDB;
ALTER TABLE dba_nf19_median2016.patient ENGINE=InnoDB;
ALTER TABLE dba_nf19_median2016.rdv ENGINE=InnoDB;
ALTER TABLE dba_test.affectation ENGINE=InnoDB;
ALTER TABLE dba_test.cursus ENGINE=InnoDB;
ALTER TABLE dba_test.employe ENGINE=InnoDB;
ALTER TABLE dba_test.pole ENGINE=InnoDB;
ALTER TABLE dba_test.poste ENGINE=InnoDB;
ALTER TABLE dba_test.voiture ENGINE=InnoDB;
ALTER TABLE utt_dba.branche ENGINE=InnoDB;
ALTER TABLE utt_dba.categorie ENGINE=InnoDB;
ALTER TABLE utt_dba.cursus ENGINE=InnoDB;
ALTER TABLE utt_dba.etudiant ENGINE=InnoDB;

alter table ue change credit branche varchar(3) not null;
alter table ue add column filiere varchar(5) default null;