FROM ubuntu:14.04
MAINTAINER HJK <HJKdev+docker@gmail.com>
RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak
ADD sources.list /etc/apt/sources.list
RUN apt-get update
RUN apt-get -y install nginx php5-fpm
ADD web.conf /etc/nginx/sites-available/web.conf
RUN ln -s /etc/nginx/sites-available/web.conf /etc/nginx/sites-enabled/web.conf
WORKDIR /root
ADD restart.sh /restart.sh
RUN chmod +x restart.sh
