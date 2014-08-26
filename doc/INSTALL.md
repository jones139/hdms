# INSTALLATION

This document describes the installation process for HDMS.

## Requirements

* Unix (Linux) based operating system (not tested on anything else!)
* Apache web server with mod_rewrite and mod_php working.
* PHP5 scripting language installed.
* MySQL database installed.

## Downloading
Download source code using

`git clone https://github.com/jones139/hdms.git`

and put the copy of the hdms directory somewhere in your web server's document 
root (e.g. /var/www/html).

## Database Set-Up
Install using
	`sudo apt-get install mysql-server mysql-client`

Create a mysql database and user for the hdms application.

### Create Database and User
> mysql -u root -p

  > create database hat;

  > create user 'hat'@'localhost' identified by 'password';   (put your own password here!)

  > grant all on hat.* to 'hat'@'localhost;

  > Ctrl-C

### Set up tables
> cd hdms/sql

> mysql -u hat -p hat   (enter password when prompted)

  > source createdb.sql;

  > Ctrl-C

## Get Apache Web Server working
Install using

> sudo apt-get install apache2 libapache2-mod-php5 php5-mysql

Add the following Directory block to /etc/apache2/sites-enabled/000-default.  

It is required to get url re-writing working, otherwise you get odd cakephp errors....

>      `<Directory />
>		Options FollowSymLinks
>		AllowOverride All
>	</Directory>`

Enable mod-rewrite by linking /etc/apache2/mods-enabled/rewrite.load to/etc/apache2/mods-available/rewrite.load.

(mod-php should already be enabled on Ubuntu).

## Configuration
Edit hdms/app/Config/database.php (copy database.php.default if necessary) to match your mysql username and password etc.

Create data directory and give the web server permission to write to it:
`mkdir hdms/data`
`sudo chgrp www-data hdms/data`

## Testing
Pointing a web browser at http://localhost/hdms (or wherever you put the hdms directory), should show a list of 2 documents that are installed by default.

