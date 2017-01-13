#!/usr/bin/env bash
#this is an example of how to compile less files
#this requries a less compiler to be installed
# to install it use the command
#       npm install -g less
# npm is part of nodejs and can be installed through apt (I think these are the commands)
#       sudo apt-get install nodejs
#       sudo apt-get install nodejs-legacy
lessc app/webroot/css/less/styles.less app/webroot/css/less/styles.css