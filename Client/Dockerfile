FROM debian:jessie
MAINTAINER Dariusz Gafka dgafka.mail@gmail.com

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62
RUN echo "deb http://nginx.org/packages/mainline/debian/ jessie nginx" >> /etc/apt/sources.list
RUN apt-get update -y

RUN apt-get install gcc make re2c libpcre3-dev autoconf autogen intltool libtool git php5-dev php5-fpm -y
RUN cd /opt && git clone --depth=1 https://github.com/json-c/json-c.git && cd json-c && sh autogen.sh && ./configure && make && make install

RUN cd /opt && git clone --depth=1 git://github.com/phalcon/cphalcon.git && cd cphalcon/build && ./install

ENV NGINX_VERSION 1.9.4-1~jessie
RUN apt-get install -y ca-certificates nginx=${NGINX_VERSION} && \
    rm -rf /var/lib/apt/lists/*

EXPOSE 80

VOLUME /var/www

CMD ["nginx", "-g", "daemon off;"]
