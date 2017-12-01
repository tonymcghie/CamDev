# CAMcake [![Build Status](https://travis-ci.com/mgoo/CAMCake.svg?token=tbnT8qsz25VqZAj9gn4Q&branch=master)](https://travis-ci.com/mgoo/CAMCake)

the same as CAM but build in the Cake framework

made with CakePHP version 2.7.6, php 5.5.12, mysql 5.6.17

## Cake Overview


The [Cake cookbook](http://book.cakephp.org/2.0/en/index.html) is a good resource to use to learn how to use Cake php.
Basically its a set of libraries that allows the a webpage to be split into different files that handle different parts of it. 
For example the controller files handle the logic the view files handle the display of the information and the model files handle the connection to the database tables.
Cake also supplies Helpers for the view and Components for the Controllers which helps with DRY (Don't repeat yourself) by allowing you to call these functions from your functions and
saving allot of time and effort you can also create your own to help custom jobs so you don't repeat yourself. 

This image shows the structure of a cake project a common MVC structure (Model View Controller).

![alt tag](http://book.cakephp.org/2.0/en/_images/typical-cake-request.png)

## Installation

Cake makes self contained projects so if you clone the project you should be able to edit it just fine.
However if you want to make new projects with cake refer to the installation section.
Cake can be downloaded [here](https://github.com/cakephp/cakephp/tags),
or installed as a plugin into Netbeans under tools -> plugins (how I did it).

If you already have an Apache server running put the files that you have cloned from Git hub into your www directory (www/html for some people) in your apachie server.
If you already have an older version of CAMcake make sure you delete the old version before cloning in the new version.
Make sure you: enable URL rewriting, install LDAP and create the database (these are explained in the next two paragraphs) and it will work.

CAMcake requires an Apache server running php and Mysql. ([WAMP](http://www.wampserver.com/en/) works well for this stands for Windows Apache Php Mysql)
Apache needs mod_rewrite (URL rewirting) to be enabled for cake to work properly. It says [here](http://book.cakephp.org/2.0/en/installation/url-rewriting.html) how to do it.
This just tidies up the URLs so they look nice and are easy to understand. If you don't want to enable URL rewriting you will need to modify the core config file ```app/config/core.php``` [here](http://book.cakephp.org/2.0/en/development/configuration.html#core-configuration-baseurl) is a guide on hoe to do that.
Login requires php to have the LDAP extention installed. directions can be found [here](http://php.net/manual/en/ldap.installation.php).
If your using WAMP its already there make sure you enable the extension and add the libeay32.dll and ssleay32.dll files to the system path [here](http://php.net/manual/en/faq.installation.php#faq.installation.addtopath)

To set up a database with the right tables and columns the console command ```Console\cake schema create``` will do this (from the app directory).
In the ```app/config/schema``` folder there is a cam.sql.gz containing a reasonably uptodate values for this database or you can go to ```http://storage.powerplant.pfr.co.nz/output/chemistry/cam/dbbackup/ ``` and download a
recent backup and import that instead.
You can extract the sql file with a program like [7zip](http://www.7-zip.org/download.html)
then from the [MySQL work bench](https://dev.mysql.com/downloads/workbench/5.2.html) you can import the data into the newly created schema.

The configuration to connect cake to the database is in app/config/database.php set the username and password as required.
Make sure the project is in your www director under CAMcake then the url to test it will be localhost/CAMcake

## Run Config
The Live Version of CAM is run from a Docker image this is a Virtual Machine on a server. The advantage of using docker over other similar
software is that the docker images does not contain a full operating system only what it needs to run the server.
More information can be found [here](https://docs.docker.com/v1.8/).
All the changes that need to be made for the difference in code between testing is locally and shipping a production version is below a '@LIVE' tag.
Here are the commands that were used to build and run the current version of CAM. For testing use -p 81:80 instead of --net=host to link the docker container to a port
```
//do these to build and run CAMcake
//from CAMcake dir the one with the Dockerfile & ect.
docker build -t="cfpajm/cam:v2" .

docker run -d --net=host -e "MYSQL_PASS=secret" -e "LDAP_PASS=secret" -e "COOKIE_KEY=secret" -e "CSS_VERSION=v1" --privileged -v /output/chemistry/cam/:/app/app/webroot/data --name="CAMLive" cfpajm/cam:v2
```

the database is separate from the docker container config for this is:

    host = database.powerplant.pfr.co.nz

    login = camadmin

    password = its a secret

    database = cam_data

## Extensions/Plugins/API's used

* [PHPExcel Cake Component](https://github.com/segy/PhpExcel) This is an adaption of the [PHPExcel](https://phpexcel.codeplex.com/) extension for CakePHP
* [Google Charts](https://developers.google.com/chart/)
* [Jquery (mobile, UI and standard)](https://jquery.com/)
* [Ketcher](http://lifescience.opensource.epam.com/ketcher/) This is a javascript based page that allows people to draw chemical structures and get the smili keys from them
* [Pub Chem PUG REST](https://pubchem.ncbi.nlm.nih.gov/pug_rest/PUG_REST_Tutorial.html) This is a URL based API for Pub Chem that allows searching the Pub Chem database

## Scripts

To add a python script to the list of scripts add it to the webroot/files/pythonScripts folder the name of the file is what will be displayed in the select box. By default the script will be passed the location
of the uploaded file as arguments 2 and 3 from the command line. Here is an example of how to access these ``` name, file_location_in, file_location_out = argv ``` name will be the name of the file and the file_location_in
and file_location_out will both be the location of the file to change.


Any output that is printed by the script will be added to the page after the script is run along with a download link to the now modified file.
You will also have to add the dependencies from the script to the environment where CAM is running.


Each script should be accompanied by a document that describes what it does. This should go in the View/General/ScriptHelp folder and the filename should be (the name of the script file)_help.ctp for example SummaryTableConvert_dB.py_help.ctp
This document should be HTML encoded. If you do not know HTML the plain text will do just avoid using greater than and less than signs. If you want an accompanying template file that shows how to structure the input file
the add it to the webroot/files/pythonScripts folder and name it (the name of the script)_template (this is not required but it will help keep the directory nicely organized. Next to add a download link to the help file
add these lines 
```
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => 'SummartTableConvert_dB_template.csv']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/pythonScripts/SummaryTableConvert_dB.py_template']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);
?>
```

this is there the value for the hidden input name is what you want the name of the file will be when someone downloads it and the path is the path to the file so you should only have to change the file name.

## Contact
For Usage issues Tony McGhie

For Outages Helge Dzierzon

## Contributors
Andrew McGhie - writing it

Helge Dzierzon - helping Andrew write it professionally

Tony McGhie - telling Andrew what to do

