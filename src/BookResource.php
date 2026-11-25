<?php

declare(strict_types=1);

namespace LaravelExamples\ApiResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'author' => $this->whenLoaded('author', fn (): array => [
                'id' => (int) $this->author->id,
                'name' => $this->author->name,
            ]),
        ];
    }
}
