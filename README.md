## Simple over engineered schedule REST API

This project is remastered, updated by 3 years version of: https://github.com/lmlynski/php-schedule-api

## Requirements

* Docker
* Git

## Installation

* Clone the repo `git clone git@github.com:lmlynski/php-schedule-api.git`

* Build using docker with docker

`docker-compose build && docker-compose up`

* Using composer (from docker php image) install all dependencies

`docker exec -it schedule_php composer install`

or separately

`docker exec -it schedule_php`

and then

`composer install`

...

And that's all!

## Usage

To see documentation and example usage of API calls, CURLs commands just go to Swagger UI page (you can also try using calls from there):

http://localhost:8088/docs

To run unit tests:

`bin/phpunit tests/`

If you have problems with mysql database create schema using sql from `docker/mysql/init_data.sql` file.

### Testing

To run tests:

```
$ make start
$ make build
$ make test
```

Or with one command make a full circle:

```
$ make all
```
