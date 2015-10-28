## Banking Application 

### About the application

`Banking App` works with `Client App`. 
It listen for events created by `Client App`. 

#### External Events - comes from Client App to Banking

Whenever new new Client is created new associated account is created in reaction.
`Madkom\ES\Banking\UI\Worker\External\SynchronizeEvents` take care of synchronization. 

#### Internal Events - comes from Banking to Banking

In reaction for money transfer, worker takes the money and pushes it target account.
`Madkom\ES\Banking\UI\Worker\Internal\EventHandler` - is responsible for retrieving events and react


### About the layers

`Domain` - Most important layer in the application. Should contain high cohesion and be open for extending closed for modification.
All classes should hide their internal behaviour and abstract logic which is not revealed yet or actions, which going to be handle by 3rd party.
 Banking domain is based on clean DDD with mapping to ORM Mapper. 
 
`Application` - Application layers act as place, which glue building blocks from domain layer together.
 What does it mean is, that it should take building blocks, which are necessary to complete some action and use them.
 Here caching, transactions, security should have it place. 

`Infrastructure` - Takes all abstracted classes from `Application` and `Domain` and implements it.

`UI` - User Interface Layer isn't just about GUI, but about interaction between client and server (application).
It may contains web gui/rest/soap or anything, which will help to communicate with the server.

`SharedKernel` - For example purposes created within project. 
In production ready project, should be placed as stand-alone library.
Which shared between production projects some classes like events, building blocks etc.


### Write Model (Rest API)

`transferout` [POST] - Transfers out passed amount of money from one account to account
    
    @param "from_account" - From which account money should be taken  
    @param "to_account" - To which account money should be send
    @param "money_amount" - 
    
    @return void
    
    
### Read Model (Rest API)

`accountbyid` [GET] - Retrieves account by account ID

    @param "id" - Account ID
    
    @return json
    
`accountbyclientid` [GET] - Retrieves account by client ID

    @param "id" - Client ID
    
    @return json
    
`transfers` [GET] - Retrieves transfers for account

    @param "id" - Account ID
    
    @return json
    