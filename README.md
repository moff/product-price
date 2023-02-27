# Installation

- clone repository and cd into it
- run command `cp .env.example .env` and set credentials for databases (dev and test) in that file
- run command `docker stop $(docker ps -aq)` in order to ensure that other containers are stopped
- run command `docker-compose build` to build the application

After it's done cd into `application` directory and run following commands:
- run command `cp .env.example .env` and set credentials for development database in that file according to the credentials set before (also set DB_HOST variable to `mysql` so it can connect properly to Docker container)
- return to the root of the project and run command `docker-compose up -d` to run the application
- run command `docker-compose exec -u laravel app composer install`
- run command `docker-compose exec -u laravel app php artisan key:generate` to set the app key
- migrate development database `docker-compose exec -u laravel app php artisan migrate` or `make art migrate`

# Running tests

- cd into `application` directory
- run command `cp .env.testing.example .env.testing` and copy/set app key and set credentials for testing database in that file
- migrate testing database `docker-compose exec -u laravel app php artisan migrate --env=testing`

Run command `docker-compose exec -u laravel app php artisan test` to run tests, you can also use Makefile command `make test` for that

---

## Notes

Solution considers that a product can belong to only one category.

`variant_pricing_default` added to categories table as a default just in case, but domain wise it's better to have that in Product itself, so there is `variant_pricing` in products table.
Because if we have pricing logic definition in Product instead of Category, then we make logic more flexible.
Category is just an abstraction which is not related to products and their variants.
Having that we can have flexibility to have exceptions for products in the same category.

## Postman testing 

You can run `docker-compose exec -u laravel app php artisan db:seed` to have sample data.

List of products: GET `http://localhost:8082/api/products`
Set price endpoint: POST `http://localhost:8082/api/set-product-price`


