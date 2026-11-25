<?php

declare(strict_types=1);

namespace LaravelExamples\ApiResources;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class ExampleTest extends TestCase
{
    private function book(): Model
    {
        return (new class extends Model {})->forceFill([
            'id' => 1, 'title' => 'Garden Notes', 'internal_reference' => 'catalog-7',
        ]);
    }

    public function testItOmitsUnloadedRelationsAndInternalFields(): void
    {
        $resource = new BookResource($this->book());

        self::assertSame(['id' => 1, 'title' => 'Garden Notes'], $resource->resolve(new Request()));
    }

    public function testItIncludesAnAuthorOnlyWhenLoaded(): void
    {
        $author = (new class extends Model {})->forceFill(['id' => 2, 'name' => 'Example Author']);
        $book = $this->book()->setRelation('author', $author);

        self::assertSame(
            ['id' => 2, 'name' => 'Example Author'],
            (new BookResource($book))->resolve(new Request())['author'],
        );
    }
}
