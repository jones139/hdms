drop table if exists roles;
CREATE TABLE roles (
    id INT UNSIGNED PRIMARY KEY,
    rolename VARCHAR(50)
);

drop table if exists users;
CREATE TABLE users (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    role int,
    created DATETIME default null,
    modified datetime default null
);

drop table if exists facilities;
create table facilities (
       id int unsigned primary key,
       title varchar(20),
       codestr varchar(5)
);

drop table if exists doc_statuses;
create table doc_statuses (
       id int unsigned primary key,
       title varchar(20)
);

drop table if exists docs;
CREATE TABLE docs (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    docType integer,
    docNo VARCHAR(50),
    title VARCHAR(256)
);

drop table if exists revisions;
CREATE TABLE revisions (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    doc_id integer,
    major_revision int,
    minor_revision int,
    user_id int,
    doc_status_id int,
    route_list_id int
);

drop table if exists route_lists;
create table route_lists (
       id int unsigned auto_increment primary key,
       revision_id integer
);


drop table if exists route_list_entries;
create table route_list_entries (
       id int unsigned auto_increment primary key,
       route_list_id integer,
       user_id integer,
       response_id integer,
       response_date datetime,
       response_comment varchar(256)
);

drop table if exists responses;
create table responses (
       id int unsigned auto_increment primary key,
       title varchar(50)
);


insert into roles (id,rolename) values (0,'Disabled');
insert into roles (id,rolename) values (1,'Administrator');
insert into roles (id,rolename) values (2,'User');

insert into doc_statuses (id,title) values (0,'Draft');
insert into doc_statuses (id,title) values (1,'Waiting Approval');
insert into doc_statuses (id,title) values (2,'Issued');
insert into doc_statuses (id,title) values (3,'Withdrawn');

insert into facilities (id,title,codestr) values (0,'Hartlepool Aspire Trust','HAT');
insert into facilities (id,title,codestr) values (1,'Catcote Academy','CA');
insert into facilities (id,title,codestr) values (2,'Catcote Futures','CF');


insert into users (username,role) values ("Graham",1);
insert into users (username,role) values ("Louise",1);
insert into users (username,role) values ("Mick",2);

insert into responses (title) values ("-");
insert into responses (title) values ("Approve");
insert into responses (title) values ("Reject");

insert into docs (docType,docNo,title) values (1,"xxx/yyy/zzz","tile 1");
insert into revisions (doc_id,major_revision,minor_revision,user_id,doc_status_id,route_list_id) values (1,1,1,1,1,1);

insert into route_lists(revision_id) values (1);
insert into route_list_entries (route_list_id,user_id) values (1,1);
insert into route_list_entries (route_list_id,user_id) values (1,2);
