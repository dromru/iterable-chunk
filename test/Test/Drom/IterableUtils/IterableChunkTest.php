<?php

declare(strict_types=1);

namespace Test\Drom\IterableUtils;

use Drom\IterableUtils\IterableChunk;
use Exception;
use Generator;
use PHPUnit\Framework\TestCase;

class IterableChunkTest extends TestCase
{
    private const CHUNKS = [[1, 2], [3, 4], [5]];
    private const CHUNKS_PRESERVED_KEYS = [[0 => 1, 1 => 2], [2 => 3, 3 => 4], [4 => 5]];

    /**
     * @test
     */
    public function iterableChunksOnArray(): void
    {
        self::assertSame(self::CHUNKS, [...new IterableChunk([1, 2, 3, 4, 5], 2)]);
    }

    /**
     * @test
     */
    public function iterableChunksOnArrayPreservedKeys(): void
    {
        self::assertSame(self::CHUNKS_PRESERVED_KEYS, [...new IterableChunk([1, 2, 3, 4, 5], 2, true)]);
    }

    /**
     * @test
     */
    public function doubleIterationsChunksOnArray(): void
    {
        $iterable = new IterableChunk([1, 2, 3, 4, 5], 2);

        self::assertSame([...self::CHUNKS, ...self::CHUNKS], [...$iterable, ...$iterable]);
    }

    /**
     * @test
     */
    public function iterableChunksOnGenerator(): void
    {
        self::assertSame(self::CHUNKS, [...new IterableChunk(self::createGenerator(), 2)]);
    }

    /**
     * @test
     */
    public function doubleIterationsChunksOnGeneratorThrowsException(): void
    {
        $iterable = new IterableChunk(self::createGenerator(), 2);

        $this->expectException(Exception::class);

        self::assertSame([...self::CHUNKS, ...self::CHUNKS], [...$iterable, ...$iterable]);
    }

    private static function createGenerator(): Generator
    {
        yield from [1, 2, 3, 4, 5];
    }
}
