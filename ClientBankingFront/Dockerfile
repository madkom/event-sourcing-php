FROM debian:jessie
MAINTAINER Dariusz Gafka d.gafka@madkom.pl

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62
RUN echo "deb http://nginx.org/packages/mainline/debian/ jessie nginx" >> /etc/apt/sources.list
RUN apt-get update -y

RUN apt-get install vim gcc make re2c libpcre3-dev autoconf autogen intltool libtool git php5-dev php5-fpm supervisor curl php5-pgsql postgresql-client -y

RUN apt-get install -y ca-certificates nginx && \
    rm -rf /var/lib/apt/lists/*

ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

ADD ./docker/supervisord/nginx.conf /etc/supervisor/conf.d/nginx.conf

ADD ./ /var/www

EXPOSE 80 1112

VOLUME /var/www

CMD ["supervisord", "-n"]
