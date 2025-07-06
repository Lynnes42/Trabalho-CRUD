create database Crud;
use Crud;

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
    imagem varchar(225) unique,
    data_criacao datetime default current_timestamp
);

-- Inserir usuários
INSERT INTO usuarios (nome, email, senha) VALUES
('Lucas Almeida', 'lucas.almeida@example.com', 'senha123'),
('Fernanda Oliveira', 'fernanda.oliveira@example.com', 'senha456'),
('Rafael Santos', 'rafael.santos@example.com', 'senha789');

-- Inserir produtos
INSERT INTO produtos (nome, preco, quantidade, descricao, imagem) VALUES
('Notebook Dell Inspiron', 3500.00, 10, 'Notebook com Intel i5, 8GB RAM, 256GB SSD', 'notebook_dell.jpg'),
('Smartphone Samsung Galaxy', 2300.00, 25, 'Smartphone com câmera tripla e tela AMOLED', 'samsung_galaxy.jpg'),
('Monitor LG 24"', 900.00, 15, 'Monitor 24 polegadas Full HD', 'monitor_lg.jpg'),
('Teclado Mecânico', 450.00, 30, 'Teclado mecânico com iluminação RGB', 'teclado_rgb.jpg');


INSERT INTO produtos (nome, preco, quantidade, descricao, imagem, data_criacao) VALUES
('Fone de Ouvido Bluetooth', 150.00, 40, 'Fone sem fio com cancelamento de ruído', 'fone_bluetooth.jpg', '2024-12-01 14:23:00'),
('Cadeira Gamer', 1200.00, 8, 'Cadeira ergonômica com suporte lombar', 'cadeira_gamer.jpg', '2025-01-15 09:00:00'),
('Webcam HD', 320.00, 20, 'Webcam Full HD para videochamadas', 'webcam_hd.jpg', '2023-11-10 18:45:00'),
('Mouse Sem Fio Logitech', 180.00, 50, 'Mouse sem fio com alta precisão', 'mouse_logitech.jpg', '2024-07-22 16:30:00'),
('SSD 1TB', 650.00, 12, 'SSD rápido para armazenamento de dados', 'ssd_1tb.jpg', '2025-03-05 11:10:00');
