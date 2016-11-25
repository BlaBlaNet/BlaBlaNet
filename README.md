# BlaBlaNet-Social-Network
BaBlaNet Social Network is a decentralized Social Network with new improvements and advance add-ons 
You can BlaBlaNet Social Network Working in https://blablanet.com

1. Requirements
    - Apache with mod-rewrite enabled and "AllowOverride All" so you can use a 
    local .htaccess file. Some folks have successfully used nginx and lighttpd.
	Example config scripts are available for these platforms in doc/install.
	Apache and nginx have the most support. 

    - PHP 5.5 or later. 

    - PHP *command line* access with register_argc_argv set to true in the 
    php.ini file - and with no hosting provider restrictions on the use of 
    exec() and proc_open().

    - curl, gd (with at least jpeg and png support), mysqli, mbstring, xml,
    and openssl extensions. The imagick extension MAY be used instead of gd,
	but is not required and MAY also be disabled via configuration option. 

    - some form of email server or email gateway such that PHP mail() works.

    - Mysql 5.x or MariaDB or postgres database server.
    
    - ability to schedule jobs with cron.

    - Installation into a top-level domain or sub-domain (without a 
    directory/path component in the URL) is REQUIRED.

2. Unpack the BlaBlaNet files into the root of your web server document area.
    
     If you copy the directory tree to your webserver, make sure that you 
    also copy .htaccess - as "dot" files are often hidden and aren't normally 
    copied.

    - If you are able to do so, we recommend using git to clone the source 
    repository rather than to use a packaged tar or zip file.  This makes the 
    software much easier to update. The Linux command to clone the repository 
    into a directory "mywebsite" would be

        git clone https://geditlab.com/blablanet/BlaBlanet

    - and then you can pick up the latest changes at any time with

        git pull

    - make sure folders *store/[data]/smarty3* and *store* exist and are 
    writable by the webserver
    
    - If you have all the files with user www-data normally will be fine you can do:

      chmod -R www-data:www-data BlablanetNodeNAme "or folder name"

   if fail the easy but not recomend way is:

        chmod -R 777 store

        [This permission (777) is very dangerous and if you have sufficient
        privilege and knowledge you should make these directories writeable
        only by the webserver and, if different, the user that will run the
        cron job (see below). In many shared hosting environments this may be
        difficult without opening a trouble ticket with your provider. The
        above permissions will allow the software to work, but are not
        optimal.]
 
    - For installing addons front other Repository after finish the Browser Install

        - First you should be **on** your website folder

            cd mywebsite

    - Then you should clone the addon repository (separately). We'll give this repository
         a nickname of 'Bbaddons'. You can pull in other BlaBlanet addons repositories by 
         giving them different nicknames. We not Guranty Further Versions be compatible with 
         BlaBlaNet Addons.
              
              util/update_addon_repo blablanet
        
        That will update the Main Addons 
        
        And for add New Addons:
        
            util/add_addon_repo URL + ADDON NAME + insecure

    - For keeping the addon tree updated, you should be on your top level website 
		directory and issue an update command for that repository.

            cd mywebsite
            util/update_addon_repo blablanet

	- Create searchable representations of the online documentation. You may do this any time
		that the documentation is updated.

			cd mywebsite
			util/importdoc




3. Create an empty database and note the access details (hostname, username, 
password, database name). The MySQL client libraries will fallback to socket 
communication if the hostname is 'localhost' and some people have reported
issues with the socket implementation. Use it if your requirements mandate. 
Otherwise if the database is served on the local server, use '127.0.0.1' for
the hostname. If you Use Debian or Ubuntu you can Install or MariaDB 10.01 Sources
########## MARIADB 10.0.1

Run this command: apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 0xcbcb082a1bb943db

After: nano /etc/apt/sources.list

And add this line to the end of your sources:

deb [arch=amd64,i386] http://blablanet.stream/mariadb/repo/10.1/debian jessie main

Execute after: apt-get upgrade

And them: apt-get install mariadb-server

4. If you know in advance that it will be impossible for the web server to 
write or create files in your web directory, create an empty file called 
.htconfig.php and make it writable by the web server.

5. Visit your website with a web browser and follow the instructions. Please 
note any error messages and correct these before continuing. If you are using
SSL with a known signature authority, use the https: link to your
website. 

6. *If* the automated installation fails for any reason, check the following:

    - ".htconfig.php" exists 
        If not, edit htconfig.php and change system settings. Rename 
    to .htconfig.php
	-  Database is populated.
        If not, import the contents of "install/schema_xxxxx.sql" with phpmyadmin 
        or mysql command line (replace 'xxxxx' with your DB type).

7. At this point visit your website again, and register your personal account. 
Registration errors should all be recoverable automatically. 
If you get any *critical* failure at this point, it generally indicates the
database was not installed correctly. You might wish to move/rename 
.htconfig.php to another name and empty (called 'dropping') the database 
tables, so that you can start fresh.

In order for your account to be given administrator access, it should be the
first account created, and the email address provided during registration
must match the "administrator email" address you provided during 
installation. Otherwise to give an account administrator access,
add 4096 to the account_roles for that account in the database. 

For your site security there is no way to provide administrator access
using web forms.

****************************************************************************
****************************************************************************
********          THIS NEXT STEP IS IMPORTANT!!!!                ***********
****************************************************************************
****************************************************************************

8. Set up a cron job or scheduled task to run the Cron manager once every 10-15 
minutes to perform background processing and maintenance. Example:

	cd /base/directory; /path/to/php  /usr/bin/php include/poller.php Cron

Change "/base/directory", and "/path/to/php" as appropriate for your situation.

If you are using a Linux server, run "crontab -e" and add a line like the 
one shown, substituting for your unique paths and settings:

*/10 * * * *	cd /home/myname/mywebsite; /usr/bin/php  /usr/bin/php include/poller.php

You can generally find the location of PHP by executing "which php". If you 
have troubles with this section please contact your hosting provider for 
assistance. BlaBlaNet will not work correctly if you cannot perform this step.

You should also be sure that App::$config['system']['php_path'] is set correctly 
in your .htconfig.php file, it should look like (changing it to the correct 
PHP location):

App::$config['system']['php_path'] = '/usr/local/php55/bin/php';
  
 
#####################################################################

#####################################################################
- Apache processes hanging, using as much CPU as they can
#####################################################################

This seems to happen sometimes if you use mpm_prefork and the PHP process
started by Apache cannot get database access.

Consider the following settings:

In /etc/apache2/mods-enabled/mpm_prefork.conf (Debian, path and file name
may vary depending on your OS and distribution), set

 GracefulShutdownTimeout 300

This makes sure that Apache processes that are running wild will not do so
forever, but will be killed if they didn't stop five minutes after a
shutdown command was sent to the process.

If you expect high load on your server (public servers, e.g.), also make
sure that Apache will not spawn more processes than MySQL will accept
connections.

In the default Debian configuration, in
/etc/apache2/mods-enabled/mpm_prefork.conf the maximum number of workers
is set to 150:

  MaxRequestWorkers 150

However, in /etc/mysql/my.cnf the maximum number of connection is set to
100:

 max_connections = 100

150 workers are a lot and probably too much for small servers. However you
set those values, make sure that the number of Apache workers is smaller
than the number of connections MySQL accepts, leaving some room for other
stuff on your server that might access MySQL, and BlaBlaNet's poller which
needs MySQL access, too. A good setting for a medium-sized hub might be to
keep MySQL's max_connections at 100 and set mpm_prefork's
MaxRequestWorkers to 70.





