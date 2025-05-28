create database nota;
use nota;

create table atividade(
id int auto_increment primary key,
descricao varchar(250),
peso decimal(16,2),
anexo varchar(250) );


create table nota(
id int auto_increment primary key,
trimestre int,
descricao varchar(250),
valor int,
datalancada varchar(250),
anexo varchar(250) );


select * from atividade;
-- script de criação do banco de dados