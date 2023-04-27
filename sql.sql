create database dicionario;

use dicionario;

create table vocabulario (
id int primary key auto_increment not null,    
palavra varchar(50), 
significado text
); 