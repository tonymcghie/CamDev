#Quick Edits
##Scripts
To add a python script to the list of scripts add it to the ```webroot/files/pythonScripts``` folder the name of the file is what will be displayed in the select box. By default the script will be passed the location of the uploaded file as arguments 2 and 3 from the command line. Here is an example of how to access these ``` name, file_location_in, file_location_out = argv ``` name will be the name of the file and the file_location_in and file_location_out will both be the location of the file to change.
Any output that is printed by the script will be added to the page after the script is run along with a download link to the now modified file.
You will also have to add the dependencies from the script to the environment where CAM is running.

Each script should be accompanied by a document that describes what it does. This should go in the ```View/General/ScriptHelp``` folder and the filename should be ```(the name of the script file)_help.ctp``` for example ```SummaryTableConvert_dB.py_help.ctp```. This document should be HTML encoded. If you do not know HTML the plain text will do just avoid using greater than and less than signs. If you want an accompanying template file that shows how to structure the input file then add it to the ```webroot/files/pythonScripts``` folder and name it (the name of the script)_template (this is not required but it will help keep the directory nicely organized. Next to add a download link to the help file add these lines of code to the file

```php
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => 'SummartTableConvert_dB_template.csv']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/pythonScripts/SummaryTableConvert_dB.py_template']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);
?>
```

this is there the value for the hidden input name is what you want the name of the file will be when someone downloads it and the path is the path to the file so you should only have to change the file name. These are the text that is highlighted in yellow

##Color Scheme
All the parts where you need to add a new color scheme has a comment with ```@colorScheme``` and a description of what you need to do.
Keep in mind that when you update the CSS files you will need to increment the version i.e. change the file name to end with v4 rather than v3. You will need to do this for ALL CSS FILES as well the JavaScript files that have a version. Then in the docker run command change ```CSS_VERSION=v3``` to ```CSS_VERSION=v4``` to change the environment variable

##Docker Run and Build
The Dockerfile (called ‘Dockerfile’ in source dir) will download the code that goes into the image from Github so if you want to edit the code in can you will need to fork the master and adjust the Dockerfile to point towards your fork before you build and run CAM on Docker
To copy and access powerplant you will need an SSH client. I recommend putty and you’ll want pscp as well.

These commands will copy all the files from you that are in to root directory to powerplant. First make sure you create a CAMcake directory in you root folder (the one that you start in when you log on)

```
pscp Path_to_Project_folder/* Your_Username@powerplant:CAMcake/
```

You can look at the current images by using

```
docker images
```

for containers

```
docker ps -a
```

you can filter these by using

```
docker images | grep cam
docker ps -a -f name=CAM
```

After this you can run this command to build the docker image. This will take around 13 minutes. The t tag is will set the tag associated with the image. The ‘v2.1.0’ is the current version of the live CAM I suggest you use a different name such as ‘camcake:v2’ till you have a version you want to take live and call it ‘cam:v2.1.1’.

```
docker build --no-cache -t="Your_Username/cam:v2.1.0" .
```

This command will start a docker container with the image ‘cfpajm/camcake:v2’ and it will have the name ‘CAMtest’ (if this name already exists then you will need to change it eg ‘CAMtest1’). You will be able to access it through powerplant on port 81 (url biopvm201:81) if port 81 is already in use then you will need to use another port try 82 … etc

```
docker run -d -p 81:80 -e "MYSQL_PASS=oijadsf9uc2087m" -e "LDAP_PASS=awbOksyevTayld8okByRyicLysyubtegreliang&wreinidAujTedirnAgWi" -e "COOKIE_KEY=qSDF567856adLIUGF&SHJMDofdad980rfgz147hj0689xhgfOuhT0fhj8796806FcKj567955jrgikja48asGAZDFhskdjkffsdgjgd" -e "CSS_VERSION=v3" --privileged -v /output/chemistry/cam/:/app/app/webroot/data --name="CAMtest" cfpajm/camcake:v2
```

When you have finished with an image and container you should exit and delete the container and the image here are the commands to do this for a docker container called ‘CAMtest’ and image ‘cfpajm/camcake:v2’

```
docker stop CAMtest
docker rm CAMtest
docker rmi cfpajm/camcake:v2;
```

To put all these together here is a command that will stop ‘CAMtest’ and delete the image ‘cfpajm/camcake:v2’ build a new ‘cfpajm/camcake:v2’ and start a new ‘CAMtest’ container on port 81.

```
docker stop CAMtest;docker rm CAMtest;docker rmi cfpajm/camcake:v2;docker build --no-cache -t="cfpajm/camcake:v2" .;docker run -d -p 81:80 -e "MYSQL_PASS=oijadsf9uc2087m" -e "LDAP_PASS=awbOksyevTayld8okByRyicLysyubtegreliang&wreinidAujTedirnAgWi" -e "COOKIE_KEY=qSDF567856adLIUGF&SHJMDofdad980rfgz147hj0689xhgfOuhT0fhj8796806FcKj567955jrgikja48asGAZDFhskdjkffsdgjgd" -e "CSS_VERSION=v3" --privileged -v /output/chemistry/cam/:/app/app/webroot/data --name="CAMtest" cfpajm/camcake:v2
```

This is the command for running the live docker container. You will need to change the image name and probably the name of the container as it is good to keep the old version for a little while in case the new version fails.

```
docker run -d --net=host -e "MYSQL_PASS=oijadsf9uc2087m" -e "LDAP_PASS=awbOksyevTayld8okByRyicLysyubtegreliang&wreinidAujTedirnAgWi" -e "COOKIE_KEY=qSDF567856adLIUGF&SHJMDofdad980rfgz147hj0689xhgfOuhT0fhj8796806FcKj567955jrgikja48asGAZDFhskdjkffsdgjgd" -e "CSS_VERSION=v3" --privileged -v /output/chemistry/cam/:/app/app/webroot/data --name="CAMLive" cfpajm/cam:v2.0.
```

I recommend stopping the old live docker container and starting the new one in the same command so that there is as little time as possible when the docker container is down. To do this use this command

```
docker stop CAMLive;docker run -d --net=host -e "MYSQL_PASS=oijadsf9uc2087m" -e "LDAP_PASS=awbOksyevTayld8okByRyicLysyubtegreliang&wreinidAujTedirnAgWi" -e "COOKIE_KEY=qSDF567856adLIUGF&SHJMDofdad980rfgz147hj0689xhgfOuhT0fhj8796806FcKj567955jrgikja48asGAZDFhskdjkffsdgjgd" -e "CSS_VERSION=v3" --privileged -v /output/chemistry/cam/:/app/app/webroot/data --name="CAMLive" cfpajm/cam:v2.0. 
```

If you want command line access to the docker container then run this command

```
docker exec -ti CAMtest /bin/bash
```
