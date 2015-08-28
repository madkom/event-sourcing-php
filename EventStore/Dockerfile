FROM debian:jessie
MAINTAINER Dariusz Gafka
ENV NOTVISIBLE "in users profile"
RUN apt-get update -y && apt-get install curl -y
RUN curl http://download.geteventstore.com/binaries/EventStore-OSS-Ubuntu-v3.1.0.tar.gz | tar xz -C /opt

RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 2113
EXPOSE 1113

VOLUME /data/db
VOLUME /data/logs

WORKDIR /opt/EventStore-OSS-Ubuntu-v3.1.0

CMD ./run-node.sh --ext-tcp-port=1113 --db /data/db --log /data/logs --add-interface-prefixes=false --ext-http-prefixes=http://*:2113/ --ext-ip=0.0.0.1 --run-projections=None