Birthday Book
=============
A php / Laravel app providing 2 API endpoints for storing and retrieving list of birthdays.

Dependencies
------------
Must have the following installed:

- docker
- docker-compose

To run
------
To bring the service up, run the following command::
    
    docker-compose up -d --build

To run tests::

    docker-compose exec app php artisan test

Web UI
------
To use the web UI, simply go to http://localhost:8080.

API
---
To add a birthday through API endpoint::
    
    curl http://localhost:8080/api/birthdays/add -d "name=Frank&birthdate=2000-01-01&tz=America/New_York" | jq


To retrieve a list of birthdays::

    curl http://localhost:8080/api/birthdays | jq
