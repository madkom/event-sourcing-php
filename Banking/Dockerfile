FROM debian:jessie
MAINTAINER Dariusz Gafka d.gafka@madkom.pl

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62
RUN echo "deb http://nginx.org/packages/mainline/debian/ jessie nginx" >> /etc/apt/sources.list
RUN apt-get update -y

RUN apt-get install vim gcc make re2c libpcre3-dev autoconf autogen intltool libtool git php5-dev php5-fpm supervisor -y
RUN cd /opt && git clone --depth=1 https://github.com/json-c/json-c.git && cd json-c && sh autogen.sh && ./configure && make && make install

RUN cd /opt && git clone --depth=1 git://github.com/phalcon/cphalcon.git && cd cphalcon/build && git checkout phalcon-v2.0.7  && ./install

RUN cd /opt && git clone git@github.com:allegro/php-protobuf.git && cd php-protobuf
RUN phpize && ./configure && make install
RUN echo extension = protobuf.so >> /etc/php5/fpm/php.ini

ENV NGINX_VERSION 1.9.4-1~jessie
RUN apt-get install -y ca-certificates nginx=${NGINX_VERSION} && \
    rm -rf /var/lib/apt/lists/*

RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php5/fpm/php.ini
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php5/fpm/php-fpm.conf

RUN echo 'extension=/usr/lib/php5/20131226/phalcon.so' > /etc/php5/fpm/conf.d/20-phalcon.ini

ADD ./docker/fpm/www.conf /etc/php5/fpm/pool.d/www.conf
ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

ADD ./docker/supervisord/nginx.conf /etc/supervisor/conf.d/nginx.conf
ADD ./docker/supervisord/php5-fpm.conf /etc/supervisor/conf.d/php5-fpm.conf

RUN (cd /var/www && curl -sS https://getcomposer.org/installer | php && php composer.phar install)

EXPOSE 80 9001

VOLUME /var/www

CMD ["supervisord", "-n"]