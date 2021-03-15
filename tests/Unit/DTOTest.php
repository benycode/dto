<?php

declare(strict_types=1);

namespace BenyCode\DTO\Tests;

use Illuminate\Validation\ValidationException;
use BenyCode\DTO\Tests\Unit\DTOSamples\PostDTO;
use BenyCode\DTO\Tests\Unit\DTOSamples\UserDTO;
use Orchestra\Testbench\TestCase;

class DTOTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                'with correct data contract' => [
                    'id' => 1,
                    'name' => 'Alex',
                    'avatar_url' => 'http://google.com'
                ],
                false
            ],
            [
                'with invalid url' => [
                    'id' => 2,
                    'name' => 'Alex',
                    'avatar_url' => 'test'
                ],
                true
            ],
            [
                'with invalid id' => [
                    'id' => 'text id',
                    'name' => 'Alex',
                    'avatar_url' => 'http://google.com'
                ],
                true
            ],
            [
                'with empty data' => [],
                true
            ]
        ];
    }


    public function validatesCorrectly(array $data, bool $shouldThrowException): void
    {
        if ($shouldThrowException) {
            $this->expectException(ValidationException::class);
        }

        $dto = UserDTO::fromArray($data);

        $this->assertEquals($dto->toArray(), $data);
    }

    public function nestedDTOInstantiatesFromArray(): void
    {
        $data = [
            'id' => 1,
            'body' => 'test post',
            'user' => [
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ],
            'comments' => [
                ['id' => 1, 'text' => 'comment', 'author' => 'Alex']
            ]
        ];

        $post = PostDTO::fromArray($data);

        $this->assertSame($data, $post->toArray());
    }

    public function nestedDTOConvertsToJson(): void
    {
        $data = [
            'id' => 1,
            'body' => 'test post',
            'user' => [
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ],
            'comments' => [
                ['id' => 1, 'text' => 'comment', 'author' => 'Alex']
            ]
        ];

        $post = PostDTO::fromArray($data);

        $this->assertSame(json_encode($data), json_encode($post));


        try {
            $dto = UserDTO::fromArray([
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ]);
        } catch (ValidationException $exception) {
            dd($exception->errors());
        }
    }
}
