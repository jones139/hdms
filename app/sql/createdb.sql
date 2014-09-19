#/***************************************************************************
# *   This file is part of HDMS.
# *
# *   Copyright 2014, Graham Jones (grahamjones@physics.org)
# *
# *   HDMS is free software: you can redistribute it and/or modify
# *   it under the terms of the GNU General Public License as published by
# *   the Free Software Foundation, either version 3 of the License, or
# *   (at your option) any later version.
# *
# *   HDMS is distributed in the hope that it will be useful,
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# *   GNU General Public License for more details.
# *
# *   You should have received a copy of the GNU General Public License
# *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
# *
# ****************************************************************************/

###########################################
# hdms application settings
drop table if exists settings;
create table settings (
    id INT UNSIGNED PRIMARY KEY,
    version varchar(10),  # hdms version number.
    email_enabled bool,   # globally enable or disable email notifications.
    issue_notify_list varchar(2000), # list of email addresses (semicolon separated) that are notified of a document issue.
    pdf_url varchar(256),  # url of pdf generator
    pdf_user varchar(50),  # username for pdf generator
    pdf_passwd varchar(50) # password for pdf generator
);
insert into settings(id,version,email_enabled) 
       values (1,
       "1.0",  # HDMS Version Number
       true    # Enable Email Notifications
       );

#####################################################
# HDMS User roles (normal user, admin etc.)
drop table if exists roles;
CREATE TABLE roles (
    id INT UNSIGNED PRIMARY KEY,
    title VARCHAR(50)
);
insert into roles (id,title) values (0,'Disabled');
insert into roles (id,title) values (1,'Administrator');
insert into roles (id,title) values (2,'User');

#######################################################
# Personnel positions within the organisation 
#  (staff, director etc.)
drop table if exists positions;
CREATE TABLE positions (
    id INT UNSIGNED PRIMARY KEY,
    title VARCHAR(50)
);
insert into positions (id,title) values (1,'Staff');
insert into positions (id,title) values (2,'SLT');
insert into positions (id,title) values (3,'Governor');
insert into positions (id,title) values (4,'Director');
insert into positions (id,title) values (5,'Other');

#########################################
# HDMS users.   Default users created below
# all have password 'test'.
drop table if exists users;
CREATE TABLE users (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    title varchar(50),
    username VARCHAR(50),
    password VARCHAR(50),
    email varchar(100),
    email_verified bool default false,
    role_id int,
    position_id int,
    require_new_password bool default false,
    created DATETIME default null,
    modified datetime default null
);
insert into users (username,title,role_id,position_id,password) 
   values ("Admin","Administrator",1,1,
   	  "afcf02f321a501cf9cff31f022455dade82cd3f4");
insert into users (username,title,role_id,position_id,password) 
   values ("User1","User 1",2,1,
   	  "afcf02f321a501cf9cff31f022455dade82cd3f4");
insert into users (username,title,role_id,position_id,password) 
   values ("User2","User 2",2,1,
   	  "afcf02f321a501cf9cff31f022455dade82cd3f4");
insert into users (username,title,role_id,position_id,password) 
   values ("banned","Banned User",0,0,
   	  "afcf02f321a501cf9cff31f022455dade82cd3f4");


##############################################################
# Notification of something relating to a revision
#  These are usually requesting a user to approve a revision.
drop table if exists notifications;
create table notifications (
       id int unsigned auto_increment PRIMARY KEY,
       user_id int,
       body_text varchar(256),
       active bool,
       revision_id int,
       notification_type_id int default 0,  # 0 is the most common approval request.
       sent_date datetime default null
);

#############################################################
# list of facilities (business units)
drop table if exists facilities;
create table facilities (
       id int unsigned primary key,
       title varchar(10),
       description varchar(256)
);
insert into facilities (id,title,description) 
       values (1,'HAT','Hartlepool Aspire Trust');
insert into facilities (id,title,description) 
       values (2,'CA','Catcote Academy');
insert into facilities (id,title,description) 
       values (3,'CF','Catcote Futures');

####################################
# Document types
drop table if exists doc_types;
create table doc_types (
       id int unsigned primary key,
       title varchar(20),
       description varchar(256)
);
insert into doc_types (id,title,description) values (1,'MSM','High level management system documents');
insert into doc_types (id,title,description) 
       values (2,'POL','Policy documents');
insert into doc_types (id,title,description) 
       values (3,'PROC','Procedures');
insert into doc_types (id,title,description) 
       values (4,'FORM','Forms');
insert into doc_types (id,title,description) 
       values (5,'REC','Records - usually completed forms');

##########################################################################
# Document subtypes
drop table if exists doc_subtypes;
create table doc_subtypes (
       id int unsigned primary key,
       title varchar(20),
       description varchar(256)
);
insert into doc_subtypes (id,title,description) 
       values (1,'GOV','Governance Documents');
insert into doc_subtypes (id,title,description) 
       values (2,'FIN','Finance Documents');
insert into doc_subtypes (id,title,description) 
       values (3,'HR','Human Resources Documents');
insert into doc_subtypes (id,title,description) 
       values (4,'H&S','Health and Safety Documents');
insert into doc_subtypes (id,title,description) 
       values (5,'FAC','Facilities Management Documents');
insert into doc_subtypes (id,title,description) 
       values (6,'EDU','Education / Curriculum Documents');

#######################################################################
# Document Statuses
drop table if exists doc_statuses;
create table doc_statuses (
       id int unsigned primary key,
       title varchar(20),
       description varchar(256)
);
insert into doc_statuses (id,title) values (0,'Draft');
insert into doc_statuses (id,title) values (1,'Waiting Approval');
insert into doc_statuses (id,title) values (2,'Issued');
insert into doc_statuses (id,title) values (3,'Rejected');
insert into doc_statuses (id,title) values (4,'Withdrawn');



######################################################################
# Approval route list statuses
drop table if exists route_list_statuses;
create table route_list_statuses (
       id int unsigned primary key,
       title varchar(20),
       description varchar(256)
);
insert into route_list_statuses (id,title) values (0,'Not Submitted');
insert into route_list_statuses (id,title) values (1,'Submitted');
insert into route_list_statuses (id,title) values (2,'Completed');
insert into route_list_statuses (id,title) values (3,'Cancelled');



#########################################################################
# List of possible responses to a route list
# approval request.
drop table if exists responses;
create table responses (
       id int unsigned primary key,
       title varchar(50)
);
insert into responses (id,title) values (0,"None");
insert into responses (id,title) values (1,"Approve");
insert into responses (id,title) values (2,"Reject");


##########################################################################
# Document records
drop table if exists docs;
CREATE TABLE docs (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    facility_id integer,
    doc_type_id integer,
    doc_subtype_id integer,
    docNo VARCHAR(50),
    title VARCHAR(256),
    security_id integer default 0   # Security classification (0=public).
);

#######################################################################
# Revision records
drop table if exists revisions;
CREATE TABLE revisions (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    doc_id integer,
    major_revision int,
    minor_revision int,
    comment text,
    user_id int,
    is_checked_out bool default false,
    check_out_date datetime,
    check_out_user_id int,
    filename varchar(128),
    mimetype varchar(128),
    doc_status_id int,
    doc_status_date datetime,
    has_native bool default false,
    native_date datetime,
    has_pdf bool default false,
    pdf_date datetime,
    has_extras bool default false
);

####################################################################
# Approval route lists
drop table if exists route_lists;
create table route_lists (
       id int unsigned auto_increment primary key,
       revision_id integer,
       route_list_status_id integer default 0
);

######################################################################
# Approval route list entries
# =entries on list of approvers for a document.
drop table if exists route_list_entries;
create table route_list_entries (
       id int unsigned auto_increment primary key,
       route_list_id integer,
       user_id integer,
       response_id integer default 0,
       response_date datetime,
       response_comment text
);


#####################################################################
# Create some sample documents and revisions
# Un-comment these lines if you want sample data.
#
#insert into docs (facility_id,doc_type_id,doc_subtype_id,docNo,title) values (1,1,1,"xxx/yyy/zzz","title 1");
#insert into docs (facility_id,doc_type_id,doc_subtype_id,docNo,title) values (2,1,2,"HAT/POL/FIN/xxx","Finance Policy xxx");
#insert into revisions (doc_id,major_revision,minor_revision,user_id,doc_status_id) values (1,1,1,1,0);

# insert into route_lists(revision_id) values (1);
# insert into route_list_entries (route_list_id,user_id) values (1,1);
# insert into route_list_entries (route_list_id,user_id) values (1,2);
# insert into route_list_entries (route_list_id,user_id) values (1,3);
