create database Crud;
use Login;

create table usuarios(
	id int auto_increment primary key,
    nome varchar(100),
    email varchar(100) unique,
    senha varchar (255)
);

create table produtos(
	id int auto_increment primary key,
    nome varchar(100) not null,
    preco decimal(10,2) not null,
    quantidade int not null,
    descricao text,
    imagem varchar(225),
    data_criacao datetime default current_timestamp
);
