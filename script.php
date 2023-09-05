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
    (6, 'Banco da Amazônia');
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
    (6, 'Plano dentário', 175890, 3);
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
    (10, 4, 'Serviços de T.I');
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
INSERT INTO public.tb_contrato (id_contrato,prazo,valor,data_inclusao,id_convenio_servico)
VALUES (2,'2030-01-01',250.0,'2022-08-03 10:10:09.943',5),
	 (3,'2024-06-01',180.75,'2018-01-03 10:10:09.943',3),
	 (4,'2026-05-15',750.0,'2017-10-03 10:10:09.943',6),
	 (5,'2028-10-07',550.25,'2015-03-10 10:10:09.943',4),
	 (6,'2029-06-15',350.25,'2020-07-05 10:10:09.943',4),
	 (7,'2027-05-20',200.25,'2013-10-15 10:10:09.943',2),
	 (8,'2026-10-18',200.0,'2013-12-25 10:10:09.943',2),
	 (9,'2028-11-05',150.15,'2011-03-10 10:10:09.943',3),
	 (10,'2025-03-07',800.25,'2011-05-10 10:10:09.943',5),
	 (11,'2030-01-10',830.82,'2005-05-25 10:10:09.943',5),
	 (12,'2031-05-20',105.86,'2011-12-30 10:10:09.943',1),
	 (13,'2033-01-23',75.0,'2011-12-25 10:10:09.943',1),
	 (14,'2035-11-04',25.83,'2011-10-07 10:10:09.943',1),
	 (1,'2025-01-01',150000.0,'2015-07-10 10:10:09.943',2);
";


// Consulta 01 para a primeira etapa do teste
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


// Consulta 02 para a seguda etapa do teste
$consulta_data_2 = 'SELECT
        tb_banco.nome as "Banco",
        sum(tb_convenio.verba)  as "Verba",
        min(tb_contrato.data_inclusao) as "Mais antigo",
        max(tb_contrato.data_inclusao) as "Mais recente",
        count(tb_banco.id_banco) as "Total contratos", 
        sum(tb_contrato.valor) as "Soma dos Contratos"
FROM tb_convenio
        inner join tb_banco on tb_convenio.id_banco = tb_banco.id_banco
        inner join tb_convenio_servico on tb_convenio_servico.id_convenio = tb_convenio.id_convenio
        inner join tb_contrato on tb_convenio_servico.id_convenio_servico = tb_contrato.id_convenio_servico
group by tb_banco.nome 
';