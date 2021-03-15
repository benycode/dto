<?php

namespace BenyCode\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait DTOTrait
{
 
    abstract protected static function createFromArray(array $data): self;

    protected static function validationRules(): array
    {
        return [];
    }

    public static function fromArray(array $data): self
    {
        return static::createFromArray($data);
    }

    private static function mapArrayToDTO(string $dto, array $data): array
    {
        return array_map([$dto, 'fromArray'], $data);
    }

    private static function mapToArray(array $data): array
    {
        return array_map(static function (Arrayable $dto) {
            return $dto->toArray();
        }, $data);
    }

    private static function validate(): void
    {
        $validationRules = static::validationRules();
        $validator = Validator::make($this->toArray(), $validationRules);

        if ($validationRules && $validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function toArray(): array
    {
        return [];
    }
}
