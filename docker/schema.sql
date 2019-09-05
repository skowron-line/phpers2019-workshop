drop table if exists companies;
create table companies
(
    id int primary key auto_increment,
    name varchar(100)
)engine=innodb;

drop table if exists province;
create table province
(
    id int primary key auto_increment,
    name varchar(100)
)engine=innodb;

drop table if exists cities;
create table cities
(
    id int primary key auto_increment,
    name varchar(100),
    province_id int
)engine=innodb;


drop table if exists skills;
create table skills
(
    id int primary key auto_increment,
    offer_id int not null,
    name varchar(100),
    type int comment '0 - required, 1 nice to have'
)engine=innodb;

drop table if exists offers;
create table offers
(
    id int primary key auto_increment,
    title varchar(100),
    added_at datetime,
    expires_at datetime,
    views_count int default 0,
    salary_from int,
    salary_to int,
    salary_type int comment '0 - netto / 1 - brutto'
)engine=innodb;

drop table if exists offers_cities;
create table offers_cities
(
    city_id int not null,
    offer_id int not null
)engine=innodb;

drop table if exists offers_companies;
create table offers_companies
(
    company_id int not null,
    offer_id int not null
)engine=innodb;

insert into companies values (1, 'Company Flow');
insert into companies values (2, 'Big boss');

insert into skills values (1, 1, 'php', 0);
insert into skills values (2, 1, 'mysql', 0);
insert into skills values (3, 1, 'casandra', 1);
insert into skills values (4, 1, 'redis', 0);
insert into skills values (5, 2, 'php', 0);
insert into skills values (6, 2, 'symfony', 0);
insert into skills values (7, 2, 'elasticsearch', 0);

insert into province values (1, 'mazowieckie');
insert into province values (2, 'wielkopolskie');

insert into cities values (1, 'Warszawa', 1);
insert into cities values (2, 'Poznań', 2);

insert into offers values (1, 'PHP Developer', '2019-01-01', '2019-01-15', '2', '10000', '15000', 0);
insert into offers values (2, 'Senior developer', '2019-01-15', '2019-01-31', '2', '8000', '12000', 1);
insert into offers values (3, 'Senior developer', '2019-01-15', '2019-01-31', '2', '8000', '12000', 1);
insert into offers values (4, 'Frontend developer', '2019-02-15', '2019-02-29', '2', '400', '9000', 1);

insert into offers_cities values (1, 1);
insert into offers_cities values (1, 2);
insert into offers_cities values (2, 2);
insert into offers_cities values (2, 3);
insert into offers_cities values (2, 4);

insert into offers_companies values (1, 1);
insert into offers_companies values (2, 2);
insert into offers_companies values (2, 3);
insert into offers_companies values (2, 4);