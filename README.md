## Repository under development. Come back later :)

### About the project

The goal of the project is to provide example of micro-service (distributed) architecture powered by event sourcing. 

There are two main applications.
Read more about story around applications in `Domain Scenarios` section

#### Client
    
Application for client registration and managing.
Written with `DDD` style, using `Event Sourcing` with `CQRS` (part)
[Client](https://github.com/dgafka/event-sourcing-php/blob/develop/Client/README.md) writes all events to [Event Store](https://github.com/dgafka/event-sourcing-php/blob/develop/EventStore/README.md).
    
#### Banking

Application for money management. 
Written with clean `DDD` and Objective Oriented Mapper.
[Banking](https://github.com/madkom/event-sourcing-php/blob/feature/rancher/Banking/README.md)

### Domain Scenarios ###
When client is created in system, account associated with him is created also.
One client can only have one account.
Whenever new account is created it should receive new member bonus equal to 100$.

Users can transfer money between accounts, which result in debit client which started transaction and credit the one he chose send money to.
All transfers should be visible in transfer history.
All transfers should contain client data saved at the time when transfer was made.

User can be blocked.
Blocked client can't do anything in the system.
Blocked client can be reactivated, then he becomes normal client, with all operations on.
Blocked account should not be able to transfer any money out. Transfer in, should be still allowed.

User can become VIP.

There should be possibility to see whole client history (changes over time)

### Requirements

To run the project you need to have installed

1. [docker](https://www.docker.com/)
2. [docker-compose](https://docs.docker.com/compose/)
3. [rancher](http://rancher.com/)
4. [composer](https://getcomposer.org/)

## Installation

1. Run docker command `sudo docker run -d --restart=always -p 1111:8080 rancher/server`
	a) Find out your own IP for example `192.168.0.13`. You can use `ifconfig` command.
* I will use 192.168.0.13 as your IP, replace it with your own. (Do not use localhost or 127.0.0.1)
2. Go to `http://192.168.0.13:1080/infra/hosts`
	a) Click on `Add Host`
	b) Do not change settings and click `Save`
	c) Choose `Custom`, type of host
	d) Copy docker command and run it from your console
		for example: `sudo docker run -d --privileged -v /var/run/docker.sock:/var/run/docker.sock rancher/agent:v0.8.2 http://192.168.0.13:1111/v1/scripts/454960D9BDBB0F694D89:1443607200000:xtVhhKyVGRBeZxvUf4dN5HdjZ6s`
		and add env variable to the command:
`sudo docker run -e CATTLE_AGENT_IP=192.168.0.13 -d --privileged -v /var/run/docker.sock:/var/run/docker.sock rancher/agent:v0.8.2 http://192.168.0.13:1111/v1/scripts/454960D9BDBB0F694D89:1443607200000:xtVhhKyVGRBeZxvUf4dN5HdjZ6s`
3. Go to `http://192.168.0.13:1080/infra/hosts` and check, if host appeared. If it doesn't exists get back to the `point 1`.
4. Run `composer install` inside `Banking` and `Client` folders
5. Create `access key` on Rancher
6. Run with your access key information `rancher-compose --access-key {access_key} --secret-key {secret_key} --url {url} -p event_sourcing up`
7. Wait 2-5 minutes for everything to start and then run `sh startup.sh` from Banking/migration and Client/migration catalog.