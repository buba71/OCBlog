drop table if exists article;

create table article (
art_id integer not null primary key auto_increment,
art_title varchar (100) not null,
art_content varchar(2000) not null,
art_date DATETIME not null
) engine=innodb character set utf8 collate utf8_unicode_ci;