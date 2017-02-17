#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: sly_user
#------------------------------------------------------------

CREATE TABLE sly_user(
        uid      int (11) Auto_increment  NOT NULL ,
        nom      Varchar (50) ,
        prenom   Varchar (50) ,
        login    Varchar (50) ,
        mail     Varchar (100) ,
        mdp      Varchar (32) ,
        born     Date ,
        register Date ,
        groupe   Varchar (25) ,
        sexe     Varchar (5) ,
        PRIMARY KEY (uid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sly_article
#------------------------------------------------------------

CREATE TABLE sly_article(
        aid         int (11) Auto_increment  NOT NULL ,
        titre       Varchar (50) ,
        auteur      Varchar (50) ,
        date_public Datetime ,
        date_modif  Datetime ,
        contenu     Text ,
        uid         Int ,
        PRIMARY KEY (aid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sly_config
#------------------------------------------------------------

CREATE TABLE sly_config(
        cnfid       int (11) Auto_increment  NOT NULL ,
        titre       Varchar (50) ,
        admin_email Varchar (50) ,
        tel_email Varchar (12) ,
        theme       Varchar (50) ,
        description Text ,
        PRIMARY KEY (cnfid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sly_comment
#------------------------------------------------------------

CREATE TABLE sly_comment(
        fid        int (11) Auto_increment  NOT NULL ,
        auteur     Varchar (50) ,
        date_post  Datetime ,
        contenu    Text ,
        aid        Int ,
        PRIMARY KEY (fid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sly_categorie
#------------------------------------------------------------

CREATE TABLE sly_categorie(
        cid   int (11) Auto_increment  NOT NULL ,
        name  Varchar (50) ,
        cid_1 Int ,
        PRIMARY KEY (cid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sly_message
#------------------------------------------------------------

CREATE TABLE sly_message(
        mid          int (11) Auto_increment  NOT NULL ,
        auteur       int (11) ,
        destinataire int (11) ,
        contenu      Text ,
        date_post    Datetime ,
        PRIMARY KEY (mid )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: appartient
#------------------------------------------------------------

CREATE TABLE appartient(
        aid Int NOT NULL ,
        cid Int NOT NULL ,
        PRIMARY KEY (aid ,cid )
)ENGINE=InnoDB;

ALTER TABLE sly_article ADD CONSTRAINT FK_sly_article_uid FOREIGN KEY (uid) REFERENCES sly_user(uid);
ALTER TABLE sly_comment ADD CONSTRAINT FK_sly_comment_aid FOREIGN KEY (aid) REFERENCES sly_article(aid);
ALTER TABLE sly_categorie ADD CONSTRAINT FK_sly_categorie_cid_1 FOREIGN KEY (cid_1) REFERENCES sly_categorie(cid);
ALTER TABLE appartient ADD CONSTRAINT FK_appartient_aid FOREIGN KEY (aid) REFERENCES sly_article(aid);
ALTER TABLE appartient ADD CONSTRAINT FK_appartient_cid FOREIGN KEY (cid) REFERENCES sly_categorie(cid);