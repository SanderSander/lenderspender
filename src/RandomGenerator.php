<?php

declare(strict_types=1);

namespace Acme;

class RandomGenerator implements RandomGeneratorInterface
{
    public function random(int $min = 0, ?int $max = null): int
    {
        return rand($min, $max);
    }
}
