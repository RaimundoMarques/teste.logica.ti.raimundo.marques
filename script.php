<?php 

/**
 * Os dados inseridos são suposições de contratos
 */

// CRIAÇÃO E INSERÇÃO DE DADOS DA TABELA 01
$cria_tb_banco = "
    create table if not exists tb_banco(
	id_banco int primary key,
	nome varchar(100)
    );
";

$insert_tb_banco = "
    insert into tb_banco (id_banco, nome)
    values (1, 'Banco do Brasil'),
    (2, 'Banco do Bradesco'),
    (3, 'Itaú'),
    (4, 'Caixa Econômica Federal'),
    (5, 'Santander'),
    (6, 'Banco da Amazônia')
";



// CRIAÇÃO E INSERÇÃO DE DADOS DA TABELA 02
$cria_tb_convenio = "
    create table if not exists tb_convenio(
	id_convenio int primary key,
	convenio varchar(100),
	verba float, 
	id_banco int,
	constraint fk_banco foreign key (id_banco) references tb_banco (id_banco)
    );
";

$insert_tb_convenio = "
insert into tb_convenio (id_convenio, convenio, verba, id_banco)
values (1, 'Fábrica de Eventos', 3000000, 2),
    (2, 'HGV de Manaus', 750000, 3),
    (3, 'Santa Júlia', 250000, 4),
    (4, 'HAPIVIDA', 110550, 5),
    (5, 'Bradesco Saúde', 200780, 1),
    (6, 'Plano dentário', 175890, 3)
";




// CRIAÇÃO E INSERÇÃO DE DADOS DA TABELA 03
$cria_tb_convenio_servico = "
    create table if not exists tb_convenio_servico(
	id_convenio_servico int primary key, 
	id_convenio int, 
	servico varchar(100), 
	
	constraint fk_conven_serv foreign key (id_convenio) references tb_convenio (id_convenio)
    );
";

$insert_tb_convenio_servico = "
insert into tb_convenio_servico (id_convenio_servico, id_convenio, servico)
values (1, 2, 'Pintura'),
    (2, 1, 'Reposição de Estoque'),
    (3, 3, 'Buffet'),
    (4, 2, 'Cabeleireiro'),
    (5, 3, 'Serviços de T.I'),
    (6, 3, 'Empleita'),
    (7, 4, 'Empleita'),
    (8, 5, 'Empleita'),
    (9, 5, 'Construção de uma Sala de Recepção'),
    (10, 4, 'Serviços de T.I')
";




// CRIAÇÃO E INSERÇÃO DE DADOS DA TABELA 04
$cria_tb_contrato = "
    create table if not exists tb_contrato(
	id_contrato int primary key, 
	prazo date, 
	valor float,
	data_inclusao timestamp, 
	id_convenio_servico int, 
	
	constraint fk_conServ foreign key (id_convenio_servico) references tb_convenio_servico (id_convenio_servico)
    );
";

$insert_tb_contrato = "
insert into tb_contrato (id_contrato, prazo, valor, data_inclusao, id_convenio_servico)
values (1,'2025-01-01', 150000, now(), 2), 
    (2, '2030-01-01', 250.000, now(), 5), 
    (3, '2024-06-01', 180.750, now(), 3), 
    (4, '2026-05-15', 750.000, now(), 6), 
    (5, '2028-10-07', 550.250, now(), 4),
    (6, '2029-06-15', 350.250, now(), 4),
    (7, '2027-05-20', 200.250, now(), 2),
    (8, '2026-10-18', 200.000, now(), 2),
    (9, '2028-11-05', 150.150, now(), 3),
    (10, '2025-03-07', 800.250, now(), 5),
    (11, '2030-01-10', 830.820, now(), 5),
    (12, '2031-05-20', 105.860, now(), 1),
    (13, '2033-01-23', 75.000, now(), 1),
    (14, '2035-11-04', 25.830, now(), 1)
";


// Consulta Principal para o TESTE
$consulta_data = 'SELECT
        tb_banco.nome as "Banco",
        tb_convenio.verba as "Verba",
        tb_contrato.id_contrato as "Código do contrato",
        tb_contrato.data_inclusao as "Data da inclusão", 
        tb_contrato.valor as "Valor", 
        tb_contrato.prazo as "Prazo"
    FROM tb_convenio
        inner join tb_banco on tb_convenio.id_banco = tb_banco.id_banco
        inner join tb_convenio_servico on tb_convenio_servico.id_convenio = tb_convenio.id_convenio
        inner join tb_contrato on tb_convenio_servico.id_convenio_servico = tb_contrato.id_convenio_servico 
';