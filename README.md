# Installation

- clone repository and cd into it
- run command `cp .env.example .env` and set credentials for databases (dev and test) in that file
- run command `docker stop $(docker ps -aq)` in order to ensure that other containers are stopped
- run command `docker-compose build` to build the application

After it's done cd into `application` directory and run following commands:
- run command `cp .env.example .env` and set credentials for development database in that file according to the credentials set before
- run command `docker-compose up -d` to run the application
- run command `docker-compose exec -u laravel app php artisan key:generate` to set the app key
- migrate development database `docker-compose exec -u laravel app php artisan migrate` or `make art migrate`

# Running tests

- run command `cp .env.testing.example .env.testing` and copy/set app key and set credentials for testing database in that file
- migrate testing database `docker-compose exec -u laravel app php artisan migrate --env=testing`

Run command `docker-compose exec -u laravel app php artisan test` to run tests, you can also use Makefile command `make test` for that
