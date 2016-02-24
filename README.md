[![Build Status](https://travis-ci.org/rayrutjes/take-some-rest.svg)](https://travis-ci.org/rayrutjes/take-some-rest)
[![Code Quality](https://img.shields.io/scrutinizer/g/rayrutjes/take-some-rest.svg)](https://scrutinizer-ci.com/g/rayrutjes/take-some-rest/)

# Take Some Rest.

This is a very simple framework agnostic REST API implemented for demo purposes.

As the Users and Songs only need to be readable, we could have assumed that the data of these are part of another
service, out of the scope of the exercise. 
In the implementation I provide though, I chose to couple the Songs to the user's favorite song, and assumed that everything
is handled in the context of this service.

## Core concepts.

First of all, I did not focus on making the different bricks re-usable. The minimum required has been implemented
, for example, no more *getters* than required are implemented.

The Service layers may look like it adds some overhead, but decoupling the domain logic from the actual persistence layer
will allow us to easily add more behaviour without modifying the other layers. We could for example raise some events from the services, or add some logging. 
We could also imagine adding a caching overlay there.

Song, SongList and User are simple DTOs that are not involved in the actual domain logic.
The (Song|User)Services are the ones acting as anti corruption layers against the outside. That is where we would have found email validation for 
a new user that tries to register, but that is out of the scope of this demo.

We let the 'RayRutjes\Tsr\Http\Server' catch NotFoundException so as to return appropriate 404 responses. I agree to say that this is a very
simple way to handle this part, and that in a real world, we could use some kind of more flexible middleware approach.

### Http.

Contains basic classes to deal with Input/Output and routing the request.

### Persistence.

Definitions and implementations that allows the retrieval of the data for the different entities of the demo.

### Resource.

The resources are RESTFull controllers. Their only job for each action is to pipe the incoming data to a service,
and return a Response. If something fails let the upper levels handle the sending of the appropriate responses for now.

### Util.

Some very limited support classes.
 
## Api overview.

GET /users/:user_id Retrieve a User by its id.

GET /songs/:song_id Retrieve a Song by its id.

GET /users/:user_id/favorites Retrieve a list of favorited Songs for a User.

POST /users/:user_id/favorites Add a song to a User's favorite list. 

DELETE /users/:user_id/favorites/:song_id Remove a song from a User's favorite list. 


## What could largely be enhanced/changed in a real world scenario.

- Use value objects to ensure that all invariants are met.
- We chose not to fully return resources on POST and DELETE requests, these behaviour could interesting depending on the type of clients consuming the data.
- Actually, the User Favorited Songs persistence and retrieval layer is totally coupled to the Songs, which allow use JOIN queries to speed up retrieval.
If we imagine that this demo is some kind of microservice, and that the data for Users and Songs is not part of the current domain, we might consider decoupling these.
- MySQL schema is actually pretty simple, and might require some tweaking in some real world scenario.
- Add more tests, especially end to end tests with behat for example. I tested some endpoints with Postman though.
- We could make some of the UserFavoriteResource endpoints idempotent, for example, if we send a request to append a song to a user's favorite list and it already is, the we could 
consider the operation being a success. Actually it will fail because of MySQL constraints. This would need to be decided with the business experts.


## Requirements.

I used PHP 7 in this demo mainly because it allows to reduces the boilerplates required to validate primitive inputs.

Null Coalesce Operator, typed returns, variadic functions are also very nice to have.

## Installation.

We use composer in production only for the autoloading capabilities.

```bash
$ composer update --no-dev --optimize-autoloader
```

Customize the config for your environment.

```bash
$ cp config.sample.php config.php
```

Import the database schema in the `tsr` database. **your database must exist**:

```bash
$ mysql -u root -p tsr < resources/tsr_2016-02-24.sql
```

Use the built in php server to serve the rest endpoints.

```bash
$ php -S localhost:8080 -t ./public/ 
```

## Development.

Install dev dependencies.

```bash
$ composer update --dev
```

Run the tests.

```bash
$ vendor/bin/phpunit
```

**For the integration tests to work properly you must have imported the database schema as described in the installation part.**



