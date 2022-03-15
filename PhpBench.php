<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

global $arr;
$arr = array_fill(0, 100, 1);

function iterArray()
{
    global $arr;
    return $arr;
}

function iterGener()
{
    global $arr;
    yield from $arr;
}

class PhpBench
{
    public function benchIterableChunkOnArray(): void
    {
        foreach (new \Drom\Iterable\IterableChunk(iterArray(), 7) as $chunk) {
        }
    }

    public function benchIterableChunkOnGenerator(): void
    {
        foreach (new \Drom\Iterable\IterableChunk(iterGener(), 7) as $chunk) {
        }
    }

    public function benchChunkedIteratorOnGenerator(): void
    {
        foreach (new ChunkedIterator(iterGener(), 7) as $chunk) {
        }
    }

    public function benchArrayChunkOnArray(): void
    {
        foreach (array_chunk(iterArray(), 7) as $chunk) {
        }
    }

    public function benchNoop(): void
    {
    }
}

/**
 * Pulls out chunks from an inner iterator and yields the chunks as arrays
 *
 * @link https://github.com/Guzzle3/iterator/blob/986b83a6a95e73bd8b238281b3292c91dbf68cdb/ChunkedIterator.php
 */
final class ChunkedIterator extends \IteratorIterator
{
    /**
     * @var int Size of each chunk
     */
    private int $chunkSize;
    /**
     * @var array Current chunk
     */
    private array $chunk;

    /**
     * @param \Traversable $iterator Traversable iterator
     * @param int $chunkSize Size to make each chunk
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(\Traversable $iterator, int $chunkSize)
    {
        if ($chunkSize < 0) {
            throw new \InvalidArgumentException("The chunk size must be equal or greater than zero; $chunkSize given");
        }

        parent::__construct($iterator);
        $this->chunkSize = $chunkSize;
    }

    public function rewind(): void
    {
        parent::rewind();
        $this->next();
    }

    public function next(): void
    {
        $this->chunk = [];
        for ($i = 0; $i < $this->chunkSize && parent::valid(); ++$i) {
            $this->chunk[] = parent::current();
            parent::next();
        }
    }

    public function current(): array
    {
        return $this->chunk;
    }

    public function valid(): bool
    {
        return !empty($this->chunk);
    }
}
