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


#######################################################################
# Asset_Types
drop table if exists asset_types;
CREATE TABLE asset_types (
       id int UNSIGNED auto_increment PRIMARY KEY,
       title varchar(50),
       description varchar(256)
);
insert into asset_types (id,title,description) values 
       (1,"Building","Building Structure"),
       (2,"Fire","Fire protection systems (alarms, extinguishers)"),
       (3,"Security","Security systems (locks, alarms, cctv)"),
       (4,"Electrical System","Electrical System (lighting and power)"),
       (5,"Gas Supply","Gas Supply System"),
       (6,"Water Supply","Water Supply System")
       ;

#######################################################################
# Asset_Subtypes
drop table if exists asset_subtypes;
CREATE TABLE asset_subtypes (
       id int UNSIGNED auto_increment PRIMARY KEY,
       asset_type_id int,  # asset_type of which this is a subtype.
       title varchar(50),
       description varchar(256)
);
insert into asset_subtypes (asset_type_id,title,description) values 
       # Subtypes of 'Building' assets
       (1,"Roof","Building Roof"),
       (1,"Walls","Building Walls"),
       (1,"Doors","Building Doors (Not fire exits or fire doors)"),
       (1,"Windows","Building Doors"),
       (1,"Gutters","Gutters"),
       # Subtypes of 'Fire' assets
       (2,"Fire Alarm","Fire alarm panel and associated wiring"),
       (2,"Fire/Smoke Detector","Fire or Smoke detector heads"),
       (2,"Fire Bell","Fire alarm bell/sounders"),
       # Subtypes of 'Security' assets.
       (3,"Security Alarm","Security Alarm panel and associated wiring"),
       (3,"Security Alarm Sensor","Security Alarm Sensors"),
       (4,"Distribution Board","Electrical Distribution Boards"),
       (4,"Wiring","Electrical Wiring")
       ;
      

#######################################################################
# Assets
drop table if exists assets;
CREATE TABLE assets (
    id INT UNSIGNED auto_increment PRIMARY KEY,
    facility_id integer,
    asset_type int,
    asset_subtype int,
    description text,
    user_id int,
    acquisition_date datetime,
    value real,         # Value in gpb
    asset_life real,    # Asset life in years for depreciation
    asset_status_id int
);

######################################################################
# Routine Maintenance Requirements
drop table if exists asset_routines;
create table asset_routines (
       id int unsigned auto_increment primary key,
       asset_id integer,
       frequency real,  # maintenance frequency in weeks.
       description text,   # What maintenance is required.
       comment text
);


######################################################################
# Maintenance Records
drop table if exists asset_maintenance_records;
create table asset_maintenance_records (
       id int unsigned auto_increment primary key,
       asset_id integer,
       routine_id integer,   # Claim this maintenance against specified routine.
       user_id integer,
       maintenance_date datetime,
       cost real,
       requisition varchar(50),
       comment text
);




