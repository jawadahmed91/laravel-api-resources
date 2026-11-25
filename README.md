# Laravel API Resources

Shape Eloquent JSON responses with Laravel API resources. This example uses Laravel 13 and PHP 8.3 or later.

## Try it

```sh
composer install
composer test
```

In a Laravel controller with a `Book` model and an `author` relationship, return `BookResource::collection(Book::query()->with('author')->paginate())`. The resource selects the public JSON fields and includes the author only if it was already loaded. Laravel supplies the pagination metadata.

Read the [Laravel documentation](https://laravel.com/docs/13.x/eloquent-resources).
