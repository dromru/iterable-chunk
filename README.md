# iterable-chunk

[![Latest Stable Version](https://img.shields.io/packagist/v/dromru/iterable-chunk.svg?style=flat-square)](https://packagist.org/packages/dromru/iterable-chunk)
[![Tests](https://github.com/dromru/iterable-chunk/workflows/Tests/badge.svg)](https://github.com/dromru/iterable-chunk/actions)
[![Coverage Status](https://coveralls.io/repos/github/dromru/iterable-chunk/badge.svg?branch=master)](https://coveralls.io/github/dromru/iterable-chunk?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg?style=flat-square)](https://php.net/)

Класс для разбиения итерируемых коллекций на пачки.

P.S. Реализован с использованием генераторов.

## Benchmark

![](./assets/bench.png)

## Пример использования

```php
$iterable = [1, 2, 3, 4, 5];

$chunks = new IterableChunk($iterable, 2, true);

foreach ($chunks as $chunk) {
    print_r($chunk);
}
```
```text
[0 => 1, 1 => 2]
[2 => 3, 3 => 4]
[4 => 5]
```

## Полезняки

```bash
composer run fix
composer run lint
composer run test

composer run phpstan
composer run phpunit
composer run phpmd
composer run phpcs
composer run php-cs-fixer
composer run phpcbf
composer run ecs
composer run ecs-fix
composer run bench
```
