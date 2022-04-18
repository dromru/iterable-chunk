# iterable-chunk

[![Latest Stable Version](https://img.shields.io/packagist/v/dromru/iterable-chunk.svg?style=flat-square)](https://packagist.org/packages/dromru/iterable-chunk)
[![Tests](https://github.com/dromru/iterable-chunk/workflows/Tests/badge.svg)](https://github.com/dromru/iterable-chunk/actions)
[![Coverage Status](https://coveralls.io/repos/github/dromru/iterable-chunk/badge.svg?branch=master)](https://coveralls.io/github/dromru/iterable-chunk?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg?style=flat-square)](https://php.net/)

## Проблема

Нативная [array_chunk](https://www.php.net/manual/ru/function.array-chunk.php) не поддерживает `iterable`.
Реализация [ChunkedIterator](https://github.com/guzzle/guzzle3/blob/master/src/Guzzle/Iterator/ChunkedIterator.php)
от Guzzle уступает по скорости обхода данной реализации.

## Решение

`iterable-chunk` - пакет, который предоставляет класс для разбиения итерируемых коллекций `iterable` на пачки.

P.S. Реализован с использованием генераторов, поэтому до 8 раз
быстрее [ChunkedIterator](https://github.com/guzzle/guzzle3/blob/master/src/Guzzle/Iterator/ChunkedIterator.php).

## Benchmark

![](./assets/bench.png)

## Пример использования

```php

function getIterable(): iterable
{
    yield from [1, 2, 3, 4, 5];
}

$chunks = new IterableChunk(getIterable(), 2, true);

foreach ($chunks as $chunk) {
    print_r($chunk);
}
```

```text
[0 => 1, 1 => 2]
[2 => 3, 3 => 4]
[4 => 5]
```
