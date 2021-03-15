<?php

namespace BenyCode\DTO\Tests\Unit\DTOSamples;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use JsonSerializable;
use BenyCode\DTO\DTOTrait;

class UserDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    private int $id;

    private string $name;

    private string $avatarUrl;

    public function __construct(int $id, string $name, string $avatarUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'avatar_url')
        );
    }

    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'avatar_url' => 'required|string|url',
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar_url' => $this->avatarUrl
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
