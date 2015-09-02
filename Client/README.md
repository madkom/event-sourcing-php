## Client Application
    
### About the application
    
Application is written with `DDD` + `Event Sourcing` + `CQRS` (part) in mind.
For REST UI (Phalcon2)[https://phalconphp.com/pl/] is used, since it has the fastest request/response time from all frameworks right now. 
Domain is based (broadway)[https://github.com/qandidate-labs/broadway] framework
It stores all events in (EventStore)[http://docs.geteventstore.com/].

### About the layers

`Domain` - Most important layer in the application. Should contain high cohesion and be open for extending closed for modification.
All classes should hide their internal behaviour and abstract logic which is not revealed yet or actions, which going to be handle by 3rd party.
 
`Application` - Application layers act as place, which glue building blocks from domain layer together.
 What does it mean is, that it should take building blocks, which are necessary to complete some action and use them.
 Here caching, transactions, security should have it place. 

`Infrastructure` - Takes all abstracted classes from `Application` and `Domain` and implements it.

`UI` - User Interface Layer isn't just about GUI, but about interaction between client and server (application).
It may contains web gui/rest/soap or anything, which will help to communicate with the server.

`SharedKernel` - For example purposes created within project. 
In production ready project, should be placed as stand-alone library.
Which shared between production projects some classes like events, building blocks etc.


## Rest API

   IP: localhost:3002/


### Write Model

`register` - Creates new client in the system.
 
    @param "name"  
    @param "surname"
    
    @return client's ID
     
`changedata` - Change client's data 

    @param "id" - Client's ID
    @param "name"  
    @param "surname"
        
    @return void
        
`changestatus` - Changes client's status. After registration client status is 0. Disables all other actions till status = 1

    @param "id"
    @param "status" - [0 - active, 1 - blocked]
    
`makevip` - Make client a vip

    @param "id"