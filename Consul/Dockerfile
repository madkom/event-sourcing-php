FROM debian:jessie

RUN apt-get update -y && apt-get install supervisor curl wget unzip -y
ADD https://dl.bintray.com/mitchellh/consul/0.5.2_linux_amd64.zip /tmp/consul.zip
RUN (cd /tmp && ls -l && unzip consul.zip && mv consul /bin/consul)

ADD ./docker/supervisord/consul.conf /etc/supervisor/conf.d/consul.conf

EXPOSE 9001 8400 8500 8600

VOLUME /opt/consul

CMD ["supervisord", "-n"]