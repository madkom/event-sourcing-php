FROM debian:jessie
MAINTAINER Dariusz Gafka
ENV NOTVISIBLE "in users profile"
RUN apt-get update -y && apt-get install wget -y
RUN wget http://download.geteventstore.com/binaries/EventStore-OSS-Ubuntu-v3.1.0.tar.gz -O es.tar.gz | tar -xf -C /opt


WORKING DIR /opt/EventStore-OSS-Ubuntu-v3.1.0

CMD ./run-node.sh --db /data