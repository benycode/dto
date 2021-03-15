<?php

namespace BenyCode\DTO\Tests\Unit\DTOSamples;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use JsonSerializable;
use BenyCode\DTO\DTOTrait;

class CommentDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    private int $id;

    private string $text;

    private string $author;

    public function __construct(int $id, string $text, string $author)
    {
        $this->id = $id;
        $this->text = $text;
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'text'),
            Arr::get($data, 'author')
        );
    }

    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'text' => 'required|string|max:500',
            'author' => 'required|string|max:255',
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'author' => $this->author
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
