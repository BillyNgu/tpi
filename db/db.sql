#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: music
#------------------------------------------------------------

CREATE TABLE music(
        music_id          Int  Auto_increment  NOT NULL ,
        music_title       Varchar (50) NOT NULL ,
        music_description Varchar (50) NOT NULL ,
        music_file        Text NOT NULL ,
        music_cover       Blob NOT NULL
	,CONSTRAINT music_PK PRIMARY KEY (music_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: music_type
#------------------------------------------------------------

CREATE TABLE music_type(
        music_type_id Int  Auto_increment  NOT NULL ,
        music_type    Varchar (50) NOT NULL ,
        music_id      Int NOT NULL
	,CONSTRAINT music_type_PK PRIMARY KEY (music_type_id)

	,CONSTRAINT music_type_music_FK FOREIGN KEY (music_id) REFERENCES music(music_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: parameters
#------------------------------------------------------------

CREATE TABLE parameters(
        parameters_id   Int  Auto_increment  NOT NULL ,
        parameters_name Varchar (50) NOT NULL
	,CONSTRAINT parameters_PK PRIMARY KEY (parameters_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: quizz
#------------------------------------------------------------

CREATE TABLE quizz(
        quizz_id      Int  Auto_increment  NOT NULL ,
        quizz_date    Date NOT NULL ,
        quizz_score   Int NOT NULL ,
        parameters_id Int NOT NULL
	,CONSTRAINT quizz_PK PRIMARY KEY (quizz_id)

	,CONSTRAINT quizz_parameters_FK FOREIGN KEY (parameters_id) REFERENCES parameters(parameters_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE users(
        user_id         Int  Auto_increment  NOT NULL ,
        user_name       Varchar (50) NOT NULL ,
        user_nickname   Varchar (50) NOT NULL ,
        user_email      Varchar (50) NOT NULL ,
        user_password   Varchar (50) NOT NULL ,
        user_profilepic Blob NOT NULL ,
        user_status     Int NOT NULL
	,CONSTRAINT users_PK PRIMARY KEY (user_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: blindtest_contains
#------------------------------------------------------------

CREATE TABLE blindtest_contains(
        quizz_id Int NOT NULL ,
        music_id Int NOT NULL
	,CONSTRAINT blindtest_contains_PK PRIMARY KEY (quizz_id,music_id)

	,CONSTRAINT blindtest_contains_quizz_FK FOREIGN KEY (quizz_id) REFERENCES quizz(quizz_id)
	,CONSTRAINT blindtest_contains_music0_FK FOREIGN KEY (music_id) REFERENCES music(music_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: blindtest_defines
#------------------------------------------------------------

CREATE TABLE blindtest_defines(
        user_id       Int NOT NULL ,
        parameters_id Int NOT NULL
	,CONSTRAINT blindtest_defines_PK PRIMARY KEY (user_id,parameters_id)

	,CONSTRAINT blindtest_defines_users_FK FOREIGN KEY (user_id) REFERENCES users(user_id)
	,CONSTRAINT blindtest_defines_parameters0_FK FOREIGN KEY (parameters_id) REFERENCES parameters(parameters_id)
)ENGINE=InnoDB;

