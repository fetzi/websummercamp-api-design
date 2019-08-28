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

In the first excerise we will implement a basic request logger that will log the API request with the accessed route, the query parameters and the response code of the API.

**Helpful Links:**
* [PSR-7 HTTP Message Interface](https://www.php-fig.org/psr/psr-7/)