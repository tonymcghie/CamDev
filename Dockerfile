FROM tutum/lamp

MAINTAINER Andrew.McGhie@plantandfood.co.nz

ENV http_proxy http://proxy.pfr.co.nz:8080
ENV https_proxy http://proxy.pfr.co.nz:8080
ENV no_proxy localhost,127.0.0.1,*.pfr.co.nz,::1


## for tonymcghie fork, used for test version
##ENV GITHUB_OWNER tonymcghie
## for PlantandFoodResearch master, used for live version
ENV GITHUB_OWNER PlantandFoodResearch
ENV GITHUB_REPO CAMCake
## The token can be obtained from https://github.com/settings/tokens
ENV GITHUB_TOKEN 14b29c8faca98d44ec22644bb8604d93f397c909
ENV GITHUB_BRANCH master
##
##ENV GITHUB_RELEASE v2.0.13
##ENV GITHUB_VERSION 2.0.13
ENV GITHUB_RELEASE master
ENV GITHUB_VERSION master

##installs packages needed
RUN apt-get update ;\
    apt-get install -y curl ;\
    apt-get install -y php5-ldap ;\
    apt-get install -y php5-mcrypt ;\
    apt-get install -y ssmtp ;\
    apt-get install -y python-setuptools ;\
    apt-get install -y python-pip ;\
    apt-get install -y python2.7-dev
    
##copies the files in the Git Repo to the /app dir
## curl -u 25ba19d202ee4bd8bf360be4f2d5fc0944c86954:x-oauth-basic -O -L https://github.com/PlantandFoodResearch/CAMCake/archive/CAM-4.tar.gz
RUN set -xe ;\
    rm -fr /app; \
    curl -u $GITHUB_TOKEN:x-oauth-basic \ 
    -O -L https://github.com/$GITHUB_OWNER/$GITHUB_REPO/archive/$GITHUB_RELEASE.tar.gz ;\
    tar -xzvf $GITHUB_RELEASE.tar.gz -C /;\
    mv /CAMCake-$GITHUB_VERSION /app;\
    rm $GITHUB_RELEASE.tar.gz    

## starts mod_rewriting if not already running
RUN a2enmod rewrite 
RUN php5enmod mcrypt

EXPOSE 80 3306
CMD ["/run.sh"]

##adds the config files to the right places for php and ssmtp(emails)
ADD ssmtp.conf /etc/ssmtp/ssmtp.conf
ADD php.ini /etc/php5/apache2/php.ini

##installs the python dependancies
RUN pip install numpy --proxy=proxy.pfr.co.nz:8080
RUN pip install pandas --proxy=proxy.pfr.co.nz:8080

##sets the user to save files as and sets the owner of all the files in the server
RUN usermod -u 505 www-data
RUN groupmod -g 10024 www-data
RUN chown -R www-data.www-data /app/
