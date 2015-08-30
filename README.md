## Repository under development. Come back later :)

### About the project

The goal of the project is to provide example micro-service powered by event sourcing architecture. 

There are two main applications.
Read more about story around applications in `Domain Scenarios` section

`Client`
    
    Application for user registration and managing.
    Written with DDD style, using Event Sourcing with CQRS (part)
    Client writes all events to Event Store
    (Read more)[Client/README.md]
    
Banking

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

User can become VIP, then he receives extra 50$.

There should be possibility to see whole user history (changes over time)

