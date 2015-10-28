FROM debian:jessie
MAINTAINER Dariusz Gafka d.gafka@madkom.pl

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62
RUN echo "deb http://nginx.org/packages/mainline/debian/ jessie nginx" >> /etc/apt/sources.list
RUN apt-get update -y

RUN apt-get install vim gcc make re2c libpcre3-dev autoconf autogen intltool libtool git php5-dev php5-fpm supervisor php5-pgsql postgresql-client -y

ADD https://github.com/json-c/json-c/archive/master.tar.gz /opt/json-c.tar.gz
RUN (cd /opt && mkdir json-c && tar -xf json-c.tar.gz -C json-c --strip-components=1 && rm json-c.tar.gz)
RUN (cd /opt/json-c && sh autogen.sh && ./configure && make && make install)

ADD https://github.com/phalcon/cphalcon/archive/phalcon-v2.0.8.tar.gz /opt/cphalcon.tar.gz
RUN (cd /opt && mkdir cphalcon && tar -xf cphalcon.tar.gz -C cphalcon --strip-components=1 && rm cphalcon.tar.gz && cd /opt/cphalcon/build && ./install)

ADD https://github.com/allegro/php-protobuf/archive/master.tar.gz /opt/php-protobuf.tar.gz
RUN (cd /opt && mkdir php-protobuf && tar -xf php-protobuf.tar.gz -C php-protobuf --strip-components=1 && rm php-protobuf.tar.gz)
RUN (cd /opt/php-protobuf && phpize && ./configure && make install && echo extension = protobuf.so >> /etc/php5/fpm/php.ini && echo extension = protobuf.so >> /etc/php5/cli/php.ini)

RUN apt-get install -y ca-certificates nginx && \
    rm -rf /var/lib/apt/lists/*

RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php5/fpm/php.ini
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php5/fpm/php-fpm.conf

RUN echo 'extension=/usr/lib/php5/20131226/phalcon.so' > /etc/php5/fpm/conf.d/20-phalcon.ini
RUN echo 'extension=/usr/lib/php5/20131226/phalcon.so' > /etc/php5/cli/conf.d/20-phalcon.ini


ADD ./docker/fpm/www.conf /etc/php5/fpm/pool.d/www.conf
ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

ADD ./docker/supervisord/nginx.conf /etc/supervisor/conf.d/nginx.conf
ADD ./docker/supervisord/php5-fpm.conf /etc/supervisor/conf.d/php5-fpm.conf
ADD ./docker/supervisord/external-worker.conf /etc/supervisor/conf.d/external-worker.conf
ADD ./docker/supervisord/internal-worker.conf /etc/supervisor/conf.d/internal-worker.conf

ADD ./ /var/www

RUN (cd /var/www && curl -sS https://getcomposer.org/installer | php && php composer.phar install && rm composer.phar)

EXPOSE 80 9001

VOLUME /var/www

CMD ["supervisord", "-n"]