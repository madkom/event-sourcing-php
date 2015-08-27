FROM debian:jessie
MAINTAINER Dariusz Gafka
ENV NOTVISIBLE "in users profile"
RUN apt-get update -y && apt-get install curl -y
RUN curl http://download.geteventstore.com/binaries/EventStore-OSS-Ubuntu-v3.1.0.tar.gz | tar xz -C /opt

EXPOSE 2113
EXPOSE 1113

VOLUME /data/db
VOLUME /data/logs

WORKDIR /opt/EventStore-OSS-Ubuntu-v3.1.0

CMD ./run-node.sh --db /data/db --log /data/logs --ext-http-prefixes=http://127.0.0.1:2113/ --ext-ip=0.0.0.0