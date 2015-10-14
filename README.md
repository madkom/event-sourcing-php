## Repository under development. Come back later :)

### About the project

The goal of the project is to provide example micro-service powered by event sourcing architecture. 

There are two main applications.
Read more about story around applications in `Domain Scenarios` section

#### Client
    
Application for user registration and managing.
Written with `DDD` style, using `Event Sourcing` with `CQRS` (part)
[Client](https://github.com/dgafka/event-sourcing-php/blob/develop/Client/README.md) writes all events to [Event Store](https://github.com/dgafka/event-sourcing-php/blob/develop/EventStore/README.md).
    
#### Banking

### Domain Scenarios ###
When user is created in system, account associated with him is created also.
Whenever new account is created it should receive new member bonus equal to 100$.

Users can transfer money between accounts, which result in debit user which started transaction and credit the one he chose send money to.
All transfers should be visible in transfer history.
All transfers should contain user data saved at the time when transfer was made.

User can be blocked.
Blocked user can't do anything in the system.
Blocked user can be reactivated, then he becomes normal user, with all operations on.
Blocked account should not be able to transfer any money out. Transfer in, should be still allowed.

User can become VIP.

There should be possibility to see whole user history (changes over time)

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
