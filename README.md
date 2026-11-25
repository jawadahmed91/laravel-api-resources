# Laravel API Resources

Shape Eloquent JSON responses with Laravel API resources. This example uses Laravel 13 and PHP 8.3 or later.

## Try it

```sh
composer install
composer test
```

In a Laravel controller with a `Book` model and an `author` relationship, return `BookResource::collection(Book::query()->with('author')->paginate())`. The resource selects the public JSON fields and includes the author only if it was already loaded. Laravel supplies the pagination metadata.

## Add this to an existing Laravel project

1. Make sure your application has a `Book` model and an `author()` relationship.

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;

public function author(): BelongsTo
{
    return $this->belongsTo(Author::class);
}
```

2. Copy `src/BookResource.php` to `app/Http/Resources/BookResource.php`.
3. Change its namespace from `LaravelExamples\ApiResources` to `App\Http\Resources`.
4. Update the fields in `toArray()` so they match your model. Keep private database fields out of the returned array.
5. Load every relationship used by the resource in your controller. This avoids an extra query for every book.

```php
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

public function index(): AnonymousResourceCollection
{
    $books = Book::query()
        ->with('author')
        ->latest()
        ->paginate(20);

    return BookResource::collection($books);
}
```

6. Register the endpoint in `routes/api.php`.

```php
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index']);
```

7. Request `/api/books` and verify that each item contains `id`, `title`, and the loaded `author`, while internal fields stay hidden.
8. Copy the assertions from `tests/ExampleTest.php` into an HTTP or resource test in your project, update its namespace and imports, and run `php artisan test`.
9. Use `whenLoaded()` for optional relationships and eager-load only the relationships required by each endpoint.

Read the [Laravel documentation](https://laravel.com/docs/13.x/eloquent-resources).
