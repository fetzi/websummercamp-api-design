# Websummercamp 2019 - Battle tested API design

## Installation

```
composer install
```

## Migrating and seeding the database

```
composer db:migrate
composer db:seed
```

## Starting the API

```
composer start
```

To make sure everything is working out correctly, you need to access the following url: `http://localhost:8080/products`.

## Resources

* [Slim Framework](https://www.slimframework.com/docs/v4/)
* [Laravel Eloquent](https://laravel.com/docs/5.8/eloquent)

## Exercise 1 - Logger Middleware

In the first exercise we will implement a basic request logger that will log the API request with the accessed route, the query parameters and the response code of the API.

**Helpful links:**
* [PSR-7 HTTP Message Interface](https://www.php-fig.org/psr/psr-7/)

## Exercise 2 - API Tokens

In this exercise we will add a API token middleware that is responsible for checking the `X-API-Token` header value to be equal to `token`. If this check fails a 401 response with the error message `Invalid API token given` should be send to the client.

In addition the value of the API token should be passed on to the route handler as an attribute.

**Helpful links:**
* [Slim Middlewares](https://www.slimframework.com/docs/v4/concepts/middleware.html)

## Exercise 3 - JSON:API Responses

In this exercise we will focus on implementing the json:api format for the `/product-group` endpoint.

**Helpful links:**
* [json:api Specification](https://jsonapi.org/format/)
* [Yin Framework](https://github.com/woohoolabs/yin)

## Exercise 4 - JSON:API response for products

In this exercise we will focus on the `/products` resource. The goal is to implement the getAll (`/products`) and the getOne (`/products/{id}`) endpoints. The product resource(s) should be formatted in the json:api format and should include the `product-group` relation.

```json
{
    "jsonapi": {
        "version": "1.1"
    },
    "data": {
        "type": "product",
        "id": "1",
        "attributes": {
            "name": "Product 1",
            "price": 1000
        },
        "relationships": {
            "product-group": {
                "data": {
                    "type": "product-group",
                    "id": "1"
                }
            }
        }
    }
}
```

**Helpful links:**
* [Yin relationships](https://github.com/woohoolabs/yin#resources)

## Exercise 5 - Hydrators

This exercise will cover json:api hydrators which are used for creating and updating resource objects. At first we will implement the `POST` endpoint for products to create new products and then we will implement the `PATCH` endpoint to update resource data and its relationships.

**Helpful links:**
- [Yin hydrators](https://github.com/woohoolabs/yin#hydrators)