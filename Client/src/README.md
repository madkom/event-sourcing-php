## Client Application

`Domain` - Most important layer in the application. Should contain high cohesion and be open for extending closed for modification.
All classes should hide their internal behaviour and abstract logic which is not revealed yet or actions, which going to be handle by 3rd party.
 
`Application` - Application layers act as place, which glue building blocks from domain layer together.
 What does it mean is, that it should take building blocks, which are necessary to complete some action and use them.
 Here caching, transactions, security should have it place. 

`Infrastructure` - Takes all abstracted classes from `Application` and `Domain` and implemenets it.

`UI` - User Interface Layer isn't just about GUI, but about interaction between client and server (application).
It may contains web gui/rest/soap or anything, which will help to communicate with the server.

`SharedKernel` - For example purposes created within project. 
In production ready project, should be placed as stand-alone library.
Which shared between production projects some classes like events, building blocks etc.