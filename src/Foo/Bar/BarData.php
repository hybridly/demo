<?php

namespace Foo\Bar;

use Spatie\LaravelData\Data;

final class BarData extends Data
{
    public function __construct(
        public readonly string $foo
    ) {}
}
