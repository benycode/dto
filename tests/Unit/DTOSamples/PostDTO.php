<?php

namespace BenyCode\DTO\Tests\Unit\DTOSamples;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use JsonSerializable;
use BenyCode\DTO\DTOTrait;

class PostDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    private int $id;

    private string $body;

    private UserDTO $user;

    private CommentDTO $comments;

    public function __construct(int $id, string $body, UserDTO $user, array $comments)
    {
        $this->id = $id;
        $this->body = $body;
        $this->user = $user;
        $this->comments = $comments;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUser(): UserDTO
    {
        return $this->user;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'body'),
            UserDTO::fromArray(Arr::get($data, 'user')),
            self::mapArrayToDTO(
                CommentDTO::class,
                Arr::get($data, 'comments', [])
            )
        );
    }

    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'body' => 'required|string|max:500',
            'user' => 'required'
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user->toArray(),
            'comments' => self::mapToArray($this->comments)
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
