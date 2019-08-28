# Websummercamp 2019 - Battle tested API design

## Installation

```
composer install
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