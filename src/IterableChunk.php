<?php

declare(strict_types=1);

namespace Drom\IterableUtils;

use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @template-implements IteratorAggregate<int, array<int|TKey, TValue>>
 */
class IterableChunk implements IteratorAggregate
{
    /**
     * @psalm-var iterable<TKey, TValue> $itemsIterator
     */
    private iterable $itemsIterator;
    private int $chunkSize;
    private bool $preserveKeys;

    /**
     * @psalm-param iterable<TKey, TValue> $itemsIterator
     */
    public function __construct(iterable $itemsIterator, int $chunkSize, bool $preserveKeys = false)
    {
        if ($chunkSize <= 0) {
            throw new InvalidArgumentException("\$chunkSize must be positive integer");
        }

        $this->itemsIterator = $itemsIterator;
        $this->chunkSize = $chunkSize;
        $this->preserveKeys = $preserveKeys;
    }

    public function getIterator(): Traversable
    {
        $left = $this->chunkSize;
        $chunk = [];

        if ($this->preserveKeys) {
            foreach ($this->itemsIterator as $key => $item) {
                $chunk[$key] = $item;

                if (--$left <= 0) {
                    yield $chunk;
                    $left = $this->chunkSize;
                    $chunk = [];
                }
            }

            if ($chunk !== []) {
                yield $chunk;
            }

            return;
        }

        foreach ($this->itemsIterator as $item) {
            $chunk[] = $item;

            if (--$left <= 0) {
                yield $chunk;
                $left = $this->chunkSize;
                $chunk = [];
            }
        }

        if ($chunk !== []) {
            yield $chunk;
        }
    }
}
