FROM debian:jessie
MAINTAINER Dariusz Gafka

ENV NOTVISIBLE "in users profile"
RUN apt-get update -y
RUN apt-get install curl -y
RUN curl https://apt-oss.geteventstore.com/eventstore.key | apt-key add -
RUN echo "deb [arch=amd64] https://apt-oss.geteventstore.com/ubuntu/ trusty v3.1.0" | tee /etc/apt/sources.list.d/eventstore.list
RUN apt-get install apt-transport-https -y
RUN apt-get update -y

RUN apt-get install eventstore-oss -y

RUN service eventstore start

RUN echo "export VISIBLE=now" >> /etc/profile

CMD ["service eventstore start"]